@extends('layouts.app')

@section('title', 'Sign Up - AFK Game CMS')

@push('styles')
<style>
    .register-section {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        padding: 3rem 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 1000px;
        margin: 0 auto;
    }

    .register-left {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .register-left h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .register-right {
        padding: 3rem;
    }

    .register-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .register-header h3 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .form-control {
        padding: 0.8rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
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

    .btn-register {
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

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(99,102,241,0.3);
    }

    @media (max-width: 768px) {
        .register-left {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<section class="register-section">
    <div class="container">
        <div class="register-card">
            <div class="row g-0">
                <div class="col-md-5 register-left">
                    <i class="bi bi-controller" style="font-size: 4rem; margin-bottom: 1.5rem;"></i>
                    <h2>Join the Adventure!</h2>
                    <p>Create your account and start playing now</p>
                    <img src="https://ui-avatars.com/api/?name=Welcome&size=300&background=fff&color=6366f1" alt="Welcome" class="img-fluid mt-4" style="border-radius: 15px;">
                </div>
                <div class="col-md-7 register-right">
                    <div class="register-header">
                        <h3>Create Your Account</h3>
                        <p>Fill in your details to get started</p>
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

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="your@email.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="terms" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register">
                            <i class="bi bi-person-plus"></i> Create Account
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
