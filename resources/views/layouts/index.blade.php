@extends('layouts.admin')

@section('title', 'Manage Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Manage Posts</h4>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create New Post
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 width="60" 
                                 height="40"
                                 style="object-fit: cover;"
                                 class="rounded">
                        </td>
                        <td>{{ Str::limit($post->title, 50) }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td>
                            <span class="badge bg-{{ $post->published ? 'success' : 'warning' }}">
                                {{ $post->published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.posts.publish', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $post->published ? 'warning' : 'success' }}">
                                        <i class="fas fa-{{ $post->published ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $posts->links() }}
    </div>
</div>
@endsection
