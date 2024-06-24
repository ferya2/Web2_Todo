<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return redirect('dashboard');
        }

        return redirect('/user/login')->with('error', 'Login Gagal, Periksa Kembali Email dan Password Anda');
    }

    public function register()
    {
        return view('user.register');
    }

    public function storeRegister(Request $request)
    {
        $value = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'group' => 'user',
        ];

        User::create($value);
        return redirect('dashboard');
    }

    public function profile()
    {
        // Implementasi profile pengguna
    }

    public function logout()
    {
        Auth::logout();
        return view('user.login');
    }

    public function index()
    {
        $users = User::all();
        return view('user.userview', compact('users'));
    }


    public function edit(User $user)
    {
        return view('user.edituser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'group' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'group' => $request->group
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
