@extends('layouts.app')

@section('title', 'Profile - AFK Game CMS')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">My Profile</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profile Information</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Member Since</label>
                        <p>{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
