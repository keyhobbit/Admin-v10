<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AFK Game CMS - Idle RPG Adventure')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-color);
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            margin: 0 0.5rem;
            transition: all 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .btn-login {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-register {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 5rem;
        }

        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* User dropdown */
        .user-dropdown {
            background: rgba(255,255,255,0.2);
            border-radius: 25px;
            padding: 0.3rem 1rem;
        }

        .user-dropdown img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <i class="bi bi-controller"></i> AFK Game CMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('games') }}">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('characters') }}">Characters</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blogs') }}">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item me-2">
                            <a class="btn btn-register" href="{{ route('register') }}">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-login" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" alt="Avatar">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-controller"></i> AFK Game CMS</h5>
                    <p class="text-muted">Experience the ultimate idle RPG adventure. Build your team, conquer dungeons, and become legendary!</p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-discord"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <a href="{{ route('index') }}">Home</a>
                    <a href="{{ route('games') }}">Games</a>
                    <a href="{{ route('characters') }}">Characters</a>
                    <a href="{{ route('blogs') }}">Blogs</a>
                    <a href="{{ route('about') }}">About</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Resources</h5>
                    <a href="#">Game Guide</a>
                    <a href="#">Wiki</a>
                    <a href="#">FAQ</a>
                    <a href="#">Support</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Legal</h5>
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Cookie Policy</a>
                    <a href="#">Contact Us</a>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-muted">
                <p>&copy; {{ date('Y') }} AFK Game CMS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
