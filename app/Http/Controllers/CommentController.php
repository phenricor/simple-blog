<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @param bool $returnDeleted
     */
    public function index(bool $returnDeleted = false){
        if($returnDeleted) {
            $comments = Comment::all();
        }
        else {
            $comments = Comment::whereNull('deleted_at')->get();
        }
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
        $post = $comment->post;
        return redirect()->route('posts.show', $post->slug)->with('success', 'Your comment was sent to approval successfully.');
    }

    public function approveComment($request)
    {
        $comment = Comment::find($request);
        $comment->status = 1;
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function disapproveComment($request)
    {
        $comment = Comment::find($request);
        $comment->status = 2;
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
