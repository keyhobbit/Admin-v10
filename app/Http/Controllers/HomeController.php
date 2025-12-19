<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
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
     * Show the blogs page
     */
    public function blogs()
    {
        // Fetch published blogs from database
        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function($blog) {
                return [
                    'slug' => $blog->slug,
                    'title' => $blog->title,
                    'excerpt' => $blog->excerpt,
                    'image' => $blog->image ?: 'https://ui-avatars.com/api/?name=' . urlencode($blog->title) . '&size=400&background=6366f1&color=fff',
                    'date' => $blog->published_at->format('Y-m-d'),
                    'author' => $blog->author,
                    'category' => $blog->category,
                ];
            });

        // If no blogs in database, use sample data
        if ($blogs->isEmpty()) {
            $blogs = collect([
                [
                    'slug' => 'welcome-to-afk-game-cms',
                    'title' => 'Welcome to AFK Game CMS',
                    'excerpt' => 'Discover the exciting world of idle RPG gaming with our new platform.',
                    'image' => 'https://ui-avatars.com/api/?name=Blog+1&size=400&background=6366f1&color=fff',
                    'date' => '2025-12-15',
                    'author' => 'Game Master',
                    'category' => 'Announcements',
                ],
                [
                    'slug' => 'top-10-heroes-guide',
                    'title' => 'Top 10 Heroes You Need in 2025',
                    'excerpt' => 'Check out our guide to the most powerful heroes in the game right now.',
                    'image' => 'https://ui-avatars.com/api/?name=Blog+2&size=400&background=8b5cf6&color=fff',
                    'date' => '2025-12-18',
                    'author' => 'Strategy Expert',
                    'category' => 'Guides',
                ],
                [
                    'slug' => 'new-update-patch-notes',
                    'title' => 'December Update - New Features!',
                    'excerpt' => 'Explore all the exciting new features and improvements in our latest update.',
                    'image' => 'https://ui-avatars.com/api/?name=Blog+3&size=400&background=f59e0b&color=fff',
                    'date' => '2025-12-19',
                    'author' => 'Dev Team',
                    'category' => 'Updates',
                ],
            ]);
        }

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show blog detail page
     */
    public function blogDetail($slug)
    {
        // Fetch blog from database
        $blogModel = Blog::where('slug', $slug)->published()->first();

        if ($blogModel) {
            $blog = [
                'slug' => $blogModel->slug,
                'title' => $blogModel->title,
                'content' => $blogModel->content,
                'image' => $blogModel->image ?: 'https://ui-avatars.com/api/?name=' . urlencode($blogModel->title) . '&size=800&background=6366f1&color=fff',
                'date' => $blogModel->published_at->format('Y-m-d'),
                'author' => $blogModel->author,
                'category' => $blogModel->category,
            ];
        } else {
            // Fallback to sample data if not found
            $blog = [
                'slug' => $slug,
                'title' => 'Welcome to AFK Game CMS',
                'content' => '<p>We are excited to announce the launch of AFK Game CMS, your ultimate destination for idle RPG adventures!</p><p>Our platform offers an innovative auto-progression system that allows your heroes to continue fighting and earning rewards even when you\'re offline. This means you can enjoy the thrill of RPG gaming without the need to be constantly online.</p><h3>What Makes Us Different?</h3><p>Unlike traditional RPGs that require constant attention, AFK Game CMS is designed for modern gamers who want to progress at their own pace. Whether you have 5 minutes or 5 hours, you can enjoy meaningful gameplay and see real progress.</p>',
                'image' => 'https://ui-avatars.com/api/?name=Blog+Detail&size=800&background=6366f1&color=fff',
                'date' => '2025-12-15',
                'author' => 'Game Master',
                'category' => 'Announcements',
            ];
        }

        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the about page
     */
    public function about()
    {
        return view('about');
    }
}
