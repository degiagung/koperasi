<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\PengadaanDetail;
use App\Models\Supplier;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Helpers\Master;
use App\Models\User;
use App\Models\MenusAccess;
use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JsonDataController extends Controller
{
    //
    public function getLokasi(Request $request){
        $javascriptFile = asset('action-js/dashboard/dashboard-action.js');
        return view('pages.admin.dashboard')->with('javascriptFile', $javascriptFile);
    }
    // for list menu side bar
    public function getAccessMenu(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $data = json_decode($request->getContent());
                    $status = [];
                    $role_id = $MasterClass->getSession('role_id');
                    $saved = DB::select("SELECT * FROM menus_access ma LEFT JOIN users_access ua ON ma.id = ua.menu_access_id WHERE ua.role_id =".$role_id. " AND ua.i_view=1");

                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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
    //USER ROLE
    public function getRoleMenuAccess(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());
                    
                    DB::beginTransaction();
            
                    $status = [];
                    $sql    ="SELECT * FROM users_roles ur LEFT JOIN users_access ua ON ur.id = ua.role_id WHERE ua.menu_access_id=".$data->id;
                    // dd($sql);
                    $saved = DB::select($sql);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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
    public function getRole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $data = json_decode($request->getContent());

                    
                    DB::beginTransaction();
            
                    $status = [];
  
                    $saved = DB::select('SELECT * FROM users_roles ur');
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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
    public function getAccessRole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();

                    $dataArray = $request->get('param_type');

                    $status = [];
                    $sql ='SELECT ma.*  FROM menus_access ma WHERE ma.param_type ="'.$dataArray.'"';
                    
                    $saved = DB::select($sql);
                    // $saved = MenusAccess::leftJoin()where('param_type', 'VIEW')->get();
                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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
    public function saveUserAccessRole(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $dataArray = json_decode($request->getContent());

                    DB::beginTransaction();
                    $status = [];
                    // Simpan informasi metode ke dalam database AccessUser
                    foreach ($dataArray as $data) {

                        $saved = UserAccess::updateOrCreate(
                            [
                                'menu_access_id' => $data->mid,
                                'role_id' => $data->rid, // Gantilah $roleId dengan nilai yang sesuai
                            ], // Kolom dan nilai kriteria
                            [
                                'i_view' => $data->is_active,
                            ] // Kolom yang akan diisi
                        );
                        $saved = $MasterClass->checkErrorModel($saved);
                        
                        $status = $saved;
                        
                        if($status['code'] != $MasterClass::CODE_SUCCESS){
                            break;
                        }
                       
                    }   

                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        
                    }               
                    
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
    public function updateMenuAccessName(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $mid = $request->get('mid');
                    $headmenu = $request->get('nhead');
                    $menuname = $request->get('nmenu');

                    DB::beginTransaction();
                    // dd($mid);
                    
                    $status = [];
                    // Simpan informasi metode ke dalam database AccessUser
                    
                    $saved = MenusAccess::where([
                        'id' => $mid,
                    ])->update([
                        'header_menu' => $headmenu,
                        'menu_name' => $menuname,
                    ]);


                    $saved = $MasterClass->checkerrorModelUpdate($saved);
                    
                    $status = $saved;
                

                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        
                    }               
                    
                    $results = [
                        'code' => $status['code'],
                        'info'  => $status['info'],
                        'data'  =>  $status['data'],
                    ];

                    // dd($results);
        
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
    
    //USER LIST
    public function getUserList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    

                    $status = [];

                    $query = "
                        SELECT
                            us.id,
                            us.name,
                            us.email,
                            us.is_active,
                            us.role_id,
                            ur.role_name 
                        FROM
                            users us
                            LEFT JOIN users_roles ur ON us.role_id = ur.id
                        
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];
                    if ($data->password){
                        
                        $saved = User::updateOrCreate(
                            [
                                'id' => $data->id,
                            ], 
                            [
                                'name' => $data->name,
                                'email'=> $data->email,
                                'role_id' => $data->role_id,
                                'password' => Hash::make($data->password),
                                'is_active' => $data->is_active,
                            ] // Kolom yang akan diisi
                        );

                    }else{
                      
                        $saved = User::updateOrCreate(
                            [
                                'id' => $data->id,
                            ], 
                            [
                                'name' => $data->name,
                                'email'=> $data->email,
                                'role_id' => $data->role_id,
                                'is_active' => $data->is_active,
                            ] // Kolom yang akan diisi
                        );
                        
                    }
                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

    public function deleteUser(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
                    
                    $status = [];

                    $saved = User::where('id', $data->id)->delete();
                    
                    $saved = $MasterClass->checkerrorModelUpdate($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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
    public function getObatList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    

                    $status = [];

                    $query = "
                        SELECT
                            us.*,
                            ur.nama_satuan 
                        FROM
                            obat us
                            LEFT JOIN satuan ur ON us.id_satuan = ur.id
                        
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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

    public function saveObat(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];
                  
                        
                    $saved = Obat::updateOrCreate(
                        [
                            'id' => $data->id,
                        ], 
                        [
                            'nama_obat' => $data->nama_obat,
                            'id_satuan'=> $data->id_satuan,
                            'harga_beli' => $data->harga_beli,
                            'harga_jual' => $data->harga_jual,
                            'min_stok' => $data->min_stok,
                        ] // Kolom yang akan diisi
                    );

                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

    public function getSatuanList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    

                    $status = [];

                    $query = "
                        SELECT
                            us.*
                        FROM
                            satuan us
                        
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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

    public function deleteGlobal(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
                    
                    $status = [];

                    $saved =   DB::table($data->tableName)->where('id', $data->id)->delete();
                    
                    $saved = $MasterClass->checkerrorModelUpdate($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

    public function saveSatuan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];
                  
                        
                    $saved = Satuan::updateOrCreate(
                        [
                            'id' => $data->id,
                        ], 
                        [
                            'nama_satuan' => $data->nama_satuan,
                        ] // Kolom yang akan diisi
                    );

                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

    public function getSupplierList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    

                    $status = [];

                    $query = "
                        SELECT
                            us.*
                        FROM
                            supplier us
                        
                    ";
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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

    public function saveSupplier(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];
                  
                        
                    $saved = Supplier::updateOrCreate(
                        [
                            'id' => $data->id,
                        ], 
                        [
                            'nama_supplier' => $data->nama_supplier,
                        ] // Kolom yang akan diisi
                    );

                    
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

    public function savePengadaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];

                    $nowdate = now();
                    $nopengadaan = Pengadaan::generateNoPengadaan($nowdate);
                
                    $pengadaan = Pengadaan::create([
                        'tanggal' => $nowdate,
                        'no_pengadaan' => $nopengadaan,
                        'request_user_id' => $data->request_user_id,
                        'id_supplier' => $data->id_supplier,
                        'total_harga' => $data->total_harga,
                        'status'=> 20
                    ]);
                    
                
                    $saved = $MasterClass->checkErrorModel($pengadaan);
          
                    foreach ($data->obat_obatan as $obat) {
                        $detaipengadaan = PengadaanDetail::create([
                            'id_pengadaan' => $pengadaan->id,
                            'id_obat' => $obat->id,
                            'qty_request' => $obat->jumlah,
                            'harga_item' => $obat->harga,
                        ]);

                        $saved = $MasterClass->checkErrorModel($detaipengadaan);
                    }
                

                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

    public function getPengadaanList(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $data = json_decode($request->getContent());
             
                    $status = [];

                    $query = "
                        SELECT
                            p.* ,
                            s.nama_supplier,
                            ru.name as nama_req,
                            au.name as nama_acc,
                            apu.name as nama_approve	
                        FROM
                            pengadaan p
                            JOIN supplier s ON s.id = p.id_supplier
                            JOIN users ru ON ru.id = p.request_user_id
                            LEFT JOIN users au ON au.id = p.accept_user_id
                            LEFT JOIN users apu ON apu.id = p.approve_user_id
                        
                    ";
                    if($request->status){
                        $query = $query."  WHERE p.status=".$request->status;
                    }
        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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

    public function getInvoicePengadaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        // if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     
                    
                    $data = json_decode($request->getContent());
                    $status = [];

                    $query = "
                        SELECT
                            p.* ,
                            s.nama_supplier,
                            ru.name as nama_req,
                            au.name as nama_acc,
                            apu.name as nama_approve,
                            mo.nama_obat,
                            sa.nama_satuan,
                            pd.qty_request,
                            pd.qty_terima,
                            pd.harga_item
                        FROM
                            pengadaan p
                            JOIN supplier s ON s.id = p.id_supplier
                            JOIN users ru ON ru.id = p.request_user_id
                            LEFT JOIN users au ON au.id = p.accept_user_id
                            LEFT JOIN users apu ON apu.id = p.approve_user_id
                            LEFT JOIN pengadaan_detail pd ON pd.id_pengadaan = p.id
                            JOIN obat mo ON pd.id_obat = mo.id
                            JOIN satuan sa ON sa.id = mo.id_satuan
                        WHERE p.no_pengadaan ='".$data->no_pengadaan."'";

        
                    $saved = DB::select($query);
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
 
                    // if($status['code'] == $MasterClass::CODE_SUCCESS){
                    //     DB::commit();
                    // }else{
                    //     DB::rollBack();
                    // }
        
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
        // }
        // else {
    
        //     $results = [
        //         'code' => '403',
        //         'info'  => "Unauthorized",
        //     ];
            
        // }

        return $MasterClass->Results($results);

    }

    public function saveStatusRequestPengadaan(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    DB::beginTransaction();     

                    $data = json_decode($request->getContent());
             
                    $status = [];
                    
                    $pengadaan = Pengadaan::where('no_pengadaan', $data->no_pengadaan)->first();
                    
                    $pengadaan->update([
                        'status'=> $data->status,
                        'approve_user_id'=>$MasterClass->getSession('user_id'),
                    ]);
                
                    $saved = $MasterClass->checkErrorModel($pengadaan);
                
                    $status = $saved;
 
                    if($status['code'] == $MasterClass::CODE_SUCCESS){
                        DB::commit();
                    }else{
                        DB::rollBack();
                    }
        
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

}
