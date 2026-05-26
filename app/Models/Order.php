<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Ingredient;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'base_price',
        'extras_price',
        'discount',
        'total',
        'order_number',
        'selected_ingredients',
    ];

    public function getSelectedIngredientsAttribute()
    {
        // Access raw value from attributes array to avoid recursive call
        $raw = $this->attributes['selected_ingredients'] ?? '';

        if (empty($raw)) {
            return collect();
        }

        $namesArray = explode(',', $raw);

        return $this->menu->ingredients()->whereIn('name', $namesArray)->get();
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}