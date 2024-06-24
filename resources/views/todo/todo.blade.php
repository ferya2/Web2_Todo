@extends('layouts.admin.app')
@section('title', 'Catatan')

@section('content')
    <div class="mt-3 mb-3">
        <a href="{{ route('todo.create') }}" class="btn btn-success">Tambah Todo</a>
    </div>
    @foreach ($todos as $value)
        <div class="card">
            <div class="card-body">
                <p>{{ $value->category }}</p>
                <p>{{ $value->name }}</p>
                <p>{{ $value->email }}</p>
                <p>{{ $value->title }}</p>
                <p>{{ $value->description }}</p>
                <a href="{{ route('todo.edit', $value->todo_id) }}" class="btn btn-warning">Ubah</a>
                <form action="{{ route('todo.destroy', $value->todo_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach
@endsection
