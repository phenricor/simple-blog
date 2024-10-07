<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SettingController;

Route::get('/', [PostController::class, 'index']);

// Auth routes
Route::get('/admin', [LoginController::class, 'login'])->name('login');
Route::post('/admin/login', [LoginController::class, 'auth'])->name("admin.auth");
Route::get('/admin/logout', [LoginController::class, 'logout'])->name("admin.logout")->middleware('auth');

// Admin routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');

// Categories routes
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Posts routes
Route::resource('posts', PostController::class)->except(['show', 'edit', 'showId'])->middleware('auth');
Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post_id}', [PostController::class, 'showId'])->name('posts.showId');

Route::feeds();

// Comments route

Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');
Route::post('/comments/{id}/approve', [CommentController::class, 'approveComment'])
    ->name('comments.approveComments')
    ->middleware('auth');
Route::post('/comments/{id}/disapprove', [CommentController::class, 'disapproveComment'])
    ->name('comments.disapproveComments')
    ->middleware('auth');

// Pages routes

Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/{page}/edit', [PageController::class, 'edit'])->name('pages.edit')->middleware('auth');
Route::post('/{page}/update', [PageController::class, 'update'])->name('pages.update');
Route::post('/store', [PageController::class, 'store'])->name('pages.store');
Route::delete('/{page}/destroy', [PageController::class, 'destroy'])->name('pages.destroy')->middleware('auth');

// Settings routes

Route::post('/setting/{key}/update', [SettingController::class, 'update'])->name('settings.update')->middleware('auth');