@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<p class="h1">List of Categories</p>
<ul class="ps-0">
@foreach ($categories as $category)
<li class="list-group-item">
    <a style="font-size:150%; text-decoration:none" href="/categories/search?id={{$category->id}}">{{$category->name}}</a>
    <span>({{$category->posts->count()}})</span>
</li>
@endforeach
</ul>
@endsection