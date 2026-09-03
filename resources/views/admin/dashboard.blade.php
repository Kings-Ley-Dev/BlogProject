@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h3 text-dark mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                            <p class="text-muted mb-0">Here's what's happening with your blog today.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create New Post
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-newspaper fa-2x text-primary mb-2"></i>
                    <h3 class="card-title mb-0">{{ $stats['total_posts'] }}</h3>
                    <p class="text-muted mb-0">Total Posts</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-0 shadow-sm border-start border-4 border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="card-title mb-0">{{ $stats['published_posts'] }}</h3>
                    <p class="text-muted mb-0">Published</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-2x text-info mb-2"></i>
                    <h3 class="card-title mb-0">{{ $stats['total_comments'] }}</h3>
                    <p class="text-muted mb-0">Comments</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3 class="card-title mb-0">{{ $stats['pending_comments'] }}</h3>
                    <p class="text-muted mb-0">Pending</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-0 shadow-sm border-start border-4 border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-danger mb-2"></i>
                    <h3 class="card-title mb-0">{{ $stats['total_users'] }}</h3>
                    <p class="text-muted mb-0">Users</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-0 shadow-sm border-start border-4 border-secondary">
                <div class="card-body text-center">
                    <i class="fas fa-folder fa-2x text-secondary mb-2"></i>
                    <h3 class="card-title mb-0">{{ $stats['total_categories'] }}</h3>
                    <p class="text-muted mb-0">Categories</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-xl-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary text-start">
                            <i class="fas fa-plus me-2"></i>Create New Post
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success text-start">
                            <i class="fas fa-folder-plus me-2"></i>Add Category
                        </a>
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-info text-start">
                            <i class="fas fa-comments me-2"></i>Manage Comments
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-warning text-start">
                            <i class="fas fa-list me-2"></i>View All Posts
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-secondary text-start" target="_blank">
                            <i class="fas fa-eye me-2"></i>View Website
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Comments</h6>
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @foreach($recent_comments as $comment)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $comment->user->name }}</strong>
                                <span class="badge bg-{{ $comment->approved ? 'success' : 'warning' }} ms-2">
                                    {{ $comment->approved ? 'Approved' : 'Pending' }}
                                </span>
                            </div>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-2 text-dark">{{ Str::limit($comment->content, 70) }}</p>
                        <small class="text-muted">On: 
                            <a href="{{ route('blog.post.show', $comment->post->slug) }}" class="text-decoration-none">
                                {{ Str::limit($comment->post->title, 30) }}
                            </a>
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Posts</h6>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_posts as $post)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                                 alt="{{ $post->title }}" 
                                                 class="rounded me-3" 
                                                 width="40" 
                                                 height="40"
                                                 style="object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($post->title, 40) }}</h6>
                                                <small class="text-muted">By {{ $post->user->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $post->published ? 'success' : 'warning' }}">
                                            {{ $post->published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.posts.edit', $post) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('blog.post.show', $post->slug) }}" 
                                               class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Posts Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Published Posts</span>
                                <strong>{{ $stats['published_posts'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Draft Posts</span>
                                <strong>{{ $stats['total_posts'] - $stats['published_posts'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total Posts</span>
                                <strong>{{ $stats['total_posts'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Comments Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Approved Comments</span>
                                <strong>{{ $stats['total_comments'] - $stats['pending_comments'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Pending Comments</span>
                                <strong>{{ $stats['pending_comments'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total Comments</span>
                                <strong>{{ $stats['total_comments'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .border-start {
        border-left-width: 4px !important;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Refresh stats every 60 seconds
    setInterval(function() {
        fetch('/admin/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                // Update stats cards
                document.querySelector('[data-stat="total-posts"]').textContent = data.total_posts;
                document.querySelector('[data-stat="published-posts"]').textContent = data.published_posts;
                // Update other stats...
            });
    }, 60000);

    // Quick publish toggle
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('publish-toggle')) {
            const postId = e.target.dataset.id;
            const isPublished = e.target.checked;
            
            fetch(`/admin/posts/${postId}/publish`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ published: isPublished })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Post status updated successfully!');
                }
            });
        }
    });
</script>
@endpush