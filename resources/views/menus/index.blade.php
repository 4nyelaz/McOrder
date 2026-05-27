<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'McOrder') }} - Menu</title>

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

    <div style="position:fixed; top:16px; right:16px; z-index:10;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-mcdonald btn-sm">
                Cancel Order
            </button>
        </form>
    </div>

    <div class="container min-vh-100 d-flex flex-column align-items-center justify-content-center py-5">

         <!-- Greeting  -->
        <div class="text-center mb-5">
             <!-- Auth::user()->name gets the logged in user's name  -->
            <h1 style="font-size:2.2rem; font-weight:700; color:white;">
                Hello {{ Auth::user()->name }}, what do you feel like 
                <span style="color:#FFC72C;">eating?</span>
            </h1>
             <!-- Show 5% discount badge if user just registered (stored in session)  -->
            @if(session('new_user'))
                <span class="badge mt-2 px-3 py-2" 
                      style="background:#FFC72C; color:#DA291C; font-size:14px; border-radius:20px;">
                    <i class="fas fa-tag me-1"></i>5% discount applied to your first order!
                </span>
            @endif
        </div>

         <!-- 3 menu cards  -->
        <div class="row g-4 justify-content-center">
            @foreach($menus as $menu)
                 <!-- Calculate discounted price if new user  -->
                @php
                    $displayPrice = session('new_user') 
                        ? $menu->base_price * 0.95  // 5% discount
                        : $menu->base_price;
                @endphp

                 <!-- Each card links to the customize view  -->
                <div class="col-md-4">
                    <a href="{{ route('menus.show', $menu) }}" class="text-decoration-none">
                        <div class="card p-4 text-center h-100 d-flex flex-column justify-content-between"
                             style="cursor:pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 48px rgba(0,0,0,0.15)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.1)';">

                             <!-- Burger image  -->
                            <img src="{{ asset('img/' . $menu->image) }}" 
                                 alt="{{ $menu->name }}"
                                 style="width:100%; height:180px; object-fit:contain; margin-bottom:16px;">

                             <!-- Name  -->
                            <h3 class="mb-1">{{ $menu->name }}</h3>

                             <!-- Description  -->
                            <p class="text-muted mb-3">{{ $menu->description }}</p>

                             <!-- Price with discount if applicable -->
                            <div style="color:#DA291C; font-size:24px; font-weight:700;">
                                {{ number_format($displayPrice, 2) }}€
                                
                                 <!-- Show original price crossed out if discounted  -->
                                @if(session('new_user'))
                                    <span style="font-size:14px; color:#6c757d; text-decoration:line-through; margin-left:8px;">
                                        {{ number_format($menu->base_price, 2) }}€
                                    </span>
                                @endif
                            </div>

                             <!-- Customize button  -->
                            <div class="mt-3">
                                <span class="btn btn-mcdonald btn-sm">
                                    Customize
                                </span>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>