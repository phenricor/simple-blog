
@extends('layouts.app')
@section('max-width', '1000px')
@section('title', 'Dashboard')

@section('content')

<?php
# Each nav-tab must have as aria-controls the same value of the route of its view. For example, nav-tab with aria-controls = comments must have a route that is /admin/comments.
?>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="postsTab" data-bs-toggle="tab" href="#posts" data-bs-target="#posts" type="button" role="tab" aria-controls="posts" aria-selected="true">Posts</button>
    <button class="nav-link" id="commentsTab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">Comments</button>
    <button class="nav-link" id="pagesTab" data-bs-toggle="tab" data-bs-target="#pages" type="button" role="tab" aria-controls="pages" aria-selected="false">Pages</button>
    <button class="nav-link" id="settingsTab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
  </div>
</nav>
<div class="tab-content mt-3" id="nav-tabContent">
  <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts">
  </div>
  <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments">
  </div>
  <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages">
  </div>
  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings">
  </div>
</div>
<script>
// Checks each nav-tab button for aria-selected, then routes to respective routing
//
    function loadView() {
        let controls = $("button[aria-selected='true']").attr('aria-controls');
        let route = `/admin/${controls}`;
        $(`#${controls}`).load(`${route}`);
    }
    $(document).ready(function() {
        loadView();
    });
    $("button[role='tab'").click(function() {
        loadView();
    });
</script>
@endsection
