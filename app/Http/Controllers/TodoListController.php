<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoList;
use App\Models\Todo;

class TodoListController extends Controller
{
    // NOTE ( TAMBAH DATA MANUAL DI TABEL TODO LIST )
    public function index()
    {
        $todoLists = TodoList::with('todo')->where('user_id', Auth::id())->get();
        $todos = Todo::where('user_id', Auth::id())->get();

        return view('todo.todolists', compact('todoLists', 'todos'));
    }

    public function edit($id)
    {
        $todoList = TodoList::find($id);
        $todos = Todo::where('user_id', Auth::id())->get();

        return view('todo_lists.edit', compact('todoList', 'todos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'todo_id' => 'required|exists:todos,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'status' => 'required|in:0,1',
            'todo_date' => 'required|date',
        ]);

        $todoList = TodoList::find($id);
        $todoList->todo_id = $request->todo_id;
        $todoList->day = $request->day;
        $todoList->status = $request->status;
        $todoList->todo_date = $request->todo_date;
        $todoList->save();

        return redirect()->route('todo_lists.index')->with('success', 'Todo List berhasil diupdate');
    }


    public function destroy($id)
    {
        $todoList = TodoList::find($id);
        $todoList->delete();

        return redirect()->route('todo_lists.index')->with('success', 'Todo List berhasil dihapus');
    }
}
