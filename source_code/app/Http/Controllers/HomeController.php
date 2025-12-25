<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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
    public function blogs(Request $request)
    {
        // Create cache key based on category filter
        $category = $request->get('category');
        $cacheKey = $category ? "blogs_list_category_{$category}" : 'blogs_list_all';

        // Cache blogs for 10 minutes
        $blogs = Cache::remember($cacheKey, 600, function () use ($request) {
            // Start with published blogs query
            $query = Blog::published();

            // Filter by category if provided
            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            // Fetch published blogs from database
            return $query
                ->orderBy('published_at', 'desc')
                ->get()
                ->map(function($blog) {
                    return [
                        'slug' => $blog->slug,
                        'title' => $blog->title,
                        'excerpt' => $blog->excerpt,
                        'image' => $blog->image ?: 'https://ui-avatars.com/api/?name=' . urlencode($blog->title) . '&size=400&background=6366f1&color=fff',
                        'date' => $blog->published_at ? $blog->published_at->format('Y-m-d') : now()->format('Y-m-d'),
                        'author' => $blog->author,
                        'category' => $blog->category,
                    ];
                });
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
        // Cache blog detail for 10 minutes
        $cacheKey = "blog_detail_{$slug}";
        
        $blogData = Cache::remember($cacheKey, 600, function () use ($slug) {
            // Fetch blog from database
            $blogModel = Blog::where('slug', $slug)->published()->first();

            if (!$blogModel) {
                return null;
            }

            $blog = [
                'slug' => $blogModel->slug,
                'title' => $blogModel->title,
                'content' => $blogModel->content,
                'image' => $blogModel->image ?: 'https://ui-avatars.com/api/?name=' . urlencode($blogModel->title) . '&size=800&background=6366f1&color=fff',
                'date' => $blogModel->published_at ? $blogModel->published_at->format('Y-m-d') : now()->format('Y-m-d'),
                'author' => $blogModel->author,
                'category' => $blogModel->category,
            ];

            // Fetch related posts (same category, exclude current)
            $relatedPosts = Blog::published()
                ->where('category', $blogModel->category)
                ->where('id', '!=', $blogModel->id)
                ->latest('published_at')
                ->take(4)
                ->get()
                ->map(function($post) {
                    return [
                        'slug' => $post->slug,
                        'title' => $post->title,
                        'excerpt' => $post->excerpt,
                        'image' => $post->image ?: 'https://ui-avatars.com/api/?name=' . urlencode($post->title) . '&size=400&background=8b5cf6&color=fff',
                        'date' => $post->published_at->format('M d, Y'),
                        'category' => $post->category,
                    ];
                });

            // Fetch popular posts (most recent)
            $popularPosts = Blog::published()
                ->where('id', '!=', $blogModel->id)
                ->latest('published_at')
                ->take(3)
                ->get()
                ->map(function($post) {
                    return [
                        'slug' => $post->slug,
                        'title' => $post->title,
                        'image' => $post->image ?: 'https://ui-avatars.com/api/?name=' . urlencode($post->title) . '&size=80&background=6366f1&color=fff',
                        'date' => $post->published_at->format('M d, Y'),
                    ];
                });

            // Get all categories with count (ensure it's a collection)
            $categoriesData = Blog::published()
                ->select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->get();
            
            $categories = $categoriesData->mapWithKeys(function($item) {
                return [$item->category => $item->count];
            });

            return compact('blog', 'relatedPosts', 'popularPosts', 'categories');
        });

        if (!$blogData) {
            abort(404);
        }

        return view('blogs.show', $blogData);
    }

    /**
     * Show the about page
     */
    public function about()
    {
        return view('about');
    }
}
