@extends('layouts.admin')

@section('title', $post->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Post Details</h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('blog.post.show', $post->slug) }}" class="btn btn-sm btn-info" target="_blank">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Featured Image -->
                    @if($post->featured_image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="img-fluid rounded"
                             style="max-height: 300px;">
                    </div>
                    @endif

                    <!-- Post Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Title</h6>
                            <p class="text-dark">{{ $post->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Slug</h6>
                            <p class="text-muted">{{ $post->slug }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Category</h6>
                            <span class="badge bg-primary">{{ $post->category->name }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6>Status</h6>
                            <span class="badge bg-{{ $post->published ? 'success' : 'warning' }}">
                                {{ $post->published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Author</h6>
                            <p class="text-muted">{{ $post->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Published Date</h6>
                            <p class="text-muted">
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                            </p>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                    <div class="mb-4">
                        <h6>Tags</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                            <span class="badge bg-secondary">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Excerpt -->
                    <div class="mb-4">
                        <h6>Excerpt</h6>
                        <p class="text-dark">{{ $post->excerpt }}</p>
                    </div>

                    <!-- Content -->
                    <div>
                        <h6>Content</h6>
                        <div class="border rounded p-3 bg-light">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Stats -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Views</span>
                        <strong>0</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Comments</span>
                        <strong>{{ $post->comments->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Created</span>
                        <strong>{{ $post->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Last Updated</span>
                        <strong>{{ $post->updated_at->format('M d, Y') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.posts.publish', $post) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $post->published ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $post->published ? 'eye-slash' : 'eye' }} me-2"></i>
                                {{ $post->published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary w-100">
                            <i class="fas fa-edit me-2"></i>Edit Post
                        </a>
                        
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Delete Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
