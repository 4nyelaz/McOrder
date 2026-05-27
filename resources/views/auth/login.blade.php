<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'McOrder') }} - Login</title>

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
            <div class="col-md-5 col-lg-4">
                <!-- Going back to home -->
                <div class="text-left mb-3">
                    <a href="{{ route('home') }}" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
                <div class="card p-4 p-md-5">

                     <!-- Logo and title  -->
                    <div class="text-center mb-4">
                        <i class="fas fa-hamburger logo-icon"></i>
                        <h1 class="brand-title">McOrder</h1>
                    </div>

                     <!-- Session error (wrong credentials)  -->
                    @if(session('status'))
                        <div class="alert alert-success rounded-3 mb-3">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!--  Email  -->
                        <div class="mb-3">
                            <label class="form-label fw-600">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" autofocus
                                   class="form-control rounded-3 @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         <!-- Password  -->
                        <div class="mb-3">
                            <label class="form-label fw-600">
                                Password
                            </label>
                            <input type="password" name="password"
                                   class="form-control rounded-3 @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-mcdonald">
                                <i class="fas fa-sign-in-alt me-2"></i>Log In
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