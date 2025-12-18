@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="value">{{ $stats['total_users'] ?? 0 }}</div>
                    <div class="label">Total Users</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="value">{{ $stats['today_users'] ?? 0 }}</div>
                    <div class="label">Today's New Users</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="value">{{ $stats['total_admins'] ?? 0 }}</div>
                    <div class="label">Administrators</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-activity"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="value">{{ $stats['active_sessions'] ?? 0 }}</div>
                    <div class="label">Active Sessions</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up"></i> User Growth</span>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                </select>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-graph-up" style="font-size: 3rem;"></i>
                    <p class="mt-3">Chart coming soon</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bell"></i> Recent Activity
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-plus text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">2 minutes ago</small>
                                <p class="mb-0 small">New user registered</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="bi bi-shield-lock text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">1 hour ago</small>
                                <p class="mb-0 small">Admin login detected</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="bi bi-gear text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">3 hours ago</small>
                                <p class="mb-0 small">System configuration updated</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people"></i> Latest Users
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\User::latest()->take(5)->get() as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> System Information
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted">Laravel Version</td>
                        <td class="text-end"><strong>{{ app()->version() }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">PHP Version</td>
                        <td class="text-end"><strong>{{ phpversion() }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Environment</td>
                        <td class="text-end"><span class="badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">{{ app()->environment() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Database</td>
                        <td class="text-end"><strong>{{ config('database.default') }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Cache Driver</td>
                        <td class="text-end"><strong>{{ config('cache.default') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
