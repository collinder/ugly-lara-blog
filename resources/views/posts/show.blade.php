@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title d-inline">{{$post->name}}</h5>
                    <p class="float-end text-muted fst-italic">Автор: {{ $post->users->name }}</p>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $post->description }}</p>
                    <p class="card-text fw-semibold fst-italic">Категория: {{ $post->category }}</p>
                    <a href="{{ route('posts.index') }}" class="btn btn-success">Back</a>
                </div>
                <div style="max-height: 260px;" class="card-footer overflow-auto">
                    <div class="card-body p-4">
                        <div class="form-outline mb-4">
                            <form class="d-flex" action="/comments" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <img width="100" height="100" src="{{ route('image.view', ['img_path' => $post->img_path]) }}" alt="default">
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <input class="form-control me-2" type="text" name="comment" placeholder="Write a comment...">
                                <button class="btn btn-outline-success" type="submit">
                                    <i class="fa-regular fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>

                        @foreach($comments as $comment)
                        @if($post->id === $comment->post_id)
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p>{{ $comment->users->name }}</p>
                                    <span class="small text-muted fst-italic">{{ substr($comment->created_at, 0, 10) }}</span>
                                </div>
                                <hr class="mt-0">
                                <p>{{ $comment->comment }}</p>
                                @if($comment->user_id === Auth::user()->id)
                                <p class="small mb-0">

                                <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
