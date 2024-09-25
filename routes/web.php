<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index']);
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);