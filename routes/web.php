<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;

Route::get('/', [PostController::class, 'index']);

// Auth routes
Route::get('/admin', [LoginController::class, 'login'])->name('login');
Route::post('/admin/login', [LoginController::class, 'auth'])->name("admin.auth");
Route::get('/admin/logout', [LoginController::class, 'logout'])->name("admin.logout")->middleware('auth');

// Categories routes
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

// Posts routes
Route::resource('posts', PostController::class)->except(['show', 'edit'])->middleware('auth');
Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Comment routes
Route::resource('comments', CommentController::class)->middleware('auth');