@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 30) }}</li>
                    </ol>
                </nav>

                <!-- Featured Image -->
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="img-fluid rounded mb-4 w-100"
                     style="max-height: 400px; object-fit: cover;">
                @endif

                <!-- Post Header -->
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=4f46e5&color=fff" 
                         alt="{{ $post->user->name }}" 
                         class="rounded-circle me-3" 
                         width="50" 
                         height="50">
                    <div>
                        <h6 class="mb-0">{{ $post->user->name }}</h6>
                        <small class="text-muted">{{ $post->published_at->format('F j, Y') }} • {{ $post->reading_time }} min read</small>
                    </div>
                </div>

                <!-- Post Content -->
                <h1 class="h2 mb-3 text-white">{{ $post->title }}</h1>
                
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-primary">{{ $post->category->name }}</span>
                    @foreach($post->tags as $tag)
                    <span class="badge bg-secondary">#{{ $tag->name }}</span>
                    @endforeach
                </div>

                <div class="post-content">
                    {!! $post->content !!}
                </div>

                <!-- Social Sharing -->
                <div class="border-top pt-4 mt-4">
                    <h6 class="mb-3 text-white">Share this post:</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="fab fa-facebook me-1"></i>Facebook</a>
                        <a href="#" class="btn btn-outline-info btn-sm"><i class="fab fa-twitter me-1"></i>Twitter</a>
                        <a href="#" class="btn btn-outline-linkedin btn-sm"><i class="fab fa-linkedin me-1"></i>LinkedIn</a>
                    </div>
                </div>
            </article>

            <!-- Comments Section -->
            <section class="mt-5">
                <h4 class="text-white mb-4">Comments ({{ $post->comments->where('approved', true)->count() }})</h4>
                
                @auth
                <!-- Comment Form -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="content" class="form-label text-white">Leave a comment</label>
                                <textarea class="form-control" id="content" name="content" rows="3" 
                                          placeholder="Share your thoughts..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}" class="text-decoration-none">Login</a> to leave a comment.
                </div>
                @endauth

                <!-- Comments List -->
                <div class="comments-list">
                    @foreach($post->comments->where('approved', true)->whereNull('parent_id') as $comment)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=4f46e5&color=fff" 
                                     alt="{{ $comment->user->name }}" 
                                     class="rounded-circle me-3" 
                                     width="40" 
                                     height="40">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-2">{{ $comment->content }}</p>
                                    
                                    @auth
                                    <button class="btn btn-sm btn-outline-secondary" 
                                            onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('d-none')">
                                        <i class="fas fa-reply me-1"></i>Reply
                                    </button>
                                    @endauth
                                </div>
                            </div>

                            <!-- Reply Form (Hidden by default) -->
                            @auth
                            <div id="reply-form-{{ $comment->id }}" class="mt-3 d-none">
                                <form action="{{ route('comments.store', $post) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <div class="mb-2">
                                        <textarea class="form-control form-control-sm" name="content" 
                                                  rows="2" placeholder="Write a reply..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
                                    <button type="button" class="btn btn-secondary btn-sm" 
                                            onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.add('d-none')">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                            @endauth

                            <!-- Replies -->
                            @foreach($comment->replies->where('approved', true) as $reply)
                            <div class="ms-5
                            