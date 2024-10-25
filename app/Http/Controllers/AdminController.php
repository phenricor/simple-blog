<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function loadPosts() {
        $posts = Post::orderby("created_at", "desc")->where('page', '<>', true)->paginate(15);
        return view('admin.tabs.posts', compact('posts'));
    }

    public function loadComments()
    {
        $comments = Comment::orderby("created_at", "desc")->whereNull('deleted_at')->paginate(20);
        return view('admin.tabs.comments', compact('comments'));
    }

    public function loadPages()
    {
        $pages = Post::orderby("created_at", "desc")->where('page', true)->get();
        return view('admin.tabs.pages', compact('pages'));
    }

    public function loadSettings()
    {
        $settings = new SettingController;
        $settings = $settings->index();
        return view('admin.tabs.settings', compact('settings'));
    }
}
