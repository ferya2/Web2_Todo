<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoCategoryController;
use App\Http\Controllers\TodoListController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::prefix('user')->group(function () {
    Route::get('/register', [UserController::class, 'register']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login/auth', [UserController::class, 'loginAuth']);
    Route::post('/register/store', [UserController::class, 'storeRegister']);
    Route::post('/logout', [UserController::class, 'logout']);
});

// Rute resource untuk UserController
Route::resource('users', UserController::class)->except(['create', 'store']);

// Rute resource untuk TodoCategoryController
Route::resource('todo_categories', TodoCategoryController::class)->middleware('auth');

// Route dashboard
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::get('/todo/edit/{id}', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todo/update/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/delete/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
});
// rute todo list
Route::prefix('todo_lists')->group(function () {
    Route::get('/', [TodoListController::class, 'index'])->name('todo_lists.index');
    Route::get('/edit/{id}', [TodoListController::class, 'edit'])->name('todo_lists.edit');
    Route::put('/update/{id}', [TodoListController::class, 'update'])->name('todo_lists.update');
    Route::delete('/delete/{id}', [TodoListController::class, 'destroy'])->name('todo_lists.destroy');
});

