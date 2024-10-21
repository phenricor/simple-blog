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
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group input-group-lg mb-3">
            <span class="input-group-text" id="inputGroup-sizing-lg">Title</span>
            <input type="text" class="form-control" id="title" name="title" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" maxlength="100" required>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image">
        </div>
        <div class="mb-3">
            <div id="editor" style="height: 400px;"></div>
            <input type="hidden" name="description" id="description">
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Categories</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="category" name="category">
        </div>
        <p style="font-size:10px">Separate categories using comma (,).</p>
        <div class="mt-3 mb-2">
            <input type="checkbox" id="schedule-check" name="schedule-check">
            <label for="schedule-check">Schedule post</label>
        </div>
        <div id="schedule-section" class="my-3" style="display:none">
            <label for="schedule-to">Schedule for</label>
            <input type="text" class="form_control" id="schedule-to" name="scheduled_to">
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
        document.querySelector('#description').value = quill.root.innerHTML;
    });

    $("#schedule-check").change(function() {
        $("#schedule-section").toggle();
    })

    $("#schedule-to").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>
@endsection