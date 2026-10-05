<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('is_panitia')) {
            return redirect()->route('attendance.dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        // Kata sandi panitia (default: admin123)
        $correctPassword = env('PANITIA_PASSWORD', 'admin123');

        if ($request->password === $correctPassword) {
            session(['is_panitia' => true]);
            return redirect()->route('attendance.dashboard');
        }

        return back()->with('error', 'Kata sandi panitia salah!');
    }

    public function logout()
    {
        session()->forget('is_panitia');
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }
}