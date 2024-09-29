<?php

use App\Http\Controllers\AdminController;
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

// Admin routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');

// Categories routes
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

// Posts routes
Route::resource('posts', PostController::class)->except(['show', 'edit', 'showId'])->middleware('auth');
Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post_id}', [PostController::class, 'showId'])->name('posts.showId');

// Comments route

Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');


Route::post('/approveComment', [CommentController::class, 'approveComment'])->name('comments.approveComments')->middleware('auth');