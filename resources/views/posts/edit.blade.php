@extends('layouts.app')
@section('title', 'Edit post')

@section('content')
@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="input-group input-group-lg mb-3">
            <span class="input-group-text" id="inputGroup-sizing-lg">Title</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" maxlength="100" name="title" id="title" value="{{ $post->title }}" required>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image" value="{{ $post->image }}">
        </div>
        <div class="mb-3">
            <div id="editor" style="height: 400px;">{!! $post->description !!}</div>
            <input type="hidden" name="description" id="description">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Categories</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="category" name="category" value="{{$post->categories->pluck('name')->implode(', ');}}">
        </div>
        <p style="font-size:10px">Separate categories using comma (,).</p>
        <div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a class="btn btn-secondary" href="{{ route('posts.index') }}">Cancel</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelector('#description').value = quill.root.innerHTML;
    });
</script>
@endsection
