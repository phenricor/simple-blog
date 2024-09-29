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
        <a type="button" class="btn btn-primary" href="{{ route('posts.edit', $post->slug) }}">
            <i class="fa-solid fa-pencil"></i>
        </a>
        <form action="{{ route('posts.destroy', $post) }}" method='POST'>
            @csrf
            @method('DELETE')

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal">
                <i class="fas fa-trash"></i>
            </button>

            <!-- Modal component -->
            <x-modal id="delete" type="danger" title="Confirm Post Deletion">
                Are you sure you want to delete this post?
            </x-modal>

        </form>
    </div>
    @endif
</div>
    <!-- Admins can see comments with any status. While guests only with status approved (id 1) -->
     @include('posts.comments')
</div>
@endsection