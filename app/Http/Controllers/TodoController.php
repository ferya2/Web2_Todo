<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoCategory;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::join('todo_categories', 'todo_categories.id', '=', 'todos.todo_category_id')
            ->join('users', 'users.id', '=', 'todos.user_id')
            ->select(
                'users.name',
                'users.email',
                'todo_categories.category',
                'todos.id as todo_id',
                'todos.todo_category_id',
                'todos.user_id',
                'todos.title',
                'todos.description'
            )
            ->where('todos.user_id', Auth::id()) // filter by user id
            ->get();

        return view('todo.todo', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $todocategories = TodoCategory::where('user_id', Auth::id())->get();
        return view('todo.create', compact('todocategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'todo_category_id' => 'required|exists:todo_categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $value = [
        'todo_category_id' => $request->todo_category_id,
        'user_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
    ];

    Todo::create($value);

    return redirect()->route('todo.index'); // Redirect to the correct route
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $todo = Todo::find($id);
    $todocategories = TodoCategory::where('user_id', Auth::id())->get();
    return view('todo.edit', compact('todo', 'todocategories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'todo_category_id' => 'required|exists:todo_categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $value = [
        'todo_category_id' => $request->todo_category_id,
        'user_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
    ];

    Todo::where('id', $id)->update($value);
    return redirect()->route('todo.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $todo = Todo::findOrFail($id);
    $todo->delete();
    return redirect()->route('todo.index');
    }


}
