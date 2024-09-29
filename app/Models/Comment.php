<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['content', 'post_id', 'name', 'email'];
    public $statusColor;
    public $statusString;

    public function __construct()
    {

    }

    public function statusString()
    {
        switch ($this->status) {
            case 0:
                $statusString = "Pending";
                break;
            case 1:
                $statusString = "Approved";
                break;
            case 2:
                $statusString = "Reproved";
                break;
            default:
                $statusString = "Unknown";
                break;
        }
        return $statusString;
    }

    public function statusColor()
    {
        switch ($this->status) {
            case 0:
                $statusColor = "badge rounded-pill bg-warning text-dark";
                break;
            case 1:
                $statusColor = "badge rounded-pill bg-success";
                break;
            case 2:
                $statusColor = "badge rounded-pill bg-danger";
                break;
            default:
                $statusColor = "badge rounded-pill bg-secondary";
                break;
        }
        return $statusColor;
    }


    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
