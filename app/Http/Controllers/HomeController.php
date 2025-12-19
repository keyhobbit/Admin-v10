<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home page
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the games page
     */
    public function games()
    {
        return view('games');
    }

    /**
     * Show the characters page
     */
    public function characters()
    {
        return view('characters');
    }

    /**
     * Show the about page
     */
    public function about()
    {
        return view('about');
    }
}
