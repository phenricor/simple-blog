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
                $this->statusString = "Pending";
                break;
            case 1:
                $this->statusString = "Approved";
                break;
            case 2:
                $this->statusString = "Reproved";
                break;
            default:
                $this->statusString = "Unknown";
                break;
        }
        return $this->statusString;
    }

    public function statusColor()
    {
        switch ($this->status) {
            case 0:
                $this->statusColor = "badge rounded-pill bg-warning text-dark";
                break;
            case 1:
                $this->statusColor = "badge rounded-pill bg-success";
                break;
            case 2:
                $this->statusColor = "badge rounded-pill bg-danger";
                break;
            default:
                $this->statusColor = "badge rounded-pill bg-secondary";
                break;
        }
        return $this->statusColor;
    }


    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
