@extends('layouts.admin.app')

@section('title', 'Todo Categories')
@section('content')
    <div class="container mt-4">
        <h1>Todo Categories</h1>
        <a href="{{ route('todo_categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Menampilkan nomor urut -->
                        <td>{{ $category->category }}</td>
                        <td>
                            <a href="{{ route('todo_categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('todo_categories.destroy', $category->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
