@extends('layouts.layout')

@section('content')
<div class="container mt-3">
    <h1 class="text-center mb-3">Новый пост</h1>
    <form action="{{ route('profile.index') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" name="name" placeholder="Введите название" value="{{ old('name') }}">
        </div>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Введите описание">{{ old('description') }}</textarea>
        </div>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="category" class="form-label">Категория</label>
            <select class="form-select" name="category">
                <option selected disabled>Выберите категорию</option>
                @foreach($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
        @error('category')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select class="form-select" name="status">
                <option selected disabled>Статуc</option>
                @foreach($status as $s)
                <option value="{{ $s }}">{{ $s }}</option>
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
        <button type="submit" class="btn btn-primary mb-3">Создать пост</button>
    </form>
</div>
@endsection
