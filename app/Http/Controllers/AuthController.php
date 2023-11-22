<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;


class AuthController extends Controller
{
    public function index()
    {   
        // Logika untuk menampilkan halaman indeks pengguna
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    // Fungsi untuk melakukan proses login
    public function authenticate(Request $request): RedirectResponse
    {
        
        $credentials = $request->validate([
            'email'     => 'required|email:dns',
            'password'  => 'required',
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::put('iduser', Auth::user()->iduser);
            Session::put('name', Auth::user()->name);
            Session::put('role', Auth::user()->role);
 
            return redirect()->intended('dashboard');
            if ( Auth::user()->role == "penghuni" ) {
                return redirect()->intended('kostan');
            } else {
                return redirect()->intended('dashboard');
            }
            
        } else {
            return redirect()->back()->with('gagal','Username dan Password tidak diketahui');
        }
    }
    public function logout(Request $request)
    {   
        Auth::logout();

        Session::forget('iduser');
        Session::forget('name');
        Session::forget('role');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}