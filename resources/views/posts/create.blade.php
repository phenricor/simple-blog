@extends('layouts.app')
@section('title', 'Create new post')

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
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <div>
                <label for="title" class="form-label">Title</label>
            </div>
            <input class="title-control" id="title" name="title" placeholder="Title of your post">
        </div>
        <div class="mb-3">
            <div id="editor" style="height: 400px;"></div>
            <input type="hidden" name="description" id="description">
            <!-- <label for="description" class="form-label">Description</label> -->
            <!-- <textarea class="form-control" id="description" name="description" rows="3"></textarea> -->
        </div>
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
    document.querySelector('#description').value = quill.root.innerHTML;});
</script>
@endsection
