<?php

namespace App\Http\Controllers;

use App\Helpers\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller
{
    public function dashboard(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
           
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
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
                'varJs'=> $varJs
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.dashboard')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
    public function listuser(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
           
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                asset('action-js/management/listuser.js'),
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
                'idlogin'=> $MasterClass->getSession('iduser'),
                'role'=> $MasterClass->getSession('role')
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.management.listuser')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
    public function listpenghuni(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
           
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                asset('action-js/management/listpenghuni.js'),
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
                'idlogin'=> $MasterClass->getSession('iduser'),
                'role'=> $MasterClass->getSession('role')
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.management.listpenghuni')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
    public function listkamar(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
           
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                asset('action-js/management/listkamar.js'),
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
                'idlogin'=> $MasterClass->getSession('iduser'),
                'role'=> $MasterClass->getSession('role')
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.management.listkamar')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
    public function listtransaksi(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
           
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                asset('action-js/management/listtransaksi.js'),
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
                'idlogin'=> $MasterClass->getSession('iduser'),
                'role'=> $MasterClass->getSession('role')
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.management.listtransaksi')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
    public function listmenu(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS ){
            if($MasterClass->getSession('role') != 'developer'){
                return redirect('/dashboard');
            }
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                asset('action-js/management/listmenu.js'),
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
                'idlogin'=> $MasterClass->getSession('iduser'),
                'role'=> $MasterClass->getSession('role')
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.management.listmenu')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
}
