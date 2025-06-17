@extends('cms.layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">{{ $post->title }}</h2>

    @if($post->image)
    <img src="{{ asset('images/posts/' . ($post->image ?? 'default.png')) }}" alt="Post Image"
        style="width: auto; height: auto; object-fit: cover; border-radius: 5px;">
    @endif

    <div class="post-content">
        {!! $post->content !!}
    </div>

    <a href="{{ route('shop.posts.index') }}" class="btn btn-secondary mt-4">← Quay lại danh sách</a>
</div>
@endsection