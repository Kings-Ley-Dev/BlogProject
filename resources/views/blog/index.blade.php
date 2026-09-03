@extends('layouts.app')

@section('title', 'Welcome to Our Blog')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold text-white mb-3">Welcome to Kingsley's Blog</h1>
            <p class="lead text-white mb-4">Discover amazing articles, tutorials, and insights about technology, lifestyle, and more.</p>
            
            <!-- Search Form -->
            <form action="{{ route('blog.search') }}" method="GET" class="d-flex gap-2 justify-content-center">
                <input type="text" name="query" class="form-control form-control-lg w-50" 
                       placeholder="Search articles..." value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Featured Post (if any) -->
            @if($posts->count() > 0 && $posts->first()->featured_image)
            <div class="card shadow-sm mb-5 border-0">
                <img src="{{ asset('storage/' . $posts->first()->featured_image) }}" 
                     class="card-img-top" 
                     alt="{{ $posts->first()->title }}"
                     style="height: 400px; object-fit: cover;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary me-2">{{ $posts->first()->category->name }}</span>
                        <small class="text-muted">{{ $posts->first()->published_at->format('M d, Y') }}</small>
                    </div>
                    <h2 class="card-title h3">
                        <a href="{{ route('blog.post.show', $posts->first()->slug) }}" 
                           class="text-decoration-none text-dark">
                            {{ $posts->first()->title }}
                        </a>
                    </h2>
                    <p class="card-text">{{ $posts->first()->excerpt }}</p>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($posts->first()->user->name) }}&background=4f46e5&color=fff" 
                             alt="{{ $posts->first()->user->name }}" 
                             class="rounded-circle me-2" 
                             width="30" 
                             height="30">
                        <span class="text-muted">By {{ $posts->first()->user->name }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Blog Posts Grid -->
            <h3 class="h4 text-white mb-4">Latest Articles</h3>
            <div class="row">
                @forelse($posts->skip(1) as $post)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             class="card-img-top" 
                             alt="{{ $post->title }}"
                             style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">{{ $post->category->name }}</span>
                                <small class="text-muted">{{ $post->published_at->format('M d, Y') }}</small>
                            </div>
                            <h4 class="card-title h5">
                                <a href="{{ route('blog.post.show', $post->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                            </h4>
                            <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            
                            <!-- Tags -->
                            @if($post->tags->count() > 0)
                            <div class="mb-2">
                                @foreach($post->tags->take(3) as $tag)
                                <span class="badge bg-secondary me-1">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            @endif
                            
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
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        No blog posts found. Check back later!
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            {{-- @if($posts->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $posts->links() }}
            </div>
            @endif --}}
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Categories Widget -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Categories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                        <a href="{{ route('blog.category', $category->slug) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">{{ $category->posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Posts Widget -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Posts</h5>
                </div>
                <div class="card-body">
                    @foreach($recent_posts as $recent)
                    <div class="d-flex mb-3">
                        @if($recent->featured_image)
                        <img src="{{ asset('storage/' . $recent->featured_image) }}" 
                             alt="{{ $recent->title }}" 
                             class="rounded me-3"
                             width="60"
                             height="60"
                             style="object-fit: cover;">
                        @endif
                        <div>
                            <h6 class="mb-1">
                                <a href="{{ route('blog.post.show', $recent->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($recent->title, 40) }}
                                </a>
                            </h6>
                            <small class="text-muted">{{ $recent->published_at->format('M d') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tags Widget -->
            {{-- <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Popular Tags</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @php
                            $tags = \App\Models\Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(15)->get();
                        @endphp
                        @foreach($tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" 
                           class="badge bg-secondary text-decoration-none">
                            #{{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.75em;
    }
</style>
@endpush