<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
}
