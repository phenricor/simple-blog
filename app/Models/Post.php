<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'image', 'slug'];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function countApprovedComments()
    {
        return Comment::where([['post_id', $this->id], ['status', 1], ['deleted_at', null]])->count();
    }
    public function countPendingComments()
    {
        return Comment::where([['post_id', $this->id], ['status', 0], ['deleted_at', null]])->count();
    }
    public function countAllComments()
    {
        return Comment::where([['post_id', $this->id], ['deleted_at', null]])->count();
    }
}
