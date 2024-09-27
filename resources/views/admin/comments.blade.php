@extends('layouts.app')
@section('max-width', '1000px')
@section('title', 'Dashboard')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Email</th>
            <th scope="col">Name</th>
            <th scope="col">Content</th>
            <th scope="col">Post</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comments as $comment)
        <tr>
            <th class="align-middle" scope="row">{{ $comment->id }}</th>
            <td class="align-middle">{{ $comment->email }}</td>
            <td>{{ $comment->name }}</td>
            <td>{{ $comment->content }}</td>
            <td>
                <a href="{{ route('posts.show', $comment->post->slug) }}">
                    {{ $comment->post->title }}
                </a>
            </td>
            <td>{{ $comment->created_at }}</td>
            <td>{{ $comment->updated_at }}</td>
            <td>{{ $comment->status }}</td>
            <td>
                <div class="d-flex justify-content-between" style="gap:6px">
                    <!-- To do approve comment -->
                    <span id="approve-button">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal">
                            <i class="fa-solid fa-thumbs-up"></i>
                        </button>
                    </span>
                    <span id="delete-button">
                        <form action="{{ route('comments.destroy', $comment) }}" method='POST'>
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="dashboard" name="dashboard" value="1">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal">
                                <i class="fas fa-trash"></i>
                            </button>
                            <!-- Modal component -->
                            <x-modal>
                                <x-slot:title>
                                    Confirm Comment Deletion
                                </x-slot:title>

                                Are you sure you want to delete this comment?
                            </x-modal>
                        </form>
                    </span>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-xl-4 d-flex justify-content-center">
    {{ $comments->links("pagination::bootstrap-4") }}
</div>
@endsection