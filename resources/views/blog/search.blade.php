@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Search Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Search</li>
                    </ol>
                </nav>
                <h1 class="h2 text-white mb-2">Search Results</h1>
                <p class="text-muted">
                    {{ $posts->total() }} results found for "<strong>{{ $query }}</strong>"
                </p>
                
                <!-- Search Form -->
                <form action="{{ route('blog.search') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" 
                               placeholder="Search articles..." value="{{ $query }}"
                               required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Search Results -->
            @forelse($posts as $post)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row">
                        @if($post->featured_image)
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="img-fluid rounded"
                                 style="height: 120px; object-fit: cover; width: 100%;">
                        </div>
                        @endif
                        <div class="{{ $post->featured_image ? 'col-md-9' : 'col-12' }}">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">{{ $post->category->name }}</span>
                                <small class="text-muted">{{ $post->published_at->format('M d, Y') }}</small>
                            </div>
                            <h4 class="card-title h5">
                                <a href="{{ route('blog.post.show', $post->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h4>
                            <p class="card-text text-muted">{{ Str::limit($post->excerpt, 150) }}</p>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=4f46e5&color=fff" 
                                     alt="{{ $post->user->name }}" 
                                     class="rounded-circle me-2" 
                                     width="25" 
                                     height="25">
                                <small class="text-muted">By {{ $post->user->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info text-center">
                <i class="fas fa-search me-2"></i>
                No articles found for "{{ $query }}". Try different keywords.
            </div>
            @endforelse

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('partials.blog-sidebar')
        </div>
    </div>
</div>
@endsection
