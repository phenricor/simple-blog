<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $comments = Comment::all();
        return $comments;
    }

    public function store(Request $request) {
        $request->validate([
            'content' => 'required',
            'post_id' => 'required',
            'user_id' => 'required'
        ]);

        Comment::create($request->all());
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment, Request $request)
    {
        $comment->delete();
        return redirect()->route('posts.show', $request->post_id);
    }
}