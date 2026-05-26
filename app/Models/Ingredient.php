<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['menu_id', 'name', 'is_extra', 'extra_price'];

    // Inversa: un ingrediente pertenece a un menú
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}