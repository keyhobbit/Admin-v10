@extends('layouts.app')

@section('title', 'AFK Game CMS - Home')

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 6rem 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        animation: fadeInUp 1s;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.9;
        animation: fadeInUp 1s 0.2s both;
    }

    .btn-hero {
        padding: 1rem 2.5rem;
        font-size: 1.2rem;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
        animation: fadeInUp 1s 0.4s both;
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .btn-hero-primary {
        background: white;
        color: #6366f1;
        border: none;
    }

    .btn-hero-secondary {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
        margin-left: 1rem;
    }

    .btn-hero-secondary:hover {
        background: white;
        color: #6366f1;
    }

    /* Features Section */
    .features-section {
        padding: 5rem 0;
        background: white;
    }

    .feature-card {
        text-align: center;
        padding: 2rem;
        border-radius: 15px;
        transition: all 0.3s;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: white;
    }

    /* Games Section */
    .games-section {
        padding: 5rem 0;
        background: #f8fafc;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #1e293b;
    }

    .section-title p {
        color: #64748b;
        font-size: 1.1rem;
    }

    .game-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        height: 100%;
    }

    .game-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .game-image {
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .game-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.2);
    }

    .game-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255,255,255,0.9);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        z-index: 1;
    }

    .game-content {
        padding: 1.5rem;
    }

    .game-title {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #1e293b;
    }

    .game-stats {
        display: flex;
        justify-content: space-between;
        margin: 1rem 0;
        padding: 1rem 0;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-weight: bold;
        color: #6366f1;
        display: block;
        font-size: 1.2rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
    }

    .btn-play {
        width: 100%;
        padding: 0.8rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-play:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(99,102,241,0.4);
        color: white;
    }

    /* Stats Section */
    .stats-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
    }

    .stat-box {
        text-align: center;
        padding: 2rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
    }

    .stat-text {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Welcome to AFK Game CMS</h1>
                <p class="hero-subtitle">Build your ultimate team and embark on epic adventures. Play anywhere, progress everywhere!</p>
                <div>
                    <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">Start Playing Free</a>
                    <a href="{{ route('games') }}" class="btn btn-hero btn-hero-secondary">Browse Games</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://ui-avatars.com/api/?name=Game+Hero&size=400&background=fff&color=6366f1" alt="Game Hero" class="img-fluid" style="border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose AFK Game?</h2>
            <p>Experience gaming like never before with our unique features</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <h4>Auto Progress</h4>
                    <p class="text-muted">Your heroes keep fighting even when you're offline. Come back to amazing rewards!</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4>Epic Characters</h4>
                    <p class="text-muted">Collect and upgrade hundreds of unique heroes with special abilities and stunning designs.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h4>Compete & Win</h4>
                    <p class="text-muted">Challenge other players in PvP arenas and climb the leaderboards for exclusive rewards.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Games Section -->
<section class="games-section">
    <div class="container">
        <div class="section-title">
            <h2>Featured Games</h2>
            <p>Discover our collection of exciting idle RPG adventures</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="game-card">
                    <div class="game-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <span class="game-badge">🔥 Hot</span>
                    </div>
                    <div class="game-content">
                        <h3 class="game-title">Dragon's Realm</h3>
                        <p class="text-muted">Epic fantasy adventure with mythical creatures</p>
                        <div class="game-stats">
                            <div class="stat-item">
                                <span class="stat-value">10K+</span>
                                <span class="stat-label">Players</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">4.8</span>
                                <span class="stat-label">Rating</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">150+</span>
                                <span class="stat-label">Heroes</span>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-play">Play Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="game-card">
                    <div class="game-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <span class="game-badge">⭐ New</span>
                    </div>
                    <div class="game-content">
                        <h3 class="game-title">Shadow Legends</h3>
                        <p class="text-muted">Dark fantasy with strategic combat system</p>
                        <div class="game-stats">
                            <div class="stat-item">
                                <span class="stat-value">8K+</span>
                                <span class="stat-label">Players</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">4.7</span>
                                <span class="stat-label">Rating</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">120+</span>
                                <span class="stat-label">Heroes</span>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-play">Play Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="game-card">
                    <div class="game-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <span class="game-badge">👑 Popular</span>
                    </div>
                    <div class="game-content">
                        <h3 class="game-title">Crystal Kingdom</h3>
                        <p class="text-muted">Magical adventure in a world of crystals</p>
                        <div class="game-stats">
                            <div class="stat-item">
                                <span class="stat-value">15K+</span>
                                <span class="stat-label">Players</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">4.9</span>
                                <span class="stat-label">Rating</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">200+</span>
                                <span class="stat-label">Heroes</span>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-play">Play Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('games') }}" class="btn btn-primary btn-lg">View All Games</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <span class="stat-number">50K+</span>
                    <span class="stat-text">Active Players</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <span class="stat-number">500+</span>
                    <span class="stat-text">Unique Heroes</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <span class="stat-number">1M+</span>
                    <span class="stat-text">Battles Won</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <span class="stat-number">4.8</span>
                    <span class="stat-text">Average Rating</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
