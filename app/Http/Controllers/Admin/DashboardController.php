<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('published', true)->count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('approved', false)->count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
        ];

        $recent_posts = Post::with('user', 'category')
            ->latest()
            ->take(5)
            ->get();

        $recent_comments = Comment::with('user', 'post')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_comments'));
    }

    
    // Add these methods for dashboard functionality
    public function getPostStats()
    {
        $posts = Post::selectRaw('
            COUNT(*) as total,
            SUM(published = 1) as published,
            SUM(published = 0) as drafts
        ')->first();

        return response()->json($posts);
    }

    public function getRecentActivity()
    {
        $recentPosts = Post::with('category')
            ->latest()
            ->take(5)
            ->get();

        $recentComments = Comment::with('post')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'posts' => $recentPosts,
            'comments' => $recentComments
        ]);
    }
}
