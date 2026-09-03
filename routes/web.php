<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController as FrontendCommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Public Routes
Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('blog.post.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/search', [BlogController::class, 'search'])->name('blog.search');

// Authentication Routes
Auth::routes();

// Comment Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::post('/comments/{post}', [FrontendCommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [FrontendCommentController::class, 'destroy'])->name('comments.destroy');
});

// Home route to point to blog index
Route::get('/home', [BlogController::class, 'index'])->name('home.redirect');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts 
    Route::get('posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [AdminPostController::class, 'create'])->name('posts.create');
    Route::post('posts', [AdminPostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}', [AdminPostController::class, 'show'])->name('posts.show');
    Route::get('posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    
    // Additional post routes
    Route::post('posts/{post}/publish', [AdminPostController::class, 'publish'])->name('posts.publish');
    
    // Categories 
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Comments routes
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
