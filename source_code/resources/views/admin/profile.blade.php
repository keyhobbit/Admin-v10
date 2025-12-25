@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">My Profile</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <p>{{ auth('admin')->user()->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p>{{ auth('admin')->user()->email }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Role</label>
                    <p><span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', auth('admin')->user()->role)) }}</span></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Login</label>
                    <p>{{ auth('admin')->user()->last_login_at ? auth('admin')->user()->last_login_at->format('M d, Y H:i:s') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
