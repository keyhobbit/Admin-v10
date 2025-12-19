@extends('admin.layouts.app')

@section('title', 'Edit Blog')

@push('styles')
<style>
    .preview-container {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 2rem;
        background: #f8f9fa;
        min-height: 400px;
    }
    .preview-image {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
    .preview-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .preview-meta {
        color: #6c757d;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #dee2e6;
    }
    .preview-content {
        line-height: 1.8;
    }
    .tab-content {
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Blog</h1>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Blogs
    </a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Tabs -->
        <ul class="nav nav-tabs" id="blogTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview" type="button" role="tab" onclick="updatePreview()">
                    <i class="bi bi-eye"></i> Preview
                </button>
            </li>
        </ul>

        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" id="blogForm">
            @csrf
            @method('PUT')

            <div class="tab-content" id="blogTabContent">
                <!-- Edit Tab -->
                <div class="tab-pane fade show active" id="edit" role="tabpanel">
                    <div class="row mt-3">
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
                        <div id="editor" style="height: 400px; background: white;"></div>
                        <textarea name="content" id="content" style="display:none;">{{ old('content', $blog->content) }}</textarea>
                        <div id="content-error" class="text-danger mt-1" style="display:none;">Content is required</div>
                        @error('content')
                            <div class="text-danger mt-1">{{ $message }}</div>
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
                        <label class="form-label fw-bold">Author</label>
                        <input type="text" class="form-control" value="{{ $blog->author }}" readonly disabled>
                        <small class="text-muted">Author cannot be changed</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Featured Image URL</label>
                        <input type="text" name="image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image', $blog->image) }}" placeholder="https://example.com/image.jpg">
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
                </div>

                <!-- Preview Tab -->
                <div class="tab-pane fade" id="preview" role="tabpanel">
                    <div class="preview-container mt-3">
                        <img id="preview-image" class="preview-image" src="{{ $blog->image }}" alt="Featured Image" style="{{ $blog->image ? '' : 'display: none;' }}">
                        <h1 class="preview-title" id="preview-title">{{ $blog->title }}</h1>
                        <div class="preview-meta">
                            <span class="badge bg-info" id="preview-category">{{ $blog->category }}</span>
                            <span class="ms-2"><i class="bi bi-person"></i> <span id="preview-author">{{ $blog->author }}</span></span>
                            <span class="ms-2"><i class="bi bi-calendar"></i> <span id="preview-date">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : date('M d, Y') }}</span></span>
                            <span class="ms-2"><span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'warning' }}" id="preview-status">{{ ucfirst($blog->status) }}</span></span>
                        </div>
                        <div class="preview-excerpt" id="preview-excerpt" style="font-style: italic; color: #6c757d; margin-bottom: 1.5rem;">{{ $blog->excerpt }}</div>
                        <div class="preview-content" id="preview-content">
                            {!! $blog->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Initialize Quill Editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'font': [] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean']
            ]
        },
        placeholder: 'Write your blog content here...'
    });

    // Set initial content
    const initialContent = document.getElementById('content').value;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }

    // Sync Quill content to hidden textarea on form submit
    document.getElementById('blogForm').addEventListener('submit', function(e) {
        const content = quill.root.innerHTML;
        const textContent = quill.getText().trim();
        
        // Validate content is not empty
        if (!textContent || textContent.length === 0) {
            e.preventDefault();
            document.getElementById('content-error').style.display = 'block';
            // Switch to edit tab and focus on editor
            document.getElementById('edit-tab').click();
            quill.focus();
            return false;
        }
        
        document.getElementById('content-error').style.display = 'none';
        document.getElementById('content').value = content;
    });
    
    // Hide error when user starts typing
    quill.on('text-change', function() {
        if (quill.getText().trim().length > 0) {
            document.getElementById('content-error').style.display = 'none';
        }
    });

    // Custom image handler
    quill.getModule('toolbar').addHandler('image', function() {
        const url = prompt('Enter image URL:');
        if (url) {
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', url);
        }
    });

    // Update preview
    function updatePreview() {
        const title = document.querySelector('input[name="title"]').value || 'Blog Title';
        const excerpt = document.querySelector('textarea[name="excerpt"]').value || 'No excerpt provided';
        const category = document.querySelector('select[name="category"]').value || 'Category';
        const author = document.querySelector('input[name="author"]').value || 'Author';
        const status = document.querySelector('select[name="status"]').value || 'draft';
        const image = document.querySelector('input[name="image"]').value;
        const content = quill.root.innerHTML;

        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-excerpt').textContent = excerpt;
        document.getElementById('preview-category').textContent = category;
        document.getElementById('preview-author').textContent = author;
        document.getElementById('preview-status').textContent = status.charAt(0).toUpperCase() + status.slice(1);
        document.getElementById('preview-status').className = status === 'published' ? 'badge bg-success' : 'badge bg-warning';
        document.getElementById('preview-date').textContent = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById('preview-content').innerHTML = content;

        const previewImage = document.getElementById('preview-image');
        if (image) {
            previewImage.src = image;
            previewImage.style.display = 'block';
        } else {
            previewImage.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
