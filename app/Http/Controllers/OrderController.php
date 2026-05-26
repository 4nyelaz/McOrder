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
        $request->validate([
            'menu_id'      => 'required|exists:menus,id',
            'ingredients'  => 'array',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        // 1. Buscamos los ingredientes reales usando los IDs que vienen del formulario
        $selectedIngredientsCollection = $menu->ingredients()
            ->whereIn('id', $request->ingredients ?? [])
            ->get();

        // 2. Calculamos los extras sumando los precios de la colección
        $extrasPrice = $selectedIngredientsCollection
            ->where('is_extra', true)
            ->sum('extra_price');

        $discount = session('new_user') ? round(($menu->base_price + $extrasPrice) * 0.05, 2) : 0;
        $total = $menu->base_price + $extrasPrice - $discount;
        $orderNumber = 'MC-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        Order::where('user_id', Auth::id())->delete();

        // 3. Extraemos solo los NOMBRES de los ingredientes y los unimos con comas
        $ingredientsNamesString = $selectedIngredientsCollection->pluck('name')->implode(',');

        $order = Order::create([
            'user_id'              => Auth::id(),
            'menu_id'              => $menu->id,
            'base_price'           => $menu->base_price,
            'extras_price'         => $extrasPrice,
            'discount'             => $discount,
            'total'                => $total,
            'order_number'         => $orderNumber,
            'selected_ingredients' => $ingredientsNamesString 
        ]);

        session()->forget('new_user');

        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order)
    {
        $order->load('menu');
        return view('orders.show', compact('order'));
    }
}