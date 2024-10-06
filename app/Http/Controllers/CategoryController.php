<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $query = DB::select('SELECT DISTINCT(category_id) 
            FROM (SELECT id from posts WHERE deleted_at IS NULL) a 
            INNER JOIN category_post b ON a.id = b.post_id');
        $categoryIds = array_map(function ($category) {
            return $category->category_id;
        }, $query);
        $categories = Category::find($categoryIds);
        return view('categories.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        $categoryName = $category->name;
        $posts = $category->posts;
        $title = "Results for {$categoryName}";
        return view('categories.search', compact('posts', 'title', 'categoryName'));
    }

    public function store($requestCategory, Post $post)
    {
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
