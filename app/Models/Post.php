<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comment;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
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
        return Comment::where([['post_id', $this->id], ['deleted_at', null], ['status', '<>', 2]])->count();
    }
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($this->updated_at)
            ->link($this->link)
            ->authorName('teste')
            ->authorEmail('teste');
    }
    public static function getFeedItems()
    {
        return static::latest()->take(15)->get();
    }
    public function getLinkAttribute()
    {
        return route('posts.show', $this->slug);
    }
}
