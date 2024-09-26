<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'post_id', 'name', 'email'];
    public $statusColor;
    public $statusString;

    public function __construct()
    {
        switch ($this->status) {
            case 0:
                $this->statusColor = "badge rounded-pill bg-warning text-dark";
                $this->statusString = "Pending";
                break;
            case 1:
                $this->statusColor = "badge rounded-pill bg-success";
                $this->statusString = "Approved";
                break;
            case 2:
                $this->statusColor = "badge rounded-pill bg-danger";
                $this->statusString = "Reproved";
                break;
            default:
                $this->statusColor = "badge rounded-pill bg-secondary";
                $this->statusString = "Unknown";
                break;
        }
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
