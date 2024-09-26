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
            'content' => 'required|max:255',
            'post_id' => 'required',
            'name' => 'required|max:60',
            'email' => 'required|email'
        ]);
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->post_id = $request->post_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->save();
        return redirect()->route('posts.show', '$post->slug')->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment, Request $request)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}