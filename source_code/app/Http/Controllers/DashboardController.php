<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('dashboard', compact('user'));
    }

    /**
     * Show the user profile
     */
    public function profile()
    {
        $user = Auth::user();
        
        return view('profile', compact('user'));
    }

    /**
     * Show the settings page
     */
    public function settings()
    {
        $user = Auth::user();
        
        return view('settings', compact('user'));
    }
}
