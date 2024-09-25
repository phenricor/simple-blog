<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function search(Request $request){
        $category = Category::where('id', $request->id)->first();
        $categoryName = $category->name;
        $posts = $category->posts;
        $title = "Results for {$categoryName}";
        return view('categories.search', compact('posts', 'title', 'categoryName'));
    }

    public function store($requestCategory, Post $post) {
        $category_array = explode(',', $requestCategory);
        foreach ($category_array as $stringCategory) {
            $stringCategory = trim($stringCategory);
            $modelCategory = Category::where('name', $stringCategory);
            if ($modelCategory->count() <= 0) {
                $category = new Category();
                $category->name = $stringCategory;
                $category->save();
            }
            $post->categories()->attach($modelCategory->first());
        }
    }

    public function update($requestCategory, Post $post)
    {
        $category_array = explode(',', $requestCategory);
        $post->categories()->detach();
        foreach ($category_array as $stringCategory) {
            $stringCategory = trim($stringCategory);
            $modelCategory = Category::where('name', $stringCategory);
            if ($modelCategory->count() <= 0) {
                $category = new Category();
                $category->name = $stringCategory;
                $category->save();
            }
            $post->categories()->attach($modelCategory->first());
        }
    }
}