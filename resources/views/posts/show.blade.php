@extends('layouts.app')
@section('title', $post->title)

@section('content')
<div class="container">
    <div>
        <p class="h2">{{ $post->title }}</p>
        <p class="text-muted">{{ $post->created_at->format('Y-m-d') }}</p>
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/' . $post->image) }}" alt="" style="width:60%;height:60%;">
        </div>
        <div class="my-3">
            {!! $post->description !!}
        </div>
        @if ($post->categories->count() > 0)
        <div class="container ps-0 mb-3">
            <span class="fw-bold">Categories:</span>
            @foreach ($post->categories as $category)
            <a href="" class="badge bg-dark" style="border-radius:0; text-decoration:none">{{ $category->name }}</a>
            @endforeach
        </div>
        @endif
    </div>
    @if (Auth::check())
    <div style="display:flex; justify-content: flex-start; gap:10px">
        <a type="button" class="btn btn-primary" href="{{ route('posts.edit', $post) }}">
            <i class="fa-solid fa-pencil"></i>
        </a>
        <form action="{{ route('posts.destroy', $post) }}" method='POST'>
            @csrf
            @method('DELETE')
            <button type='submit' class="btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
    @endif
</div>
<div class="container">
    <p class="h2 mt-xl-5" id="comment-section">Comments</p>
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-md-3">Submit</button>
        <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
        <input type="hidden" id="user_id" name="user_id" value="1">
    </form>
    <div>
        @foreach ($comments as $comment)
        <div style="width:80%; word-wrap: break-word; border-radius:5px; margin-top: 10px; padding: 10px 10px 10px 10px">
            <div>
                <p style="margin-bottom:0px; font-size:10px">{{ $comment->created_at }}</p>
                <p><b>{{ $comment->user->name }}</b> says:</p>
            </div>
            <p>{{ $comment->content }}</p>
            @if(Auth::check())
            <form action="{{ route('comments.destroy', $comment) }}" method='POST'>
                @csrf
                @method('DELETE')
                <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                <button type='submit' class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection