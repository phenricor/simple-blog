<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/admin', [UserController::class, 'login']);
Route::post('/admin/login', [UserController::class, 'auth'])->name("admin.auth");
Route::get('/admin/logout', [UserController::class, 'logout'])->name("admin.logout");

Route::get('/', [PostController::class, 'index']);
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);