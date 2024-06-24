@extends('layouts.admin.app')

@section('title', 'Ubah Catatan')

@section('content')
    <form method="POST" action="{{ route('todo.update', $todo->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $todo->title }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $todo->description }}">
        </div>
        <div class="mb-3">
            <label for="todo_category_id" class="form-label">Kategori</label>
            <select class="form-control" id="todo_category_id" name="todo_category_id">
                @foreach ($todocategories as $category)
                    <option value="{{ $category->id }}" {{ $todo->todo_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->category }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
