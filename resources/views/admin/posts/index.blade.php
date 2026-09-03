@extends('layouts.admin')

@section('title', 'Manage Posts')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Posts</h4>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Post
        </a>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request()->has('filter') ? 'active' : '' }}" 
               href="{{ route('admin.posts.index') }}">All Posts ({{ \App\Models\Post::count() }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('filter') === 'published' ? 'active' : '' }}" 
               href="{{ route('admin.posts.index', ['filter' => 'published']) }}">Published ({{ \App\Models\Post::where('published', true)->count() }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('filter') === 'drafts' ? 'active' : '' }}" 
               href="{{ route('admin.posts.index', ['filter' => 'drafts']) }}">Drafts ({{ \App\Models\Post::where('published', false)->count() }})</a>
        </li>
    </ul>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="rounded me-3" 
                                         width="60" 
                                         height="40"
                                         style="object-fit: cover;">
                                    @else
                                    <div class="rounded me-3 bg-secondary d-flex align-items-center justify-content-center"
                                         style="width: 60px; height: 40px;">
                                        <i class="fas fa-image text-white"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ Str::limit($post->title, 50) }}</h6>
                                        <small class="text-muted">{{ Str::limit($post->excerpt, 30) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $post->category->name }}</span>
                            </td>
                            <td>
                                <small>{{ $post->user->name }}</small>
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
                                    
                                    <a href="{{ route('admin.posts.show', $post->slug) }}" 
                                       class="btn btn-sm btn-outline-info" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.posts.destroy', $post) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.posts.publish', $post) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $post->published ? 'warning' : 'success' }}"
                                                title="{{ $post->published ? 'Unpublish' : 'Publish' }}">
                                            <i class="fas fa-{{ $post->published ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-newspaper fa-2x mb-3"></i>
                                    <p>No posts found.</p>
                                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                                        Create Your First Post
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- {{ $posts->links() }} --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endpush