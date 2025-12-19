@extends('admin.layouts.app')

@section('title', 'Manage Blogs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Blog Management</h1>
    <div>
        <a href="{{ route('admin.blogs.sync') }}" class="btn btn-info me-2" onclick="return confirm('This will import top 10 articles from genk.vn. Continue?')">
            <i class="bi bi-arrow-repeat"></i> Sync from Genk.vn
        </a>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Blog
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search blogs..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                    <option value="News" {{ request('category') === 'News' ? 'selected' : '' }}>News</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Blog List -->
<div class="card">
    <div class="card-body">
        @if($blogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 80px;">Image</th>
                            <th>Title</th>
                            <th style="width: 120px;">Category</th>
                            <th style="width: 120px;">Author</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 150px;">Published</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>
                                @if($blog->image)
                                    <img src="{{ $blog->image }}" alt="Blog Image" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ Str::limit($blog->title, 50) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($blog->excerpt, 80) }}</small>
                                @if($blog->source_url)
                                    <br><small><i class="bi bi-link-45deg"></i> From genk.vn</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $blog->category }}</span>
                            </td>
                            <td>{{ $blog->author }}</td>
                            <td>
                                @if($blog->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                @if($blog->published_at)
                                    {{ $blog->published_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted">Not published</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-sm btn-info" target="_blank" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                <p class="text-muted mt-3">No blogs found. Create your first blog or sync from genk.vn!</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Create Blog</a>
            </div>
        @endif
    </div>
</div>
@endsection
