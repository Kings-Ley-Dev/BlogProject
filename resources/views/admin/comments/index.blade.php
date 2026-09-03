@extends('layouts.admin')

@section('title', 'Manage Comments')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Comments</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.comments.index', ['filter' => 'pending']) }}" 
               class="btn btn-warning btn-sm">
                <i class="fas fa-clock me-1"></i>Pending ({{ \App\Models\Comment::where('approved', false)->count() }})
            </a>
            <a href="{{ route('admin.comments.index', ['filter' => 'approved']) }}" 
               class="btn btn-success btn-sm">
                <i class="fas fa-check me-1"></i>Approved ({{ \App\Models\Comment::where('approved', true)->count() }})
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Filter Tabs -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ !request()->has('filter') ? 'active' : '' }}" 
                       href="{{ route('admin.comments.index') }}">All Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('filter') === 'pending' ? 'active' : '' }}" 
                       href="{{ route('admin.comments.index', ['filter' => 'pending']) }}">Pending Approval</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('filter') === 'approved' ? 'active' : '' }}" 
                       href="{{ route('admin.comments.index', ['filter' => 'approved']) }}">Approved</a>
                </li>
            </ul>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Comment</th>
                            <th>User</th>
                            <th>Post</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                        <tr>
                            <td width="30%">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=4f46e5&color=fff" 
                                             alt="{{ $comment->user->name }}" 
                                             class="rounded-circle me-2" 
                                             width="32" 
                                             height="32">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small">{{ Str::limit($comment->content, 80) }}</p>
                                        @if($comment->parent_id)
                                            <small class="text-muted">Reply to comment #{{ $comment->parent_id }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small>{{ $comment->user->name }}</small>
                                <br>
                                <small class="text-muted">{{ $comment->user->email }}</small>
                            </td>
                            <td>
                                <a href="{{ route('blog.post.show', $comment->post->slug) }}" 
                                   class="text-decoration-none" target="_blank">
                                    {{ Str::limit($comment->post->title, 30) }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-{{ $comment->approved ? 'success' : 'warning' }}">
                                    {{ $comment->approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $comment->created_at->format('M d, Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group">
                                    @if(!$comment->approved)
                                    <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" 
                                                title="Approve Comment">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.comments.destroy', $comment) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete Comment">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-comments fa-2x mb-3"></i>
                                    <p>No comments found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- {{ $comments->links() }} --}}
        </div>
    </div>
</div>
@endsection
