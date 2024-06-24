<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoCategory;

class TodoCategoryController extends Controller
{
    public function index()
    {
        $categories = TodoCategory::where('user_id', Auth::id())->get();
        return view('todo.categories.todocategory', compact('categories'));
    }

    public function create()
    {
        return view('todo.categories.createcategory');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        TodoCategory::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
        ]);

        return redirect()->route('todo_categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = TodoCategory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('todo.categories.editcategory', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $category = TodoCategory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->update(['category' => $request->category]);

        return redirect()->route('todo_categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = TodoCategory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->delete();

        return redirect()->route('todo_categories.index')->with('success', 'Category deleted successfully');
    }
}
