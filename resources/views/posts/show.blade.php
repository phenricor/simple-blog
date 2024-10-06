@extends('layouts.app')
@section('title', $post->title)

@section('content')
<div class="container">
    <div>
        <div>
            <span class="h2">{{ $post->title }}</span>
            @if (Auth::check())
            <span class="d-flex align-items-star">
                <a class="me-2" style="color:black" type="button" href="{{ route('posts.edit', $post->slug) }}">
                    <i class="fa-solid fa-pen"></i>
                </a>
                <!-- Button trigger modal -->
                <a type="button" style="color:black" data-bs-toggle="modal" data-bs-target="#delete-modal">
                    <i class="fas fa-trash"></i>
                </a>
                <form action="{{ route('posts.destroy', $post) }}" method='POST'>
                    @csrf
                    @method('DELETE')
                    <!-- Modal component -->
                    <x-modal id="delete" type="danger" title="Confirm Post Deletion">
                        Are you sure you want to delete this post?
                    </x-modal>
                </form>
            </span>
            @endif
        </div>
        <p class="text-muted">{{ $post->created_at->format('Y-m-d') }}</p>
        <div class="d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/' . $post->image) }}" alt="" style="width:60%;height:60%;">
        </div>
        <div class="my-3">
            {!! $post->description !!}
        </div>
        @if ($post->categories->count() > 0)
        <div class="my-3 d-flex align-items-center">
            <span class="me-2">
                <i class="fa-solid fa-tag"></i>
            </span>
            @foreach ($post->categories as $category)
            <a href="/categories/search?id={{$category->id}}" class="badge bg-dark me-2" style="border-radius:0; text-decoration:none">{{ $category->name }}</a>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Admins can see comments with any status. While guests only with status approved (id 1) -->
@include('posts.comments')
</div>
@endsection