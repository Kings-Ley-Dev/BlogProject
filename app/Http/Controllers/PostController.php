<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a single blog post (frontend view)
     */
    public function show(Post $post)
    {
        // Only show published posts to the public
        if (!$post->published && !auth()->check()) {
            abort(404);
        }

        // Load relationships for the view
        $post->load('user', 'category', 'tags', 'comments.user');
        
        return view('blog.show', compact('post'));
    }
}
