<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // List of all menus
    public function index()
    {
        $menus = Menu::with(['ingredients', 'nutritionInfo'])->get();
        return view('menus.index', compact('menus'));
    }

    // Create form
    public function create()
    {
        return view('menus.create');
    }

    // Save a new menu with authentication
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'required',
            'base_price'  => 'required|numeric|min:0',
            'image'       => 'nullable|url',
            // Nutrition
            'calories'    => 'required|integer|min:0',
            'proteins'    => 'required|integer|min:0',
            'fats'        => 'required|integer|min:0',
        ]);

        $menu = Menu::create([
            'name'        => $datos['name'],
            'description' => $datos['description'],
            'base_price'  => $datos['base_price'],
            'image'       => $datos['image'] ?? null,
        ]);

        // Info nutritional extra linked to menu
        $menu->nutritionInfo()->create([
            'calories' => $datos['calories'],
            'proteins' => $datos['proteins'],
            'fats'     => $datos['fats'],
        ]);

        return redirect()->route('menus.index')->with('success', 'Menú creado correctamente.');
    }

    // See menu details
    public function show(Menu $menu)
    {
        $menu->load(['ingredients', 'nutritionInfo']);
        return view('menus.show', compact('menu'));
    }

    // Edit a menu
    public function edit(Menu $menu)
    {
        $menu->load('nutritionInfo');
        return view('menus.edit', compact('menu'));
    }

    // Update menu with athentication
    public function update(Request $request, Menu $menu)
    {
        $datos = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'required',
            'base_price'  => 'required|numeric|min:0',
            'image'       => 'nullable|url',
            'calories'    => 'required|integer|min:0',
            'proteins'    => 'required|integer|min:0',
            'fats'        => 'required|integer|min:0',
        ]);

        $menu->update([
            'name'        => $datos['name'],
            'description' => $datos['description'],
            'base_price'  => $datos['base_price'],
            'image'       => $datos['image'] ?? null,
        ]);

        // Update nutritional info
        $menu->nutritionInfo()->updateOrCreate(
            ['menu_id' => $menu->id],
            [
                'calories' => $datos['calories'],
                'proteins' => $datos['proteins'],
                'fats'     => $datos['fats'],
            ]
        );

        return redirect()->route('menus.index')->with('success', 'Menú actualizado correctamente.');
    }

    // Delete menu
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menú eliminado.');
    }
}