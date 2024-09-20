@extends('layouts.app')
@section('title', 'Laravel Blog Project')

@section('content')
    @if($posts->count() <= 0)
        <div>
            <h2>No posts available.</h2>
        </div>
    @else
    <h1><strong>Articles</strong></h2>
        @foreach ($posts as $post)
            <div class="card px-md-4 pt-md-4 my-md-2">
                <a style="text-decoration: none" href="{{ route('posts.show', $post) }}">
                    <p class="h2 text-dark font-weight-bold">{{ $post->short_title }}</p>
                </a>
                <p style="font-size:10px">{{ $post->created_at }}</p>
                <div>
                    {!! strip_tags($post->short_description) !!}
                </div>
                <div class="mt-md-3">
                    <p style="color:gray">{{ $post->comments()->count() }} comentários</p>
                </div>
            </div>
        @endforeach
    @endif
@endsection