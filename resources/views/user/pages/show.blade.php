@extends('user.layouts.app')

@section('title', $page->title)

@section('content')
    <div class="container py-4">
        <h1 class="mb-3">{{ $page->title }}</h1>
        <div>{!! nl2br(e($page->content)) !!}</div>
    </div>
@endsection
