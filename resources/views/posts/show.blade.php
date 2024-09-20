@extends('layouts.app')
@section('title', $post->title)

@section('content')
<a href="{{ url()->previous() }}"><u><- Go Back</u></a>
<div>
    <div class="container">
        <h1 style="font-size:50px">{{ $post->title }}</h1>
        <div style="margin-top:10px; margin-bottom:100px;">
            {!! $post->description !!}
        </div>
    </div>
    <div style="display:flex; justify-content: flex-start; gap:10px">
        <a type="button" class="btn btn-primary" href="{{ route('posts.edit', $post) }}">Edit</a>
        <form action="{{ route('posts.destroy', $post) }}" method='POST'>
            @csrf
            @method('DELETE')
            <button type='submit' class="btn btn-danger">Delete</button>
        </form>
    </div>
    <div>
        <h1>Comments</h1>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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
                <form action="{{ route('comments.destroy', $comment) }}" method='POST'>
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                    <button type='submit' class="btn btn-danger">Delete comment</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection