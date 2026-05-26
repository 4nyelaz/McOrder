<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'description', 'base_price', 'image'];

    // 1 : N --> one menu can appear in many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // 1 : N --> one menu has many ingredients
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}