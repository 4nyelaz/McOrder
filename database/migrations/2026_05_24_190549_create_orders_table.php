<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // 1-to-1 with users: one user has one active order
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->onDelete('cascade');
            // Many-to-1 with menus: one menu can have many orders
            $table->foreignId('menu_id')
                ->constrained()
                ->onDelete('cascade');
            $table->decimal('base_price', 8, 2);
            $table->decimal('extras_price', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            // Unique order number shown on the ticket (e.g. MC-00042)
            $table->string('order_number')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};