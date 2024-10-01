<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Rules\MaxThreePages;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Post::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => ['required', new MaxThreePages]
        ]);
        $slug = new PostController;
        $page = new Post();
        $page->title = $request->title;
        $page->slug = $slug->createSlug($request->title);
        $page->description = "Work in Progress";
        $page->page = true;
        $page->save();
        return redirect()->back()->with('success', 'Page created successfully!');
    }

    public function edit(Post $page) {
        return view('pages.edit', compact('page'));
    }

    public function update(Post $page, Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $page->title = $request->title;
        $page->description = $request->description;
        $page->save();
        return redirect()->route('pages.show', $page->slug)->with('success', 'Page updated succesfully!');
    }

    public function destroy(Post $page) {
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully!');
    }
}
