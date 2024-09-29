<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $posts = Post::orderby("created_at", "desc")->paginate(15);
        $comments = Comment::orderby("created_at", "desc")->whereNull('deleted_at')->paginate(20);
        return view('admin.dashboard', compact('posts', 'comments'));
    }
}
