<?php

namespace App\Http\Controllers;

use App\Helpers\Master;
use App\Models\User;
use App\Models\data_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JsondataController extends Controller
{   
    public function getRole(Request $request){

        $MasterClass = new Master();
        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());

                    
                    DB::beginTransaction();
            
                    $status = [];
  
                    $saved = DB::select('SELECT * FROM data_role dr');
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }

    public function getlistuser(Request $request){
        $MasterClass = new Master();
        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        // dd();
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    

                    $status = [];

                    $query = "
                        SELECT
                            us.*,dp.handphone,dp.alamat,dp.no_ktp
                        FROM
                            users us
                            LEFT JOIN data_profile dp ON dp.iduser = us.iduser
                        WHERE 
                            us.status not in ('30')
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);
    }

    public function getlistpenghuni(Request $request){
        $MasterClass = new Master();
        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];

                    $query = "
                        SELECT
                            us.*,dp.handphone,dp.alamat,dp.no_ktp
                        FROM
                            users us
                            LEFT JOIN data_profile dp ON dp.iduser = us.iduser
                        WHERE 
                            us.status not in ('30') 
                            and us.role in ('penghuni')
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);
    }

    public function getlistkamar(Request $request){
        $MasterClass = new Master();
        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];

                    $query = "
                        SELECT
                            us.*,dp.handphone,dp.alamat,dp.no_ktp
                        FROM
                            users us
                            LEFT JOIN data_profile dp ON dp.iduser = us.iduser
                        WHERE 
                            us.status not in ('30') 
                            and us.role in ('penghuni')
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);
    }

    public function getlisttransaksi(Request $request){
        $MasterClass = new Master();
        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];

                    $query = "
                        SELECT
                            us.*,dp.handphone,dp.alamat,dp.no_ktp
                        FROM
                            users us
                            LEFT JOIN data_profile dp ON dp.iduser = us.iduser
                        WHERE 
                            us.status not in ('30') 
                            and us.role in ('penghuni')
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);
    }

    public function getlistmenu(Request $request){
        $MasterClass = new Master();
        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $status = [];

                    $query = "
                        SELECT
                            *
                        FROM
                            data_access
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
        
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];
                        
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);
    }

    public function saveUser(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();
                    // $getlist        = $MasterClass->getIncrement('data_profile');     
                    // $iduser         = $getlist['data'];     
                    $status_code    = '1';
                    $status_info    = 'FAILED';
                    $data           = json_decode($request->getContent());
                    $iduser         = null ;
                    if($data->password){
                        $atribut    = array(
                            'name'      => $data->name,
                            'email'     => $data->email,
                            'password'  => $data->password,
                            'role'      => $data->role,
                            'status'    => '10',
                        );
                        $saveusers  = $MasterClass->saveGlobal('users',$atribut);
                        $iduser     = $saveusers['data'];
                        $where      = array(
                            "iduser" => $iduser
                        );

                    }else{
                        $atribut    = array(
                            'name'      => $data->name,
                            'email'     => $data->email,
                            'role'      => $data->role,
                            'status'    => '10',
                        );
                        $where      = array(
                            "iduser" => $data->iduser
                        );
                        $saveusers  = $MasterClass->updateGlobal('users',$atribut,$where);
                    }

                    if($saveusers['code'] == $MasterClass::CODE_SUCCESS){
                        // simpan / update profile

                        if($iduser != null){
                            $attrpr   = [
                                'iduser'    => $iduser,
                                'handphone' => $data->handphone,
                                'alamat'    => $data->alamat,
                                'no_ktp'    => $data->noktp,
                            ];
                            $saveprofile    = $MasterClass->saveGlobal('data_profile',$attrpr);
                        }else{
                            $attrpr   = [
                                'handphone' => $data->handphone,
                                'alamat'    => $data->alamat,
                                'no_ktp'    => $data->noktp,
                            ];
                            $saveprofile    = $MasterClass->updateGlobal('data_profile',$attrpr,$where);
                            // dd($saveprofile);

                        }
                        if($saveprofile['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                            $status_code = $MasterClass::CODE_SUCCESS;
                            $status_info = $MasterClass::INFO_SUCCESS;
                        }else{
                            DB::rollBack();
                            $status_code = $MasterClass::CODE_FAILED;
                            $status_info = $MasterClass::INFO_FAILED;
                        }
                    }else{
                        DB::rollBack();
                        $status_code = $MasterClass::CODE_FAILED;
                        $status_info = $MasterClass::INFO_FAILED;
                    }
        
                    $results = [
                        'code'  =>  $status_code,
                        'info'  =>  $status_info,
                    ];
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }

    public function saveMenu(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();
                    $getlist        = $MasterClass->getIncrement('data_access'); 
                    $idlast         = $getlist['data'] ;    
                    $codemenu       = 'CODE-'.$idlast;    

                    $data           = json_decode($request->getContent());
                    
                    $atribut        = array(
                        'id'               => $idlast,
                        'access_code'      => $codemenu,
                        'access_name'      => $data->menu,
                        'class'            => $data->class,
                        'icon'             => $data->icon,
                        'status'           => '0',
                    );
                    $savemenu      = $MasterClass->saveGlobal('data_access',$atribut);

                    if($savemenu['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                        $status_code = $MasterClass::CODE_SUCCESS;
                        $status_info = $MasterClass::INFO_SUCCESS;
                    }else{
                        DB::rollBack();
                        $status_code = $MasterClass::CODE_FAILED;
                        $status_info = $MasterClass::INFO_FAILED;
                    }
        
                    $results = [
                        'code'  =>  $status_code,
                        'info'  =>  $status_info,
                    ];
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }

    public function changestatususer(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();   
                    $idlogin        = $MasterClass->getSession('iduser');
                    $status_code    = '1';
                    $status_info    = 'FAILED';
                    
                    $iduser         = $request->iduser ;
                    $status         = $request->status ;
                    $atribut    = array(
                        'iduser'    => $iduser,
                        'created_by'=> $idlogin,
                        'status'    => $status,
                    );
                    $save  = $MasterClass->saveGlobal('history_status_user',$atribut);
                   
                    
                    if($save['code'] == $MasterClass::CODE_SUCCESS){
                        
                        $attrus   = [
                            'status'    => $status
                        ];
                        $where      = array(
                            "iduser" => $iduser
                        );
                        $saveprofile    = $MasterClass->updateGlobal('users',$attrus,$where);
                        if($saveprofile['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                            $status_code = $MasterClass::CODE_SUCCESS;
                            $status_info = $MasterClass::INFO_SUCCESS;
                        }else{
                            DB::rollBack();
                            $status_code = $MasterClass::CODE_FAILED;
                            $status_info = $MasterClass::INFO_FAILED;
                        }
                    }else{
                        DB::rollBack();
                        $status_code = $MasterClass::CODE_FAILED;
                        $status_info = $MasterClass::INFO_FAILED;
                    }
        
                    $results = [
                        'code'  =>  $status_code,
                        'info'  =>  $status_info,
                    ];
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }

    public function deleteMenu(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('iduser'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();   
                    $idlogin        = $MasterClass->getSession('iduser');
                    
                    $id             = $request->id ;
                    $where    = array(
                        'id'    => $id
                    );
                    $delete  = $MasterClass->deleteGlobal('data_access',$where);
                   
                    
                    if($delete['code'] == $MasterClass::CODE_SUCCESS){
                        
                        DB::commit();
                        $status_code = $MasterClass::CODE_SUCCESS;
                        $status_info = $MasterClass::INFO_SUCCESS;
                        
                    }else{
                        DB::rollBack();
                        $status_code = $MasterClass::CODE_FAILED;
                        $status_info = $MasterClass::INFO_FAILED;
                    }
        
                    $results = [
                        'code'  =>  $status_code,
                        'info'  =>  $status_info,
                    ];
        
        
                } else {
                    $results = [
                        'code' => '103',
                        'info'  => "Method Failed",
                    ];
                }
            } catch (\Exception $e) {
                // Roll back the transaction in case of an exception
                $results = [
                    'code' => '102',
                    'info'  => $e->getMessage(),
                ];
    
            }
        }
        else {
    
            $results = [
                'code' => '403',
                'info'  => "Unauthorized",
            ];
            
        }

        return $MasterClass->Results($results);

    }
}
