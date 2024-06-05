<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index_of_signin()
    {
        return view('auth.signin');
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'pass' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('pass'),
        ];


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->flash('success_flash', 'You have successfully logged in!');
            return redirect('/');
        }

        return back()->withErrors([
            'auth' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/signin');
    }
}
