@extends('layouts.app')

@section('title', $blog['title'] . ' - AFK Game CMS')

@push('styles')
<style>
    .blog-detail-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 3rem;
    }

    .blog-detail-header h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }

    .blog-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        font-size: 1rem;
        opacity: 0.9;
        flex-wrap: wrap;
    }

    .blog-meta i {
        margin-right: 0.5rem;
    }

    .blog-category-badge {
        background: rgba(255,255,255,0.2);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .blog-featured-image {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 3rem;
    }

    .blog-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #334155;
    }

    .blog-content h2, .blog-content h3 {
        color: #1e293b;
        font-weight: bold;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .blog-content h2 {
        font-size: 2rem;
    }

    .blog-content h3 {
        font-size: 1.5rem;
    }

    .blog-content p {
        margin-bottom: 1.5rem;
    }

    .share-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid #e2e8f0;
    }

    .share-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn-share {
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }

    .btn-share:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-facebook {
        background: #1877f2;
        color: white;
    }

    .btn-twitter {
        background: #1da1f2;
        color: white;
    }

    .btn-linkedin {
        background: #0a66c2;
        color: white;
    }

    .related-posts {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 2px solid #e2e8f0;
    }

    .related-post-card {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
        height: 100%;
    }

    .related-post-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }

    .related-post-card h5 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .related-post-card h5 a {
        color: #1e293b;
        text-decoration: none;
    }

    .related-post-card h5 a:hover {
        color: #6366f1;
    }

    .back-to-blogs {
        display: inline-flex;
        align-items: center;
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 2rem;
        transition: all 0.3s;
    }

    .back-to-blogs:hover {
        color: #8b5cf6;
        padding-left: 5px;
    }

    .back-to-blogs i {
        margin-right: 0.5rem;
    }

    .sidebar {
        position: sticky;
        top: 2rem;
    }

    .sidebar-widget {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .sidebar-widget h4 {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #1e293b;
    }

    .popular-post {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .popular-post:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .popular-post-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }

    .popular-post-content h6 {
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .popular-post-content h6 a {
        color: #1e293b;
        text-decoration: none;
    }

    .popular-post-content h6 a:hover {
        color: #6366f1;
    }

    .tag-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .tag {
        padding: 0.5rem 1rem;
        background: #f1f5f9;
        border-radius: 20px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .tag:hover {
        background: #6366f1;
        color: white;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<section class="blog-detail-header">
    <div class="container">
        <a href="{{ route('blogs') }}" class="back-to-blogs text-white">
            <i class="bi bi-arrow-left"></i> Back to Blogs
        </a>
        <h1>{{ $blog['title'] }}</h1>
        <div class="blog-meta">
            <span class="blog-category-badge">{{ $blog['category'] }}</span>
            <span><i class="bi bi-calendar"></i> {{ date('M d, Y', strtotime($blog['date'])) }}</span>
            <span><i class="bi bi-person"></i> {{ $blog['author'] }}</span>
            <span><i class="bi bi-clock"></i> 5 min read</span>
        </div>
    </div>
</section>

<!-- Content -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8">
            <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}" class="blog-featured-image">
            
            <div class="blog-content">
                {!! $blog['content'] !!}
                
                <p>Join thousands of players already enjoying the AFK Game CMS experience. Whether you're a casual player or a hardcore RPG enthusiast, there's something here for everyone.</p>
                
                <h3>Key Features:</h3>
                <ul>
                    <li>Auto-progression system that works 24/7</li>
                    <li>500+ unique heroes to collect and upgrade</li>
                    <li>Strategic team building and combat</li>
                    <li>Competitive PvP arena battles</li>
                    <li>Daily rewards and special events</li>
                </ul>
                
                <p>We're committed to providing regular updates, new content, and an ever-improving gaming experience. Stay tuned for more exciting announcements!</p>
            </div>

            <!-- Share Section -->
            <div class="share-section">
                <h4>Share this post</h4>
                <div class="share-buttons">
                    <button class="btn btn-share btn-facebook">
                        <i class="bi bi-facebook"></i> Facebook
                    </button>
                    <button class="btn btn-share btn-twitter">
                        <i class="bi bi-twitter"></i> Twitter
                    </button>
                    <button class="btn btn-share btn-linkedin">
                        <i class="bi bi-linkedin"></i> LinkedIn
                    </button>
                </div>
            </div>

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
            <div class="related-posts">
                <h3 class="mb-4">Related Posts</h3>
                <div class="row">
                    @foreach($relatedPosts as $post)
                    <div class="col-md-6 mb-3">
                        <div class="related-post-card">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="img-fluid rounded mb-2">
                            <h5><a href="{{ route('blogs.show', $post['slug']) }}">{{ $post['title'] }}</a></h5>
                            <p class="text-muted small">{{ $post['date'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Popular Posts Widget -->
                @if($popularPosts->count() > 0)
                <div class="sidebar-widget">
                    <h4>Popular Posts</h4>
                    @foreach($popularPosts as $post)
                    <div class="popular-post">
                        <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="popular-post-image">
                        <div class="popular-post-content">
                            <h6><a href="{{ route('blogs.show', $post['slug']) }}">{{ $post['title'] }}</a></h6>
                            <small class="text-muted">{{ $post['date'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Categories Widget -->
                @if($categories->count() > 0)
                <div class="sidebar-widget">
                    <h4>Categories</h4>
                    <div class="list-group">
                        @foreach($categories as $category => $count)
                        <a href="{{ route('blogs') }}?category={{ urlencode($category) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{ $category }}
                            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tags Widget -->
                @if($categories->count() > 0)
                <div class="sidebar-widget">
                    <h4>Popular Topics</h4>
                    <div class="tag-cloud">
                        @foreach($categories as $category => $count)
                        <a href="{{ route('blogs') }}?category={{ urlencode($category) }}" class="tag">{{ $category }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
