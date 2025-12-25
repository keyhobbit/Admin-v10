<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_admins' => \App\Models\Admin::count(),
            'today_users' => \App\Models\User::whereDate('created_at', today())->count(),
            'active_sessions' => \DB::table('personal_access_tokens')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
