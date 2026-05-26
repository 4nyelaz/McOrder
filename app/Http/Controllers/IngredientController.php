<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Menu;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    // Form to add an ingredient to a menu
    public function create(Menu $menu)
    {
        return view('ingredients.create', compact('menu'));
    }

    // Save validated ingredient
    public function store(Request $request, Menu $menu)
    {
        $datos = $request->validate([
            'name'        => 'required|max:255',
            'is_extra'    => 'boolean',
            'extra_price' => 'nullable|numeric|min:0',
        ]);

        $menu->ingredients()->create([
            'name'        => $datos['name'],
            'is_extra'    => $request->has('is_extra'),
            'extra_price' => $datos['extra_price'] ?? 0,
        ]);

        return redirect()->route('menus.show', $menu)->with('success', 'Ingrediente añadido.');
    }

    // Delete Ingredient
    public function destroy(Menu $menu, Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('menus.show', $menu)->with('success', 'Ingrediente eliminado.');
    }
}