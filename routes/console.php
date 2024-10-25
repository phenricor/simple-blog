<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Post;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
 
Schedule::call(function () {
    Post::where('scheduled_to', '<=', now())
    ->where('published', false)
    ->update(['published'=>true]);
})->everyMinute();
