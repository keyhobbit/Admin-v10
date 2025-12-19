@extends('admin.layouts.app')

@section('title', 'Edit Blog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Blog</h1>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Blogs
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Excerpt <span class="text-danger">*</span></label>
                        <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                        <small class="text-muted">A short summary of the blog post</small>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="15" required>{{ old('content', $blog->content) }}</textarea>
                        <small class="text-muted">HTML content supported</small>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($blog->source_url)
                    <div class="alert alert-info">
                        <i class="bi bi-link-45deg"></i> <strong>Source:</strong> 
                        <a href="{{ $blog->source_url }}" target="_blank">{{ $blog->source_url }}</a>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $blog->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                            <option value="News" {{ old('category', $blog->category) === 'News' ? 'selected' : '' }}>News</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Author <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $blog->author) }}" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Featured Image URL</label>
                        <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image', $blog->image) }}" placeholder="https://example.com/image.jpg">
                        @if($blog->image)
                            <img src="{{ $blog->image }}" alt="Preview" class="img-thumbnail mt-2" style="max-width: 200px;">
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Update Blog
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
