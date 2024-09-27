<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderby("created_at", "desc")->paginate(5);
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
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',
            'category' => 'nullable'
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $slug = $this->createSlug($request->title);
        $post->slug = $slug;
        if ($request->hasFile('image')) {
            $fileName = $slug.'-'.time().'.'.$request->image->extension();
            $filePath = $request->file('image')->storeAs('posts', $fileName, 'public');
            $post->image = $filePath;
        }
        $post->save();

        $categoryController = new CategoryController;
        $categoryController->store($request->category, $post);
        return redirect()->route('posts.show', $post->slug)->with("success", "Your post was created successfully!");
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $commentController = new CommentController;
        $comments = $commentController->index()->where('post_id', $post->id)->sortByDesc("created_at");

        return view('posts.show', compact('post', 'comments'));
    }

    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
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

        $categoryController = new CategoryController;
        $categoryController->update($request->category, $post);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Your post was updated succesfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Your post was deleted successfully.');
    }

    public function createSlug($title)
    {
        // Counting all posts even the ones soft deleted
        $count = Post::withTrashed()->where("title", $title)->count();
        $slug = Str::slug($title);
        if ($count > 0) {
            return $slug = $slug . "-" . $count;
        }
        else {
            return $slug = $slug;
        }
    }
}