<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'menu_id'     => 'required|exists:menus,id',
            'ingredients' => 'array',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        // Get the selected ingredient models using the IDs from the form
        $selectedIngredients = $menu->ingredients()
            ->whereIn('id', $request->ingredients ?? [])
            ->get();

        // Calculate extras price by summing only the extra ingredients
        $extrasPrice = $selectedIngredients
            ->where('is_extra', true)
            ->sum('extra_price');

        // Apply 5% discount if user just registered (stored in session)
        $discount = session('new_user') ? round(($menu->base_price + $extrasPrice) * 0.05, 2) : 0;
        $total = $menu->base_price + $extrasPrice - $discount;

        // Delete previous order — 1:1 relation: one user can only have one order
        Order::where('user_id', Auth::id())->delete();

        // Save ingredient names as a comma separated string
        $ingredientsString = $selectedIngredients->pluck('name')->implode(',');

        $order = Order::create([
            'user_id'              => Auth::id(),
            'menu_id'              => $menu->id,
            'base_price'           => $menu->base_price,
            'extras_price'         => $extrasPrice,
            'discount'             => $discount,
            'total'                => $total,
            'order_number'         => $menu->id,
            'selected_ingredients' => $ingredientsString,
        ]);

        // Clear the new user discount from session after use
        session()->forget('new_user');

        return redirect()->route('orders.show', $order);
    }

    // Show the order ticket
    public function show(Order $order)
    {
        $order->load('menu');
        return view('orders.show', compact('order'));
    }
}