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

            return redirect('/laporan');

        }else{
            return redirect('/login');
        }
    }
    public function dashboard(Request $request){
        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            if ($rolename == 'anggota') {
                $javascriptFiles = [
                    asset('action-js/global/global-action.js'),
                    // asset('action-js/generate/generate-action.js'),
                    asset('action-js/dashboard-action.js'),
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
                    'role'=> $rolename
                    // Menambahkan base URL ke dalam array
                ];
            
                return view('pages.admin.users.dashboard')
                ->with($data);
            }else{
                return redirect('/laporan');
            }

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
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const role = "' . $rolename .'"',

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
            $rolename = strtolower($MasterClass->getSession('role_name'))  ;
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const role = "' . $rolename .'"',

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
    public function listanggota(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/user/listanggota-action.js'),
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
                'role'=> $rolename
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.users.listanggota')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function listsimpanan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/listsimpanan.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.listsimpanan')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function listpinjaman(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/listpinjaman.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.listpinjaman')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function laporan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/laporansimpanpinjam.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.laporansimpanpinjam')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function pengajuanpinjaman(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/pengajuanpinjaman.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.pengajuanpinjaman')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function pengajuansukarela(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/pengajuansukarela.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.pengajuansukarela')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function pengajuantariksimpan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/pengajuantariksimpan.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.pengajuantariksimpan')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    public function laporanpenggajian(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->AuthenticatedView($request->route()->uri());
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/transaksi/laporanpenggajian.js'),
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
                'role'=> $rolename,
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.transaksi.laporanpenggajian')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
    
}


