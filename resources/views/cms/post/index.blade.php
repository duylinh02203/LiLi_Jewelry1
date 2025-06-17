@extends('cms.layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Bài viết mới nhất</h2>
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                @if($post->image)
                <img src="{{ asset('images/posts/' . ($post->image ?? 'default.png')) }}" alt="Post Image"
                    style="width: 100%; height: auto; object-fit: cover; border-radius: 5px;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                    <a href="{{ route('shop.posts.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3">
        {{ $posts->links() }}
    </div>
</div>
@endsection