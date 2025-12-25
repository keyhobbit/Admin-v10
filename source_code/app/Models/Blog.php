<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'author',
        'status',
        'source_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($blog) {
            // Auto-set published_at when status is published and published_at is null
            if ($blog->status === 'published' && is_null($blog->published_at)) {
                $blog->published_at = now();
            }
        });

        // Clear cache when blog is saved or deleted
        static::saved(function ($blog) {
            static::clearBlogCache($blog);
        });

        static::deleted(function ($blog) {
            static::clearBlogCache($blog);
        });
    }

    /**
     * Clear blog-related caches
     */
    protected static function clearBlogCache($blog)
    {
        // Clear blog detail cache
        Cache::forget("blog_detail_{$blog->slug}");
        
        // Clear blog list caches
        Cache::forget('blogs_list_all');
        Cache::forget("blogs_list_category_{$blog->category}");
        
        // Clear all category-specific caches (in case category changed)
        $categories = static::distinct()->pluck('category');
        foreach ($categories as $category) {
            Cache::forget("blogs_list_category_{$category}");
        }
    }

    /**
     * Generate slug from title
     */
    public static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();
        
        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Scope for published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for draft blogs
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
