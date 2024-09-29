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
<!-- Comment section -->
<div class="container my-4">
    <p class="h4">Leave a comment</p>
    <div class="card px-4 py-4" id="add-comment-section">
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div id="content-box" class="my-0">
                <label class="fw-bold" for="content">Message</label>
                <textarea maxlength="255" rows='5' name="content" id="content" class="form-control" aria-label="With textarea"></textarea>
            </div>
            <div id="name-box" class="my-2">
                <div>
                    <label class="fw-bold" for="name">Name</label>
                </div>
                <input placeholder="Your name" maxlength="60" class="form-control" type="text" name="name" id="name" required>
            </div>
            <div id="email-box" class="my-2">
                <div>
                    <label class="fw-bold" for="email">Email</label>
                </div>
                <input placeholder="Your e-mail" maxlength="60" class="form-control" type="email" name="email" id="email" required>
            </div>
            <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
            <button type="submit" class="mt-3 btn btn-outline-primary">Submit comment</button>
        </form>
    </div>
    <!-- Admins can see comments with any status. While guests only with status approved (id 1) -->
    <div class="my-3">
        <p class="h4" id="comment-section" name="comment-section">Comments</p>
        @if(Auth::check())
        @if($comments->count() <= 0)
            <p>No comments yet</p>
            @else
            @foreach ($comments as $comment)
            <div class="container ps-0">
                <div>
                    <span class="fw-bold">{{ $comment->name }}</span>
                    <span>({{ $comment->created_at }}):</span>
                    <div>
                        <p class='{{ $comment->statusColor }}'>{{ $comment->statusString }}</p>
                    </div>
                </div>
                <p>{{ $comment->content }}</p>
                <form action="{{ route('comments.destroy', $comment) }}" method='POST'>
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#postDelete-modal">
                        <i class="fas fa-trash"></i>
                    </button>
                    <!-- Modal component -->
                    <x-modal id="postDelete" type="danger" title="Confirm Comment Deletion">
                        Are you sure you want to delete this comment?
                    </x-modal>

                </form>
            </div>
            @endforeach
            @endif
            @else
            @if ($comments->where('status', 1)->count() <= 0)
                <p>No comments yet<p>
                    @else
                    @foreach($comments->where('status',1)->get() as $comment)
                <div class="container ps-0">
                    <div>
                        <span class="fw-bold">{{ $comment->name }}</span>
                        <span>({{ $comment->created_at }}):</span>
                        <div>
                            <p class='{{ $comment->statusColor() }}'>{{ $comment->statusString() }}</p>
                        </div>
                    </div>
                    <p>{{ $comment->content }}</p>
                </div>
                @endforeach
                @endif
                @endif
    </div>
</div>
@endsection