<?php

namespace App\Http\Controllers;

use App\Helpers\Master;
use App\Models\Pengadaan;
use Illuminate\Http\Request;

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

    public function pengadaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/pengadaan/pengadaanlist-action.js'),
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
        
            return view('pages.admin.pengadaan.pengadaanlist')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }

    public function penerimaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/penerimaan/penerimaanlist-action.js'),
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
        
            return view('pages.admin.penerimaan.penerimaanlist')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }

    public function checkingpenerimaan(Request $request){

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

    public function laporaninventori(Request $request){

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

    public function penjualanobat(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/penjualan/penjualanobat-action.js'),
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
        
            return view('pages.admin.penjualan.penjualanobat')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }

    public function satuanlist(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/satuan/satuanlist-action.js'),
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
        
            return view('pages.admin.satuan.satuanlist')
                ->with($data);
        }else{
            return redirect('/login');
        }

        
    }

    public function obatlist(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/obat/obatlist-action.js'),
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
        
            return view('pages.admin.obat.obatlist')
                ->with($data);
        }else{
            return redirect('/login');
        }

        
    }
    public function supplierlist(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/supplier/supplierlist-action.js'),
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
        
            return view('pages.admin.supplier.supplierlist')
                ->with($data);
        }else{
            return redirect('/login');
        }

        
    }
    
    public function tambahpengadaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/pengadaan/tambahpengadaan-action.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];

            $nowdate = now()->format('Y-m-d H:i:s');
            $nopengadaan = Pengadaan::generateNoPengadaan($nowdate);

            $tglpengadaan = now()->format('m/d/Y');

            $baseURL = url('/');
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const no_pengadaan = "' . $nopengadaan . '"',
                'const tgl_pengadaan = "' . $tglpengadaan . '"',
            ];
    
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.pengadaan.tambahpengadaan')
                ->with($data);
        }else{
            return redirect('/login');
        }

        
    }

    public function test(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/pengadaan/pengadaanlist-action.js'),
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
        
            return view('pages.admin.pengadaan.pengadaanlist')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
}


