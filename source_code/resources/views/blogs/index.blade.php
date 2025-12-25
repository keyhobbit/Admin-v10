@extends('layouts.app')

@section('title', 'Blogs - AFK Game CMS')

@push('styles')
<style>
    .blogs-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }

    .blogs-header h1 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .blog-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .blog-image {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.1);
    }

    .blog-category {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(99,102,241,0.9);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .blog-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: #64748b;
    }

    .blog-meta i {
        margin-right: 0.3rem;
    }

    .blog-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .blog-title a {
        color: #1e293b;
        text-decoration: none;
        transition: color 0.3s;
    }

    .blog-title a:hover {
        color: #6366f1;
    }

    .blog-excerpt {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }

    .btn-read-more {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        align-self: flex-start;
    }

    .btn-read-more:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(99,102,241,0.4);
        color: white;
    }

    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 0.7rem 1.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 25px;
        background: white;
        color: #64748b;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-tab:hover, .filter-tab.active {
        border-color: #6366f1;
        background: #6366f1;
        color: white;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<section class="blogs-header">
    <div class="container text-center">
        <h1>Game News & Updates</h1>
        <p class="lead">Stay updated with the latest news, guides, and announcements</p>
    </div>
</section>

<!-- Filters -->
<div class="container">
    <div class="filter-tabs">
        <button class="filter-tab active">All Posts</button>
        <button class="filter-tab">Announcements</button>
        <button class="filter-tab">Guides</button>
        <button class="filter-tab">Updates</button>
        <button class="filter-tab">Events</button>
    </div>
</div>

<!-- Blog Posts -->
<div class="container mb-5">
    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-4 mb-4">
            <div class="blog-card">
                <div class="blog-image">
                    <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}">
                    <span class="blog-category">{{ $blog['category'] }}</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">
                        <span><i class="bi bi-calendar"></i> {{ date('M d, Y', strtotime($blog['date'])) }}</span>
                        <span><i class="bi bi-person"></i> {{ $blog['author'] }}</span>
                    </div>
                    <h3 class="blog-title">
                        <a href="{{ route('blogs.show', $blog['slug']) }}">{{ $blog['title'] }}</a>
                    </h3>
                    <p class="blog-excerpt">{{ $blog['excerpt'] }}</p>
                    <a href="{{ route('blogs.show', $blog['slug']) }}" class="btn-read-more">
                        Read More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="text-center mt-4">
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Newsletter Section -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-white mb-3 mb-md-0">
                <h3 class="mb-2">Subscribe to Our Newsletter</h3>
                <p class="mb-0">Get the latest news and updates delivered to your inbox</p>
            </div>
            <div class="col-md-6">
                <form class="d-flex gap-2">
                    <input type="email" class="form-control form-control-lg" placeholder="Enter your email" style="border-radius: 10px;">
                    <button type="submit" class="btn btn-light btn-lg" style="border-radius: 10px; white-space: nowrap;">
                        <i class="bi bi-envelope"></i> Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
