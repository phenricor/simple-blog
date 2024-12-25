@extends('layouts.app')
@section('title', $title)

@section('content')
<p class="h3">{{$posts->count()}} results for "{{ $search }}"</p>
@foreach ($posts as $post)
            <div class="card px-md-4 pt-md-4 my-md-2">
                <a style="text-decoration: none" href="{{ route('posts.show', $post->slug) }}">
                    <p class="h2 text-dark font-weight-bold">{{ $post->title }}</p>
                </a>
                <p class="mb-0" style="font-size:10px">{{ $post->created_at }}</p>
                @if($post->image)
                <div class="container ps-0">
                    <div class="row align-items-start">
                        <div class="col pt-4">
                            {!! strip_tags(Str::limit($post->description,300)) !!}
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="" style="width:80%;height:80%;">
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div>
                    {!! strip_tags(Str::limit($post->description,300)) !!}
                </div>
                @endif
                <div class="container ps-0 pt-2">
                    @foreach ($post->categories as $category)
                        <a href="/categories/search?id={{$category->id}}" class="badge bg-dark" style="border-radius:0; text-decoration:none">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="mt-2 mb-3">
                    <a style="text-decoration:none" href="{{ route('posts.show', $post->slug) }}#comment-section">
                        <span style="color:gray">{{ $post->countApprovedComments() }} comments</span>
                        @if (Auth::check() && $post->countPendingComments() > 0)
                            <span style="color:gray">({{ $post->countPendingComments() }} waiting approval)</span>
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
@endsection