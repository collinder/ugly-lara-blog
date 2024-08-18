@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    @if (session('msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <a href="{{ route('profile.create') }}" class="btn btn-primary">Создать</a>
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="d-inline card-title">{{ $post->name }}</h5>
                    <p class="card-text">{{ substr($post->created_at, 0, 60) }}...</p>
                    <p class="float-end text-muted fst-italic">Статус: {{ $post->status }}</p>
                </div>
                <div class="card-body">
                    <img width="40" height="40" src="{{ route('image.view', ['img_path' => $post->img_path]) }}" alt="default">
                    <p class="card-text">{{ substr($post->description, 0, 60) }}...</p>
                    <a href="{{ route('profile.show', ['profile' => $post->id]) }}" class="btn btn-success">Подробнее</a>
                    <a href="{{ route('profile.edit', ['profile' => $post->id]) }}" class="btn btn-primary">Изменить</a>
                    <form action="{{ route('profile.destroy', ['profile' => $post->id]) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
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
