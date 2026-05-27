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
        $menus = Menu::with(['ingredients'])->get();
        return view('menus.index', compact('menus'));
    }

    // See menu details
    public function show(Menu $menu)
    {
        $menu->load(['ingredients']);
        return view('menus.show', compact('menu'));
    }
    
}