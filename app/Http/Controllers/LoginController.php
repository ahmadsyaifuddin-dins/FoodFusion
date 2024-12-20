<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function __construct()
    {
        // Middleware auth untuk mencegah halaman login dan register diakses setelah login
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        // Jika sudah login, alihkan ke halaman utama atau dashboard
        if (Auth::check()) {
            return redirect()->route('market')->with('message', 'Anda sudah login!');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah email ada di database
        $user = DB::table('users')
            ->select('user_id', 'email', 'password')
            ->where('email', $request->email)
            ->first();

        if ($user && $user->password === $request->password) {
            // Login dengan Remember Me
            auth()->loginUsingId($user->user_id, $request->boolean('remember'));

            return redirect()->intended('/')
                ->with('success', 'Login berhasil! Selamat datang di Market.');
        }


        // Jika gagal, kembali ke halaman login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
