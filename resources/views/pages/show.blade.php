@extends('layouts.app')
@section('title', 'About')

@section('content')
<div class="container">
    <div>
        <div id="about-title">
            <span class="h1 fw-bold me-2"> {{ $page->title }}</span>
            @if (Auth::check())
            <span>
                <a href="{{ route('pages.edit', $page) }}">Edit</a>
            </span>
            @endif
        </div>
        <div class="my-3">
            {!! $page->description !!}
        </div>
    </div>
    @endsection