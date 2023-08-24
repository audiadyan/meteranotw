<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function create()
    {
        return view('pages.auth.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        if(count(User::where('username', $validatedData['username'])->get()) > 0) {
            return back()->with('error', 'Username Sudah Digunakan!'); 
        }

        User::create($validatedData);
        return redirect(route('loginpage'))->with('success', 'Registrasi Sukses!');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('error', 'Username/Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }
}
