<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'McOrder') }} - Order {{ $order->order_number }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('css/main-css.css') }}" />
</head>
<body>
    <div class="bg-overlay"></div>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5 ">
        <div class="ticket">

            <!-- Header  -->
            <div class="text-center mb-4">
                <i class="fas fa-hamburger logo-icon"></i>
                <h1 class="brand-title">McOrder</h1>
                <p class="brand-subtitle">Your order is confirmed!</p>
            </div>

            <hr class="ticket-separator">

            <!-- Order number -->
            <div class="text-center mb-3">
                <div class="ticket-label">Order Number</div>
                <div class="order-number">{{ $order->order_number }}</div>
            </div>

            <hr class="ticket-separator">

            <!-- Customer  -->
            <div class="d-flex justify-content-between mb-2">
                <span class="ticket-label">Customer</span>
                <span class="ticket-value">{{ Auth::user()->name }}</span>
            </div>

            <!-- Menu  -->
            <div class="d-flex justify-content-between mb-2">
                <span class="ticket-label">Menu</span>
                <span class="ticket-value">{{ $order->menu->name }}</span>
            </div>

            <hr class="ticket-separator">

            <!-- Selected ingredients  -->
            <div class="mb-2">
                <div class="ticket-label mb-2">Ingredients</div>
                @foreach($order->selectedIngredients as $ingredient)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="ticket-value" style="font-size:14px;">
                            {{ $ingredient->name }}
                        </span>
                        <span style="font-size:14px; color:{{ $ingredient->is_extra ? '#DA291C' : '#28a745' }}; font-weight:600;">
                            {{ $ingredient->is_extra ? '+€' . number_format($ingredient->extra_price, 2) : 'Included' }}
                        </span>
                    </div>
                @endforeach
            </div>

            <hr class="ticket-separator">

             <!-- Price  -->
            <div class="d-flex justify-content-between mb-2">
                <span class="ticket-label">Base price</span>
                <span class="ticket-value">€{{ number_format($order->base_price, 2) }}</span>
            </div>

            @if($order->extras_price > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="ticket-label">Extras</span>
                    <span class="ticket-value">+€{{ number_format($order->extras_price, 2) }}</span>
                </div>
            @endif

            @if($order->discount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="ticket-label">Discount (5%)</span>
                    <span class="ticket-value" style="color:#28a745;">-€{{ number_format($order->discount, 2) }}</span>
                </div>
            @endif

            <hr class="ticket-separator">

             <!-- Total  -->
            <div class="d-flex justify-content-between mb-4">
                <span style="font-size:18px; font-weight:700; color:#2d2d2d;">TOTAL</span>
                <span style="font-size:24px; font-weight:700; color:#DA291C;">
                    €{{ number_format($order->total, 2) }}
                </span>
            </div>

            <!-- Complete order — logs out after paying  -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="d-grid">
                    <button type="submit" class="btn btn-mcdonald" style="font-size:18px; padding:14px;">
                        <i class="fas fa-check me-2"></i>Complete Order
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>