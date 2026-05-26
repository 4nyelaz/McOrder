<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'menu_id', 'base_price',
        'extras_price', 'discount', 'total', 'order_number'
    ];

    // 1-to-1 inverse: this order belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-1 inverse: this order belongs to one menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}