<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'McOrder') }} - {{ $menu->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main-css.css') }}">

    <style>
        /* Default ingredient card — deselected */
        .ingredient-card {
            border: 2.5px solid #e0e0e0;
            border-radius: 16px;
            padding: 12px;
            text-align: center;
            background: white;
            opacity: 0.5;
        }
        /* Selected ingredient card */
        .ingredient-card.selected {
            border-color: #FFC72C;
            opacity: 1;
            box-shadow: 0 4px 16px rgba(255,199,44,0.3);
        }
        /* Meat card — always selected, not removable */
        .ingredient-card.locked {
            border-color: #DA291C;
            opacity: 1;
            box-shadow: 0 4px 16px rgba(218,41,28,0.2);
        }
        .ingredient-img {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 8px;
        }
        .ingredient-name {
            font-size: 13px;
            font-weight: 600;
            color: #2d2d2d;
        }
        .ingredient-price {
            font-size: 12px;
            color: #DA291C;
            font-weight: 600;
        }

        /* Hide the real checkbox but keep it functional */
        .ingredient-checkbox {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
            margin: 0;
        }

        /* Wrapper needs position relative for the checkbox overlay */
        .ingredient-wrapper {
            position: relative;
        }

        /* Checked state — yellow border */
        .ingredient-checkbox:checked + .ingredient-card {
            border-color: #FFC72C;
            opacity: 1;
            box-shadow: 0 4px 16px rgba(255,199,44,0.3);
        }

        /* Unchecked state — grey and faded */
        .ingredient-checkbox:not(:checked) + .ingredient-card {
            border-color: #e0e0e0;
            opacity: 0.5;
            box-shadow: none;
        }

        /* Locked (meat) always red border */
        .ingredient-checkbox:disabled + .ingredient-card {
            border-color: #DA291C;
            opacity: 1;
            cursor: not-allowed;
            box-shadow: 0 4px 16px rgba(218,41,28,0.2);
        }
    </style>
</head>
<body>
    <div class="bg-overlay"></div>

    {{-- Cancel order button top right --}}
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

            {{-- LEFT: burger info --}}
            <div class="col-md-4">
                <div class="card p-4 text-center h-100 d-flex flex-column justify-content-center">
                    <img src="{{ asset('img/' . $menu->image) }}"
                         alt="{{ $menu->name }}"
                         style="width:100%; max-height:200px; object-fit:contain; margin-bottom:16px;">
                    <h2 class="brand-title">{{ $menu->name }}</h2>
                    <p class="text-muted">{{ $menu->description }}</p>
                    <div style="color:#DA291C; font-size:28px; font-weight:700;">
                        From €{{ number_format($menu->base_price, 2) }}
                    </div>
                    <a href="{{ route('menus.index') }}" class="btn btn-outline-mcdonald mt-3">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>

            {{-- RIGHT: ingredient selector --}}
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <h3 class="mb-4 text-center">
                        Customize your burger
                    </h3>

                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        {{-- Send menu id with the form --}}
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                        <div class="row g-3">
                            @foreach($menu->ingredients as $ingredient)
                                @php
                                    $isMeat = $ingredient->image === 'meat.png';
                                    $isSelected = $isMeat || !$ingredient->is_extra;
                                @endphp

                                <div class="col-4">
                                    <label class="ingredient-wrapper d-block">
                                        
                                        @if($isMeat)
                                            {{-- 1. Truco para la carne: input oculto para que SIEMPRE se envíe a la base de datos --}}
                                            <input type="hidden" name="ingredients[]" value="{{ $ingredient->id }}">
                                            {{-- Este checkbox visual solo sirve para pintar el diseño de CSS, está marcado y no envía datos repetidos --}}
                                            <input type="checkbox" class="ingredient-checkbox" checked disabled>
                                        @else
                                            {{-- 2. Tus ingredientes normales quedan igual pero sin romper nada --}}
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

                        {{-- Place order button --}}
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