@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (Auth::check())
                            <h1 class="mb-4">Welcome, {{ Auth::user()->name }}</h1>

                            @if (Auth::user()->group == 'user')
                                <a href="todo" class="btn btn-primary mb-3 ml-3">Todo</a>
                            @endif

                            <a href="/user/logout"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-outline-danger mb-3 ml-3">Logout</a>

                            <form id="logout-form" action="/user/logout" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <h1 class="mb-4">Welcome, Guest</h1>
                            <a href="/user/login" class="btn btn-primary mb-3 mr-3">Login</a>
                            <a href="/user/register" class="btn btn-outline-primary">Register</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
