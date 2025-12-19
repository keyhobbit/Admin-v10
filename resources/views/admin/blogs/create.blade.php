@extends('admin.layouts.app')

@section('title', 'Create Blog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Create New Blog</h1>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Blogs
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.blogs.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Excerpt <span class="text-danger">*</span></label>
                        <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3" required>{{ old('excerpt') }}</textarea>
                        <small class="text-muted">A short summary of the blog post</small>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="15" required>{{ old('content') }}</textarea>
                        <small class="text-muted">HTML content supported</small>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Author <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', auth('admin')->user()->name ?? 'Admin') }}" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Featured Image URL</label>
                        <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}" placeholder="https://example.com/image.jpg">
                        <small class="text-muted">Enter image URL</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Create Blog
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
