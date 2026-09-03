<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'category', 'tags')
            ->where('published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        $categories = Category::withCount(['posts' => function($query) {
            $query->where('published', true);
        }])->get();

        $recent_posts = Post::where('published', true)
            ->orderBy('published_at', 'desc') // Latest blog posted should be the first to show!
            ->take(3)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'recent_posts'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->with('user', 'category', 'tags')
            ->where('published', true)
            ->orderBy('published_at', 'desc') // Latest blog posted should be the first to show!
            ->paginate(6);

        return view('blog.category', compact('category', 'posts'));
    }

    public function tag(Tag $tag)
{
    $posts = $tag->posts()
        ->with('user', 'category', 'tags')
        ->where('published', true)
        ->orderBy('published_at', 'desc') // Latest blog posted should be the first to show!
        ->paginate(6);

    return view('blog.tag', compact('tag', 'posts'));
}

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $posts = Post::with('user', 'category', 'tags')
            ->where('published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                ->orWhere('content', 'like', "%$query%");
            })
            ->orderBy('published_at', 'desc') // Latest blog posted should be the first to show!
            ->paginate(6);

        return view('blog.search', compact('posts', 'query'));
    }
}