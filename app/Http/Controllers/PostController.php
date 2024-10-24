<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $allPosts = Post::orderby("created_at", "desc")->where('page', '<>', true)->paginate(5);
        $onlyPublishedPosts = Post::orderby("created_at", "desc")->where('page', '<>', true)->where('published',true)->paginate(5);
        return view('posts.index', compact('allPosts', 'onlyPublishedPosts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        # Handles schedule date input based on user server timezone
        if ($request->schedule_check == "true" && $request->scheduled_to !== null) {
            $timezoneDate = Carbon::createFromFormat('Y-m-d H:i', $request->scheduled_to, $request->timezone)->setTimezone('UTC');
            $validator = Validator::make(['scheduled_to'=>$timezoneDate->toDateTimeString()], [
                'scheduled_to' => 'nullable|date|after:now'
            ]);
           if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
        }

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
            $fileName = $slug . '-' . time() . '.' . $request->image->extension();
            $filePath = $request->file('image')->storeAs('posts', $fileName, 'public');
            $post->image = $filePath;
        }
        if ($request->schedule_check == "true" && $request->scheduled_to !== null) {
            $post->scheduled_to = $timezoneDate->toDateTime();
            $post->published = false;
            $message = "Your post was scheduled succesfully to " . $timezoneDate->toDateTimeString();
        }
        else {
            $post->published = true;
            $message = "Your post was created succesfully!";
        }
        $post->save();

        if ($request->category !== null) {
            $categoryController = new CategoryController;
            $categoryController->store($request->category, $post);
        }

        return redirect()->route('posts.show', $post->slug)->with("success", $message);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $comments = $this->getPostComments($post);
        $allComments = $comments->where(function ($query) {
            $query->where('status', 0)
                ->orWhere('status', 1)
                ->orWhere('status', 3);
        })
            ->get();
        $approvedComments = $comments->where('status', 1)->get();

        return view('posts.show', compact('post', 'allComments', 'approvedComments'));
    }

    public function showId($post_id)
    {
        $post = Post::where('id', $post_id)->firstOrFail();
        dd($post);

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
            $fileName = $slug . '-' . time() . '.' . $request->image->extension();
            $filePath = $request->file('image')->storeAs('posts', $fileName, 'public');
            $post->image = $filePath;
        }
        $post->update();

        $categoryController = new CategoryController;
        $categoryController->update($request->category, $post);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Your post was updated succesfully!');
    }

    public function destroy(Post $post, Request $request)
    {
        $post->delete();
        if ($request->dashboard === "1") {
            return redirect()->back()->with('success', 'Your post was deleted successfully.');
        }
        return redirect()->route('posts.index')->with('success', 'Your post was deleted successfully.');
    }

    public function createSlug($title)
    {
        // Counting all posts even the ones soft deleted
        $count = Post::withTrashed()->where("title", $title)->count();
        $slug = Str::slug($title);
        if ($count > 0) {
            return $slug = $slug . "-" . $count;
        } else {
            return $slug = $slug;
        }
    }

    public function getPostComments(Post $post)
    {
        $comments = Comment::where([['post_id', $post->id], ['deleted_at', null]]);
        return $comments;
    }
}
