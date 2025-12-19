@extends('layouts.app')

@section('title', 'User Login - AFK Game CMS')

@push('styles')
<style>
    .login-section {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        padding: 3rem 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .login-left {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .login-left h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .login-left p {
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .login-left .features {
        text-align: left;
        width: 100%;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .feature-item i {
        font-size: 1.5rem;
        margin-right: 1rem;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-right {
        padding: 3rem;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header h3 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #64748b;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .form-control {
        padding: 0.8rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }

    .input-group-text {
        background: white;
        border: 2px solid #e2e8f0;
        border-right: none;
        border-radius: 10px 0 0 10px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }

    .input-group:focus-within .input-group-text {
        border-color: #6366f1;
    }

    .btn-login {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99,102,241,0.3);
        color: white;
    }

    .divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e2e8f0;
    }

    .divider span {
        background: white;
        padding: 0 1rem;
        position: relative;
        color: #64748b;
    }

    .social-login {
        display: flex;
        gap: 1rem;
    }

    .btn-social {
        flex: 1;
        padding: 0.8rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        transition: all 0.3s;
    }

    .btn-social:hover {
        border-color: #6366f1;
        transform: translateY(-2px);
    }

    .admin-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .admin-link a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
    }

    .admin-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-left {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<section class="login-section">
    <div class="container">
        <div class="login-card">
            <div class="row g-0">
                <div class="col-md-5 login-left">
                    <div>
                        <i class="bi bi-controller" style="font-size: 4rem; margin-bottom: 1.5rem;"></i>
                        <h2>Welcome Back!</h2>
                        <p>Login to continue your adventure</p>
                        <div class="features">
                            <div class="feature-item">
                                <i class="bi bi-lightning-charge-fill"></i>
                                <span>Auto Progress System</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-people-fill"></i>
                                <span>500+ Epic Heroes</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-trophy-fill"></i>
                                <span>Competitive PvP</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-gift-fill"></i>
                                <span>Daily Rewards</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 login-right">
                    <div class="login-header">
                        <h3>Login to Your Account</h3>
                        <p>Enter your credentials to access your game</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right"></i> Login Now
                        </button>
                    </form>

                    <div class="divider">
                        <span>or continue with</span>
                    </div>

                    <div class="social-login">
                        <button class="btn btn-social">
                            <i class="bi bi-google"></i> Google
                        </button>
                        <button class="btn btn-social">
                            <i class="bi bi-facebook"></i> Facebook
                        </button>
                    </div>

                    <p class="text-center mt-3 mb-0">
                        Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Sign Up</a>
                    </p>

                    <div class="admin-link">
                        <i class="bi bi-shield-lock"></i>
                        <a href="{{ route('admin.login') }}">Admin Login →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
