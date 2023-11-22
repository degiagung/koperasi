<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\data_profile;
use Illuminate\Support\Facades\DB;
class RegisterController extends Controller
{
    public function index(){
        return view('auth.signup');
    }

    public function store(Request $request){

        DB::beginTransaction();

        $request->validate([
            'name'              => 'required|min:3|max:255',
            'handphone'         => 'required|min:8|max:255|unique:data_profile',
            'email'             => 'required|min:5|max:255|unique:users|email:dns',
            'password'          => 'required|min:5|max:255',
            'confirm_password'  => 'required|min:5|max:255'
        ]);

        if($request->password != $request->confirm_password){
            return redirect()->back()->with('warning','Password dan password confirm harus sama');

        }


        $attr   = array(
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'role'      => 'guest',
            'status'    => '10',
        );
        

        $save = User::create($attr);
        if($save->id){

            $attrpr   = [
                'iduser'    => $save->id,
                'handphone' => $request->handphone
            ];
            $saveprofile = data_profile::create($attrpr);
            if($saveprofile->id){
                DB::commit();
                return redirect('login')->with('success','silahkan dicoba untuk login terlebih dahulu ');
            }else{
                DB::rollBack();
                return back()->with([
                    'gagal' => 'Gagal melakukan registrasi'
                ]);
            }
        }


    }
    
}
