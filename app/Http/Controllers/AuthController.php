<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\MenusAccess;
use App\Helpers\Master;


class AuthController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan halaman indeks pengguna
        return view('auth.login');
    }

    public function signup()
    {
        $javascriptFiles = [
                asset('action-js/auth/signup.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];
            $baseURL = url('/');
            $varJs = [
                'const baseURL = "' . $baseURL . '"',

            ];
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs,
                 // Menambahkan base URL ke dalam array
            ];
            
            return view('auth.signup')
                ->with($data);
    }
    // Fungsi untuk melakukan proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // $credentials = [
        //     $field => $login,
        //     'password' => $password
        // ];

        if (Auth::attempt($credentials)) {
            Session::put('user_id', Auth::user()->id);
            Session::put('name', Auth::user()->name);
            Session::put('role_id', Auth::user()->role_id);
            Session::put('role_name',  strtolower(Auth::user()->roles->first()->role_name));
            if ( Auth::user()->roles->first()->role_name == "guest" ) {
                return redirect(route('guest'));
            } else {
                return redirect()->intended('/dashboard');
            }

        } else {
            // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        Session::forget('user_id');
        Session::forget('name');
        Session::forget('role_id');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function createaccount(){
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'handphone' => ['required', 'min:5', 'max:20'],
            'email' => 'required|max:50|unique:users',
            'password' => ['required', 'min:5', 'max:20'],
        ]);
        DB::beginTransaction();  
        $MasterClass    = new Master();
        $request        = request();
        $attributes     = [
            'name'      => $request->name,
            'email'     => $request->email,
            'handphone' => $request->handphone,
            'password'  => $request->password,
            'created_at'=> date('Y-m-d H:i:s'),
            'is_active' => '1',
            'role_id'   => 10
        ];
        $attributes['password'] = bcrypt($attributes['password'] );
        $user = $MasterClass->saveGlobal('users', $attributes );
        $credentials = [
            "email"     =>  $request->email,
            "password"  =>  $request->password,
        ];

        Auth::attempt($credentials); 
        if(Auth::check() == true){
            DB::commit();
            Session::put('user_id', Auth::user()->id);
            Session::put('name', Auth::user()->name);
            Session::put('role_id', Auth::user()->role_id);
            $code = $MasterClass::CODE_SUCCESS ;
            $info = $MasterClass::INFO_SUCCESS ;
        }else{
            DB::rollback();
            $code = $MasterClass::CODE_FAILED ;
            $info = $MasterClass::INFO_FAILED ;
        }
        $results = [
            'code'  => $code,
            'info'  => $info,
        ];

        return $MasterClass->Results($results);
    }
}
