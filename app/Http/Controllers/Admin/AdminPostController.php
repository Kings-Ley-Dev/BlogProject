<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdminPostController extends Controller
{
    public function index()
    {
        $query = Post::with('user', 'category', 'tags');
        
        // Handle filters
        if (request()->has('filter')) {
            switch (request('filter')) {
                case 'published':
                    $query->where('published', true);
                    break;
                case 'drafts':
                    $query->where('published', false);
                    break;
            }
        }
        
        $posts = $query->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Resize and save image
            $imagePath = 'posts/' . $filename;
            Image::make($image)
                ->resize(800, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(storage_path('app/public/' . $imagePath));
            
            $data['featured_image'] = $imagePath;
        }

        $data['user_id'] = auth()->id();
        $data['slug'] = \Str::slug($data['title']);

        $post = Post::create($data);

        // Sync tags
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::delete('public/' . $post->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Resize and save image
            $imagePath = 'posts/' . $filename;
            Image::make($image)
                ->resize(800, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(storage_path('app/public/' . $imagePath));
            
            $data['featured_image'] = $imagePath;
        }

        $data['slug'] = \Str::slug($data['title']);

        $post->update($data);

        // Sync tags
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Delete image
        if ($post->featured_image) {
            Storage::delete('public/' . $post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    public function publish(Post $post)
    {
        $post->update([
            'published' => !$post->published,
            'published_at' => $post->published ? null : now()
        ]);

        $message = $post->published ? 'published' : 'unpublished';

        return back()->with('success', "Post {$message} successfully!");
    }
}
