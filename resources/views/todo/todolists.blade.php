@extends('layouts.admin.app')

@section('title', 'Todo Lists')

@section('content')
    <div class="container">
        <h2>Todo Lists</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Todo</th>
                    <th>Hari</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todoLists as $key => $todoList)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $todoList->todo->title }}</td>
                        <td>{{ $todoList->day }}</td>
                        <td>
                            @if ($todoList->status == 0)
                                Belum Selesai
                            @else
                                Selesai
                            @endif
                        </td>
                        <td>{{ $todoList->todo_date }}</td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $todoList->id }}">
                                Edit
                            </button>
                            <form action="{{ route('todo_lists.destroy', $todoList->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $todoList->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $todoList->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $todoList->id }}">Edit Todo List</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('todo_lists.update', $todoList->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="todo_id" class="form-label">Todo</label>
                                            <select class="form-control" id="todo_id" name="todo_id">
                                                @foreach ($todos as $todo)
                                                    <option value="{{ $todo->id }}"
                                                        {{ $todoList->todo_id == $todo->id ? 'selected' : '' }}>
                                                        {{ $todo->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="day" class="form-label">Hari</label>
                                            <select class="form-control" id="day" name="day">
                                                <option value="Senin" {{ $todoList->day == 'Senin' ? 'selected' : '' }}>
                                                    Senin
                                                </option>
                                                <option value="Selasa" {{ $todoList->day == 'Selasa' ? 'selected' : '' }}>
                                                    Selasa
                                                </option>
                                                <option value="Rabu" {{ $todoList->day == 'Rabu' ? 'selected' : '' }}>
                                                    Rabu
                                                </option>
                                                <option value="Kamis" {{ $todoList->day == 'Kamis' ? 'selected' : '' }}>
                                                    Kamis
                                                </option>
                                                <option value="Jumat" {{ $todoList->day == 'Jumat' ? 'selected' : '' }}>
                                                    Jumat
                                                </option>
                                                <option value="Sabtu" {{ $todoList->day == 'Sabtu' ? 'selected' : '' }}>
                                                    Sabtu
                                                </option>
                                                <option value="Minggu" {{ $todoList->day == 'Minggu' ? 'selected' : '' }}>
                                                    Minggu
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="0" {{ $todoList->status === 0 ? 'selected' : '' }}>
                                                    Belum Selesai</option>
                                                <option value="1" {{ $todoList->status === 1 ? 'selected' : '' }}>
                                                    Selesai</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="todo_date" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="todo_date" name="todo_date"
                                                value="{{ $todoList->todo_date }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
