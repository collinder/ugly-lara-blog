@extends('layouts.layout')

@section('content')
<div class="container mt-3">
    <h1 class="text-center mb-3">Редактировать</h1>
    <form action="{{ route('profile.update', ['profile' => $post->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <img width="100" height="100" src="{{ route('image.view', ['img_path' => $post->img_path]) }}" alt="default">
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" name="name" placeholder="Введите название" value="{{ old('name', $post->name) }}">
        </div>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Введите описание">{{ old('description', $post->description) }}</textarea>
        </div>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="category" class="form-label">Категория</label>
            <select class="form-select" name="category">
                <option selected disabled>Выберите категорию</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{$category === $post->category ? "selected" : ""}}>{{ $category }}</option>
                @endforeach
            </select>
        </div>
        @error('category')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select class="form-select" name="status">
                <option selected disabled>Статус</option>
                @foreach($status as $s)
                <option value="{{ $s }}" {{ $s === $post->status ? "selected" : "" }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        @error('status')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
        <label for="image">Картинка:</label>
        <input type="file" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary mb-3">Изменить</button>
    </form>
</div>
@endsection
