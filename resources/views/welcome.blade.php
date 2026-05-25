<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'McOrder') }} - Access</title>
    
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
    
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card p-4 p-md-5 text-center">
                    <!-- Logo -->
                    <div class="mb-3">
                        <i class="fas fa-hamburger logo-icon m-logo"></i>
                    </div>

                    <h1 class="brand-title">McOrder</h1>
                    <p class="brand-subtitle mb-4">Log in or sign up to continue</p>
                    
                    <!-- Buttons -->
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-mcdonald">
                            <i class="fas fa-sign-in-alt me-2"></i>Log In
                        </a>
                        <a href="" class="btn btn-outline-mcdonald">
                            <i class="fas fa-user-plus me-2"></i>Sign up
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>