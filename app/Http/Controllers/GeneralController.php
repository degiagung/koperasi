<?php

namespace App\Http\Controllers;

use App\Helpers\Master;
use App\Models\Pengadaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class GeneralController extends Controller
{
    //

    public function based(Request $request){
        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){

            return redirect('/dashboard');

        }else{
            return redirect('/login');
        }
    }
    public function dashboard(Request $request){
        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());

        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
           
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/dashboard-action.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];
            $baseURL = url('/');
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const role = "' . $rolename . '"',

            ];
            
            
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs,
                'role'=> $rolename,
                // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.dashboard')
                ->with($data);
        }else{
            return redirect('/login');
        }
    }
    public function userlist(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/user/userlist-action.js'),
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
        
            return view('pages.admin.users.userlist')
                ->with($data);
        }else{
            return redirect('/login');
        }

        
    }
    public function userrole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
        

            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                asset('action-js/user/userrole-action.js'),
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
            return view('pages.admin.users.userrole')
            ->with($data);
            
        }else{
            return redirect('/login');
        }
    
        
    }
    public function userpenghuni(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/user/userpenghuni-action.js'),
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
        
            return view('pages.admin.users.userpenghuni')
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
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/property/listkamar-action.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];
            $baseURL = url('/');
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const role = "' . $rolename .'"',

            ];
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.property.listkamar')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function listfasilitas(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/property/listfasilitas-action.js'),
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
        
            return view('pages.admin.property.listfasilitas')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function mappingfasilitas(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/management/mappingfasilitas-action.js'),
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
        
            return view('pages.admin.management.mappingfasilitas')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function listTipeKamar(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/property/listtipekamar-action.js'),
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
        
            return view('pages.admin.property.listtipekamar')
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
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/property/listtransaksi-action.js'),
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
        
            return view('pages.admin.property.listtransaksi')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function booking(Request $request){

        $MasterClass = new Master();

        if(Auth::check()){
            $javascriptFiles = [
                asset('action-js/property/booking-action.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];
            $baseURL = url('/');
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const role = "' . $rolename .'"',

            ];
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.landingpage.booking')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function details($id){
        $MasterClass = new Master();

        if(Auth::check()){
            $javascriptFiles = [
                asset('action-js/property/details.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];
            $baseURL = url('/');
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const role = "' . $rolename .'"',
                'const idkamar = "' . $id .'"',

            ];
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.landingpage.property-details')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function kostan(Request $request){

        
        $javascriptFiles = [
            asset('action-js/property/kostan.js'),
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
    
        return view('pages.landingpage.kostan')
            ->with($data);
        
    }
    
}


