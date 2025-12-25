<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs
     */
    public function index(Request $request)
    {
        $query = Blog::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->paginate(15);
        $categories = ['Announcements', 'Guides', 'Updates', 'Events'];

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create()
    {
        $categories = ['Announcements', 'Guides', 'Updates', 'Events'];
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'category' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Blog::generateSlug($validated['title']);
        $validated['author'] = auth('admin')->user()->name;
        
        if ($validated['status'] === 'published' && !$request->has('published_at')) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully!');
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit(Blog $blog)
    {
        $categories = ['Announcements', 'Guides', 'Updates', 'Events'];
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'category' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        // Force author to be current admin's name
        $validated['author'] = auth('admin')->user()->name;

        // Regenerate slug if title changed
        if ($validated['title'] !== $blog->title) {
            $validated['slug'] = Blog::generateSlug($validated['title']);
        }

        // Set published_at when changing from draft to published
        if ($validated['status'] === 'published' && $blog->status === 'draft') {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified blog
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }

    /**
     * Sync blogs from external source
     */
    public function sync()
    {
        try {
            $url = 'https://genk.vn/internet.chn';
            
            // Fetch the HTML content
            $html = file_get_contents($url);
            
            if ($html === false) {
                return redirect()->route('admin.blogs.index')
                    ->with('error', 'Failed to fetch content from genk.vn');
            }

            // Parse HTML to extract articles
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);
            
            // Find article links (adjust selectors based on genk.vn structure)
            $articles = $xpath->query("//article//a[@href]");
            
            $imported = 0;
            $links = [];
            
            // Collect unique article links
            foreach ($articles as $article) {
                $href = $article->getAttribute('href');
                if (!empty($href) && !in_array($href, $links)) {
                    // Make sure it's a full URL
                    if (strpos($href, 'http') !== 0) {
                        $href = 'https://genk.vn' . $href;
                    }
                    $links[] = $href;
                    
                    if (count($links) >= 10) break;
                }
            }

            // Process each link
            foreach ($links as $link) {
                // Check if already exists
                if (Blog::where('source_url', $link)->exists()) {
                    continue;
                }

                // Fetch article content
                $articleHtml = @file_get_contents($link);
                if ($articleHtml === false) continue;

                $articleDom = new \DOMDocument();
                @$articleDom->loadHTML($articleHtml);
                $articleXpath = new \DOMXPath($articleDom);

                // Extract title
                $titleNodes = $articleXpath->query("//h1[@class='title']");
                $title = $titleNodes->length > 0 ? $titleNodes->item(0)->textContent : 'Untitled';

                // Extract description/excerpt
                $descNodes = $articleXpath->query("//meta[@name='description']");
                $excerpt = $descNodes->length > 0 ? $descNodes->item(0)->getAttribute('content') : '';

                // Extract content
                $contentNodes = $articleXpath->query("//div[contains(@class, 'knc')]");
                $content = '';
                if ($contentNodes->length > 0) {
                    $content = $articleDom->saveHTML($contentNodes->item(0));
                }

                // Extract image
                $imageNodes = $articleXpath->query("//meta[@property='og:image']");
                $image = $imageNodes->length > 0 ? $imageNodes->item(0)->getAttribute('content') : null;

                // Create blog post
                Blog::create([
                    'title' => trim($title),
                    'slug' => Blog::generateSlug($title),
                    'excerpt' => trim($excerpt) ?: Str::limit(strip_tags($content), 200),
                    'content' => $content ?: '<p>Content not available</p>',
                    'image' => $image,
                    'category' => 'News',
                    'author' => 'Genk.vn',
                    'status' => 'draft',
                    'source_url' => $link,
                    'published_at' => null,
                ]);

                $imported++;
            }

            return redirect()->route('admin.blogs.index')
                ->with('success', "Successfully imported {$imported} articles from genk.vn");

        } catch (\Exception $e) {
            return redirect()->route('admin.blogs.index')
                ->with('error', 'Error syncing blogs: ' . $e->getMessage());
        }
    }
}
