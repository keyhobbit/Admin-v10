@extends('admin.layouts.app')

@section('title', 'Administrators')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Administrator Management</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">
        <i class="bi bi-plus-circle"></i> Create Admin
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Administrator management coming soon!
        </div>
        
        <div class="text-center py-5">
            <i class="bi bi-shield-lock" style="font-size: 4rem; color: #cbd5e1;"></i>
            <p class="text-muted mt-3">Admin user management will be available in the next update.</p>
        </div>
    </div>
</div>
@endsection
