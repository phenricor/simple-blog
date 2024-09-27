<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function postManager() {
        $posts = Post::orderby("created_at", "desc")->paginate(15);
        return view('admin.posts', compact('posts'));
    }

    public function commentManager() {
        $comments = Comment::orderby("created_at", "desc")->paginate(20);
        return view('admin.comments', compact('comments'));
    }
}
