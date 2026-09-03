@extends('layouts.app')

@section('title', '#' . $tag->name . ' - Tag')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Tag Header -->
            <div class="d-flex align-items-center mb-4">
                <div class="flex-grow-1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">#{{ $tag->name }}</li>
                        </ol>
                    </nav>
                    <h1 class="h2 text-white mb-2">#{{ $tag->name }}</h1>
                    <p class="text-muted mb-0">{{ $posts->total() }} articles tagged</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="badge bg-secondary fs-6">#{{ $tag->name }}</span>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="row">
                @forelse($posts as $post)
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
                        No posts found with this tag yet.
                    </div>
                </div>
                @endforelse
            </div>

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
