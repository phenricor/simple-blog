<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderby("created_at", "desc")->paginate(5);

        foreach ($posts as $post) {
            $post->short_title = $this->fitText($post->title, 100, "..."); // Ajuste o comprimento conforme necessário
            $post->short_description = $this->fitText($post->description, 400, " (...)");
        }

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048' 
        ]);
        $slug = Str::slug($request->title);
        $fileName = $slug.'-'.time().'.'.$request->image->extension();
        $filePath = $request->file('image')->storeAs('posts', $fileName, 'public');
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $filePath;
        $post->save();

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $commentController = new CommentController;
        $comments = $commentController->index()->where('post_id', $post->id)->sortByDesc("created_at");

        return view('posts.show', compact('post', 'comments'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        #if ($request->title == $post->title && $request->description == $request->description) {
        #    return redirect()->back()->withErrors(['error' => 'Please provide a new title and description for updating.']);
        #}

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048' 
        ]);
        $post->title = $request->title;
        $post->description = $request->description;
        if ($request->hasFile('image')) {
            $slug = Str::slug($request->title);
            $fileName = $slug.'-'.time().'.'.$request->image->extension();
            $filePath = $request->file('image')->storeAs('posts', $fileName, 'public');
            $post->image = $filePath;
        }
        $post->update();
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function fitText($text, $len, $etc)
    {
        if(strlen($text) > $len) 
        {
            return Str::take($text, $len) . $etc;
        }
        else 
        {
            return $text;
        }       
    }
}