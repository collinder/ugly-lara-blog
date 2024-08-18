@extends('layouts.gue')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="d-inline card-title">{{ $post->name }}</h5>
                    <p class="card-text">{{ substr($post->created_at, 0, 60) }}...</p>
                    <p class="float-end text-muted fst-italic">Статус: {{ $post->status }}</p>
                </div>
                <div class="card-body">
                    <img width="40" height="40" src="{{ route('image.view', ['img_path' => $post->img_path]) }}" alt="default.jpg">
                    <p class="card-text">{{ $post->description }}</p>
                    <p class="card-text fw-semibold fst-italic">Категория: {{ $post->category }}</p>
                    <a href="{{ route('guest.index') }}" class="btn btn-success">Назад</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
