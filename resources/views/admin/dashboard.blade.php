
@extends('layouts.app')
@section('max-width', '1000px')
@section('title', 'Dashboard')

@section('content')

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="postsTab" data-bs-toggle="tab" href="#posts" data-bs-target="#posts" type="button" role="tab" aria-controls="posts" aria-selected="true">Posts</button>
    <button class="nav-link" id="commentsTab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">Comments</button>
    <button class="nav-link" id="pagesTab" data-bs-toggle="tab" data-bs-target="#pages" type="button" role="tab" aria-controls="pages" aria-selected="false">Pages</button>
  </div>
</nav>
<div class="tab-content mt-3" id="nav-tabContent">
  <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts">
    @include('admin.tabs.posts')
  </div>
  <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments">
    @include('admin.tabs.comments')
  </div>
  <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages">
    @include('admin.tabs.pages')
  </div>
</div>


@endsection