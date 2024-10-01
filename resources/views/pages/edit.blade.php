@extends('layouts.app')
@section('title', 'About')
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
    <form action="{{ route('pages.update', $page) }}" method="POST">
        @csrf
        <div class="input-group input-group-lg mb-3">
            <span class="input-group-text" id="inputGroup-sizing-lg">Title</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" maxlength="100" name="title" id="title" value="{{ $page->title }}" required>
        </div>
        <div class="mb-3">
            <div id="editor" style="height: 400px;">{!! $page->description !!}</div>
            <input type="hidden" name="description" id="description">
        </div>
        <div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a class="btn btn-secondary" href="{{ redirect()->back() }}">Cancel</a>
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