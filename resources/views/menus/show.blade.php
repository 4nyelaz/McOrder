<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'McOrder') }} - {{ $menu->name }}</title>

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

    <!-- 5% DISCOUNT CHECK (matches the controller logic) -->
    @php
        $hasDiscount = session('new_user');
        $discountedPrice = $hasDiscount ? $menu->base_price * 0.95 : $menu->base_price;
    @endphp

    <!-- Cancel order button top right -->
    <div style="position:fixed; top:16px; right:16px; z-index:10;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-mcdonald btn-sm">
                <i class="fas fa-times me-2"></i>Cancel Order
            </button>
        </form>
    </div>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 g-4 justify-content-center">

            <!-- LEFT COLUMN: Burger Info -->
            <div class="col-md-4">
                <div class="card p-4 text-center h-100 d-flex flex-column justify-content-center">
                    <img src="{{ asset('img/' . $menu->image) }}"
                         alt="{{ $menu->name }}"
                         style="width:100%; max-height:200px; object-fit:contain; margin-bottom:16px;">
                    <h2 class="brand-title">{{ $menu->name }}</h2>
                    <p class="text-muted">{{ $menu->description }}</p>
                    
                    <!-- PRICE WITH 5% DISPLAY -->
                    <div style="color:#DA291C; font-size:28px; font-weight:700;">
                        @if($hasDiscount)
                            <!-- Show discounted price (base_price - 5%) -->
                            From €{{ number_format($discountedPrice, 2) }}
                            <!-- Show original price crossed out -->
                            <span style="font-size:16px; color:#6c757d; text-decoration:line-through; margin-left:8px;">
                                €{{ number_format($menu->base_price, 2) }}
                            </span>
                            <!-- 5% discount badge -->
                            <span class="badge ms-2" 
                                  style="background:#FFC72C; color:#DA291C; font-size:12px; vertical-align:middle;">
                                -5%
                            </span>
                        @else
                            <!-- No discount - show regular price -->
                            From €{{ number_format($menu->base_price, 2) }}
                        @endif
                    </div>
                    
                    <a href="{{ route('menus.index') }}" class="btn btn-outline-mcdonald mt-3">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>

            <!-- RIGHT COLUMN: Ingredient Selector -->
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <h3 class="mb-4 text-center">
                        Customize your burger
                    </h3>

                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <!-- Send menu id with the form -->
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        

                        <div class="row g-3">
                            @foreach($menu->ingredients as $ingredient)
                                @php
                                    $isMeat = $ingredient->image === 'meat.png';
                                    $isSelected = $isMeat || !$ingredient->is_extra;
                                @endphp

                                <div class="col-4">
                                    <label class="ingredient-wrapper d-block">
                                        
                                        <!-- MEAT INGREDIENT (Always selected, can't be removed) -->
                                        @if($isMeat)
                                            <!-- Hidden input that ALWAYS sends meat to database -->
                                            <input type="hidden" name="ingredients[]" value="{{ $ingredient->id }}">
                                            <!-- Visual checkbox (disabled, just for CSS styling) -->
                                            <input type="checkbox" class="ingredient-checkbox" checked disabled>
                                        
                                        <!-- REGULAR INGREDIENTS -->
                                        @else
                                            <input type="checkbox"
                                                class="ingredient-checkbox"
                                                name="ingredients[]"
                                                value="{{ $ingredient->id }}"
                                                {{ $isSelected ? 'checked' : '' }}>
                                        @endif

                                        <div class="ingredient-card {{ $isMeat ? 'locked' : '' }}">
                                            <img src="{{ asset('img/' . $ingredient->image) }}"
                                                alt="{{ $ingredient->name }}"
                                                class="ingredient-img">
                                            <div class="ingredient-name">{{ $ingredient->name }}</div>
                                            @if($ingredient->is_extra)
                                                <div class="ingredient-price">+€{{ number_format($ingredient->extra_price, 2) }}</div>
                                            @else
                                                <div class="ingredient-price" style="color:#28a745;">Included</div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- ORDER BUTTON -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-mcdonald" style="font-size:18px; padding:14px;">
                                    Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>