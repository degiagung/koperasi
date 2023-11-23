<?php

namespace App\Http\Controllers;
use App\Helpers\Master;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoicePengadaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            $nopengadaan = $request->query('no-pengadaan');

            $javascriptFiles = [
                asset('action-js/global/global-action.js'),
                // asset('action-js/generate/generate-action.js'),
                asset('action-js/invoice/invoicepengadaan-action.js'),
            ];
        
            $cssFiles = [
                // asset('css/main.css'),
                // asset('css/custom.css'),
            ];
            $baseURL = url('/');
            $varJs = [
                'const baseURL = "' . $baseURL . '"',
                'const no_pengadaan = "' . $nopengadaan . '"',
                'const role_id='. $MasterClass->getSession('role_id')
            ];
    
            $data = [
                'javascriptFiles' => $javascriptFiles,
                'cssFiles' => $cssFiles,
                'varJs'=> $varJs
                 // Menambahkan base URL ke dalam array
            ];
        
            return view('pages.admin.invoice.invoicepengadaan')
                ->with($data);
        }else{
            return redirect('/login');
        }
        
    }
}
