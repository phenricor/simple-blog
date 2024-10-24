<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

class AdminController extends Controller
{
    public function dashboard() {
        $posts = $this->posts();
        $pages = $this->pages();
        $comments = $this->comments();
        $settings = $this->settings();
        return view('admin.dashboard', compact('posts', 'comments', 'pages', 'settings'));
    }

    public function comments()
    {
        $comments = Comment::orderby("created_at", "desc")->whereNull('deleted_at')->paginate(20);
        return $comments;
    }

    public function posts()
    {
        $posts = Post::orderby("created_at", "desc")->where('page', '<>', true)->paginate(15);
        return $posts;
    }

    public function pages()
    {
        $pages = Post::orderby("created_at", "desc")->where('page', true)->get();
        return $pages;
    }

    public function settings()
    {
        $settings = new SettingController;
        $settings = $settings->index();
        return $settings;
    }
}
