<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
