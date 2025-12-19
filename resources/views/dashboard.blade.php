@extends('layouts.app')

@section('title', 'User Dashboard - AFK Game CMS')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Welcome, {{ $user->name }}!</h1>
            <p class="lead">Manage your games and characters from your dashboard</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-controller" style="font-size: 3rem; color: #6366f1;"></i>
                    <h3 class="mt-3">0</h3>
                    <p class="text-muted">Games Played</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-people" style="font-size: 3rem; color: #8b5cf6;"></i>
                    <h3 class="mt-3">0</h3>
                    <p class="text-muted">Characters</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-trophy" style="font-size: 3rem; color: #f59e0b;"></i>
                    <h3 class="mt-3">0</h3>
                    <p class="text-muted">Achievements</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-clock" style="font-size: 3rem; color: #10b981;"></i>
                    <h3 class="mt-3">0h</h3>
                    <p class="text-muted">Play Time</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center py-4">No recent activity. Start playing to see your progress here!</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('games') }}" class="btn btn-primary">
                            <i class="bi bi-play-fill"></i> Browse Games
                        </a>
                        <a href="{{ route('characters') }}" class="btn btn-outline-primary">
                            <i class="bi bi-people"></i> View Characters
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-person"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
