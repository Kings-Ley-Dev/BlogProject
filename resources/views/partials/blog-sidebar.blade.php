 
<!-- resources/views/partials/blog-sidebar.blade.php -->
<div class="sticky-top" style="top: 20px;">
    <!-- Categories Widget -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0"><i class="fas fa-folder me-2"></i>Categories</h6>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                @php
                    $sidebarCategories = \App\Models\Category::withCount(['posts' => function($query) {
                        $query->where('published', true);
                    }])->orderBy('posts_count', 'desc')->get();
                @endphp
                
                @foreach($sidebarCategories as $category)
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
            <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Posts</h6>
        </div>
        <div class="card-body">
            @php
                $recentPosts = \App\Models\Post::with('user')
                    ->where('published', true)
                    ->orderBy('published_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @foreach($recentPosts as $post)
            <div class="d-flex mb-3">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="rounded me-3"
                     width="60"
                     height="60"
                     style="object-fit: cover;">
                @else
                <div class="rounded me-3 bg-secondary d-flex align-items-center justify-content-center"
                     style="width: 60px; height: 60px;">
                    <i class="fas fa-newspaper text-white"></i>
                </div>
                @endif
                <div>
                    <h6 class="mb-1">
                        <a href="{{ route('blog.post.show', $post->slug) }}" 
                           class="text-decoration-none text-dark">
                            {{ Str::limit($post->title, 40) }}
                        </a>
                    </h6>
                    <small class="text-muted">{{ $post->published_at->format('M d') }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tags Widget -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="fas fa-tags me-2"></i>Popular Tags</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @php
                    $popularTags = \App\Models\Tag::withCount('posts')
                        ->orderBy('posts_count', 'desc')
                        ->take(15)
                        ->get();
                @endphp
                
                @foreach($popularTags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}" 
                   class="badge bg-secondary text-decoration-none">
                    #{{ $tag->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Newsletter Widget -->
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-warning text-dark">
            <h6 class="mb-0"><i class="fas fa-envelope me-2"></i>Newsletter</h6>
        </div>
        <div class="card-body">
            <p class="small text-muted mb-2">
                Subscribe to get the latest updates.
            </p>
            <form action="#" method="POST" class="mb-2">
                <div class="input-group input-group-sm">
                    <input type="email" class="form-control form-control-sm" 
                           placeholder="Your email" required>
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            <small class="text-muted">
                <i class="fas fa-users me-1"></i>
                {{ \App\Models\User::count() }}+ subscribers
            </small>
        </div>
    </div>
</div>

@push('styles')
<style>
    .list-group-item {
        border: none;
        padding: 0.75rem 0;
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    
    .badge {
        font-size: 0.7em;
        padding: 0.35em 0.65em;
    }
    
    .sticky-top {
        z-index: 100;
    }
</style>
@endpush
