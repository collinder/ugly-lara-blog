@extends('layouts.gue')

@section('content')
<div class="container mt-5">
    @if (session('msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header">
                    <img width="40" height="40" src="{{ route('image.view', ['img_path' => $post->img_path]) }}" alt="default.jpg">
                    <h5 class="d-inline card-title">{{ $post->name }}</h5>
                    <p class="float-end text-muted fst-italic">Status: {{ $post->status }}</p>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ substr($post->description, 0, 60) }}...</p>
                    <a href="{{ route('guest.show', ['profile' => $post->id]) }}" class="btn btn-success">Подробнее</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3 float-end">
        {{ $posts->links() }}
    </div>
</div>
@endsection
