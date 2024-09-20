@extends('layouts.app')
@section('title', 'Home')

@section('content')
    @if($posts->count() <= 0)
        <div>
            <h2>No posts available.</h2>
        </div>
    @else
    <h2>Articles</h2>
        @foreach ($posts as $post)
            <div class="card" style="padding-left:20px; padding-top:15px; margin-bottom:10px; padding-right:15px">
                <a style="text-decoration: none" href="{{ route('posts.show', $post) }}">
                    <h2>{{ $post->short_title }}</h2>
                </a>
                <p style="font-size:10px">{{ $post->created_at }}</p>
                <div>
                    {!! strip_tags($post->short_description) !!}
                </div>
                <div>
                    <p style="color:blue">{{ $post->comments()->count() }} comentários</p>
                </div>
            </div>
        @endforeach
    @endif
@endsection