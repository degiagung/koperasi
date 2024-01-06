<?php

namespace App\Http\Controllers;

use App\Models\fasilitas;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use App\Helpers\Master;
use App\Models\User;
use App\Models\limit_pinjaman;
use App\Models\MenusAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JsonDataController extends Controller
{   
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
                        $saved = DB::select("SELECT * FROM menus_access ma LEFT JOIN users_access ua ON ma.id = ua.menu_access_id WHERE ua.role_id =".$role_id. " AND ua.i_view=1 order by ma.menu_name asc");

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
                        $where = "" ;
                        if($MasterClass->getSession('role_name') != 'superadmin' ){
                            $where = " WHERE role_name not like '%admin%'";
                        }
                        $saved = DB::select("SELECT * FROM users_roles ur $where");
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
                        $fstatus     = $request->status ;
                        $frole       = $request->role ;
                        $fkeanggotaan= $request->keanggotaan ;
                        $status = [];
                        
                        $select = "
                            us.*,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                                when us.is_active = '3' then 'DELETE' 
                            end status_name,
                            ur.role_name,
                            CASE 
                                WHEN us.tgl_dinas > current_date THEN 'PENSIUN'
                                WHEN us.tgl_dinas is null THEN 'TGL DINAS KOSONG'
                                ELSE
                                    CASE 
                                        WHEN lower(status) = '2' THEN 'PINDAH'
                                    ELSE 'AKTIF'
                                END
                            END keanggotaan
                        ";
                        
                        $table = '
                            users us
                            LEFT JOIN users_roles ur ON us.role_id = ur.id
                        ';
                        
                        
                        $where = "
                            ur.role_name not like '%admin%'
                        ";

                        if($fstatus){
                            $where .= "
                                AND us.is_active = $fstatus
                            ";
                        }

                        if($frole){
                            $where .= "
                                 AND  us.role_id in (select id from users_roles where role_name  = '$frole')
                            ";
                        }

                        if($fkeanggotaan){
                            if($fkeanggotaan == 'pindah'){
                                $where .= "
                                     AND lower(us.status) = '2'
                                ";
                            }else{
                                $where .= "
                                     AND lower(us.tgl_dinas) $fkeanggotaan
                                ";
                            }
                        }

                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
        public function getAggotaList(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $fstatus     = $request->status ;
                        $fkeanggotaan= $request->keanggotaan ;
                        $status = [];
                        
                        $select = "
                            us.*,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                                when us.is_active = '3' then 'DELETE' 
                            end status_name,
                            ur.role_name,
                            CASE 
                                WHEN us.tgl_dinas > current_date THEN 'PENSIUN'
                                WHEN us.tgl_dinas is null THEN 'TGL DINAS KOSONG'
                                ELSE
                                    CASE 
                                        WHEN lower(status) = '2' THEN 'PINDAH'
                                    ELSE 'AKTIF'
                                END
                            END keanggotaan,
                            lp.id as idlimit,
                            lp.amount as limit_pinjaman
                        ";
                        
                        $table = '
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            LEFT JOIN limit_pinjaman lp ON lp.user_id = us.id
                        ';
                        
                        
                        $where = "
                             us.role_id in (select id from users_roles where role_name  like '%anggota%')
                        ";

                        if($fstatus){
                            $where .= "
                                AND us.is_active = $fstatus
                            ";
                        }

                        if($fkeanggotaan){
                            if($fkeanggotaan == 'pindah'){
                                $where .= "
                                     AND lower(us.status) = '2'
                                ";
                            }else{
                                $where .= "
                                     AND lower(us.tgl_dinas) $fkeanggotaan
                                ";
                            }
                        }

                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
        public function getSimpanan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $fstatus     = $request->status ;
                        $fkeanggotaan= $request->keanggotaan ;
                        $status = [];
                        
                        $select = "
                            us.name,us.id as user,us.nrp,us.tgl_dinas,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                                when us.is_active = '3' then 'DELETE' 
                            end status_name,
                            ur.role_name,
                            CASE 
                                WHEN us.tgl_dinas > current_date THEN 'PENSIUN'
                                WHEN us.tgl_dinas is null THEN 'TGL DINAS KOSONG'
                                ELSE
                                    CASE 
                                        WHEN lower(us.status) = '2' THEN 'PINDAH'
                                    ELSE 'AKTIF'
                                END
                            END keanggotaan,
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as los,
                            COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) * 50000,0) as simpananpokokwajib,
                            COALESCE(SUM(pj.amount),0.00) as penarikan,
                            pj.created_at as tgl_penarikan,
                            COALESCE(SUM(sm.amount),0.00) sukarela,
                            COALESCE(((PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) * 100000)
                            +
                            COALESCE(SUM(sm.amount),0.00)),0.00) total,
                            COALESCE(((PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) * 100000)
                            +
                            COALESCE(SUM(sm.amount),0.00))
                            -
                            COALESCE(SUM(pj.amount),0.00),0.00) saldo
                        ";
                        
                        $table = "
                            users us
                            LEFT JOIN users_roles ur ON us.role_id = ur.id
                            LEFT JOIN simpanan sm ON sm.user_id = us.id AND sm.status = 'approve' and sm.jenis = 'simpan'
                            LEFT JOIN pinjaman pj ON pj.user_id = us.id AND pj.status = 'approve' and pj.jenis = 'tarik simpanan'
                        ";
                        
                        
                        $where = "
                             us.role_id in (select id from users_roles where role_name  like '%anggota%')
                        ";

                        if($fkeanggotaan){
                            if($fkeanggotaan == 'pindah'){
                                $where .= "
                                     AND lower(us.status) = '2'
                                ";
                            }else{
                                $where .= "
                                     AND lower(us.tgl_dinas) $fkeanggotaan
                                ";
                            }
                        }

                        $where.="
                            GROUP BY 
                                us.name,us.id,us.nrp,us.tgl_dinas,us.is_active,us.status,
                                ur.role_name,pj.created_at
                        ";
                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
        public function getPinjaman(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $fstatus        = $request->status ;
                        $fkeanggotaan   = $request->keanggotaan ;
                        $fstatuspinjam  = $request->statuspinjam ;
                        $status = [];
                        
                        $select = "
                            us.name,us.id as user,us.nrp,us.tgl_dinas,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                                when us.is_active = '3' then 'DELETE' 
                            end status_name,
                            ur.role_name,
                            CASE 
                                WHEN us.tgl_dinas > current_date THEN 'PENSIUN'
                                WHEN us.tgl_dinas is null THEN 'TGL DINAS KOSONG'
                                ELSE
                                    CASE 
                                        WHEN lower(us.status) = '2' THEN 'PINDAH'
                                    ELSE 'AKTIF'
                                END
                            END keanggotaan,
                            lp.amount as limitpinjaman,
                            pj.id as idpinjam,
                            COALESCE(pj.amount,0) as pinjaman,
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as totaltenor,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 as decimal(18,2)) as pinjamanbunga,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor as decimal(18,2)) as totalbayarperbulan1,
                            cast(((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as decimal(18,2)) as totalbayar1,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor as decimal(18,2)) as pinjaman2persen,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor as decimal(18,2)) totalbayarperbulan,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            as decimal(18,2)) as totalbayar,
                            COALESCE(pj.amount,0) - cast(COALESCE(pj.amount,0) - COALESCE(pj.amount,0) / pj.tenor  * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))as decimal(18,2)) as sisalimit,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor)
                                -
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                                PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            as decimal(18,2)) as sisapinjaman,
                            pj.tenor - PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as sisatenor,
                            pj.tenor,
                            pj.created_at tglaju,
                            pj.updated_at tgllunas,
                            case
                                when lower(pj.status_pinjaman) = 'lunas' then 'lunas'
                                else 'belum lunas'
                            END as status_pinjaman,
                            concat(DATE_FORMAT(current_date, '%Y-%m'),'-01') as tglbayar
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            JOIN pinjaman pj ON pj.user_id = us.id AND pj.status = 'approve'
                            LEFT JOIN limit_pinjaman lp ON lp.user_id = us.id 
                        ";
                        
                        
                        $where = "
                             ur.role_name like '%anggota%' 
                        ";

                        if($fkeanggotaan){
                            if($fkeanggotaan == 'pindah'){
                                $where .= "
                                     AND lower(us.status) = '2'
                                ";
                            }else{
                                $where .= "
                                     AND lower(us.tgl_dinas) $fkeanggotaan
                                ";
                            }
                        }
                        if($fstatuspinjam == '1'){
                            $where .= "
                                 AND (lower(pj.status_pinjaman) = 'lunas' OR COALESCE(pj.tenor,0) = PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')))
                            ";
                        }elseif($fstatuspinjam == '2'){
                            $where .= "
                                 AND pj.status_pinjaman != 'lunas' AND COALESCE(pj.tenor,0) != PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            ";
                        }

                        $where.="
                            GROUP BY 
                                us.name,us.id,us.nrp,us.tgl_dinas,us.is_active,us.status,
                                ur.role_name,lp.amount,pj.amount,pj.tenor,pj.created_at,pj.status_pinjaman,
                                pj.id,pj.created_at,pj.updated_at
                                ORDER BY pj.created_at desc
                        ";
                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
        public function getpengajuanpinjaman(Request $request){

            $MasterClass = new Master();

            $user_id    = $MasterClass->getSession('user_id') ;
            $role       = $MasterClass->getSession('role_name') ;
            $checkAuth = $MasterClass->Authenticated($user_id);
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $fstatus        = $request->status ;
                        $fkeanggotaan   = $request->keanggotaan ;
                        $fstatuspinjam  = $request->statuspinjam ;
                        $status = [];
                        
                        $select = "
                            us.name,us.id as user,us.nrp,us.tgl_dinas,us.no_anggota,us.pangkat,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                                when us.is_active = '3' then 'DELETE' 
                            end status_name,
                            ur.role_name,
                            CASE 
                                WHEN us.tgl_dinas > current_date THEN 'PENSIUN'
                                WHEN us.tgl_dinas is null THEN 'TGL DINAS KOSONG'
                                ELSE
                                    CASE 
                                        WHEN lower(us.status) = '2' THEN 'PINDAH'
                                    ELSE 'AKTIF'
                                END
                            END keanggotaan,
                            lp.amount as limitpinjaman,
                            pj.id as idpinjam,
                            COALESCE(pj.amount,0) as pinjaman,
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as totaltenor,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 as decimal(18,2)) as pinjamanbunga,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor as decimal(18,2)) as totalbayarperbulan1,
                            cast(((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as decimal(18,2)) as totalbayar1,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor as decimal(18,2)) as pinjaman2persen,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor as decimal(18,2)) totalbayarperbulan,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            as decimal(18,2)) as totalbayar,
                            COALESCE(pj.amount,0) - cast(COALESCE(pj.amount,0) - COALESCE(pj.amount,0) / pj.tenor  * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))as decimal(18,2)) as sisalimit,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor)
                                -
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                                PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            as decimal(18,2)) as sisapinjaman,
                            pj.tenor - PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as sisatenor,
                            pj.tenor,
                            pj.status,
                            pj.jenis,
                            lower(pj.status_pinjaman) as status_pinjaman
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            JOIN pinjaman pj ON pj.user_id = us.id
                            LEFT JOIN limit_pinjaman lp ON lp.user_id = us.id 
                        ";
                        
                        
                        $where = "
                             ur.role_name like '%anggota%' 
                        ";
                        
                        if($role == 'anggota'){
                            $where .= "
                                 AND us.id = $user_id  
                            ";
                        }
                        if($fkeanggotaan){
                            if($fkeanggotaan == 'pindah'){
                                $where .= "
                                     AND lower(us.status) = '2'
                                ";
                            }else{
                                $where .= "
                                     AND lower(us.tgl_dinas) $fkeanggotaan
                                ";
                            }
                        }
                        if($fstatuspinjam ){
                            $where .= "
                                 AND (lower(pj.status) = '$fstatuspinjam')
                            ";
                        }

                        $where.="
                            GROUP BY 
                                us.name,us.id,us.nrp,us.tgl_dinas,us.is_active,us.status,us.no_anggota,us.pangkat,
                                ur.role_name,lp.amount,pj.amount,pj.tenor,pj.created_at,pj.status_pinjaman,
                                pj.status,pj.jenis,pj.id
                                ORDER BY pj.status desc,pj.created_at asc
                        ";
                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
        public function listTransaksi(Request $request){
            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        
                        $idlogin    = strtolower($MasterClass->getSession('user_id'));
                        $rolelogin  = strtolower($MasterClass->getSession('role_name'));
                        
                        DB::beginTransaction();     
                        
                        $status = [];
                        
                        $select = "
                            ht.*
                        ";
                        
                        $table = "
                        history_transaksi ht
                        ";
                        $where = " 
                            ht.user_id is not null 
                        ";
                        if($rolelogin != 'superadmin' && $rolelogin != 'penjaga' && $rolelogin != 'pemilik'){
                            $where  .=" AND ht.user_id = $idlogin ";
                        }
                        $where .= " 
                        order by created_at desc
                        ";
                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
        public function getfotokamar(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
    
                        $saved = DB::select("SELECT * FROM foto_kamar where id_kamar = ".$request->id);
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
        public function getlaporan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $fstatus        = $request->status ;
                        $fkeanggotaan   = $request->keanggotaan ;
                        $fstatuspinjam  = $request->statuspinjam ;
                        $status = [];
                        
                        $select = "
                            us.name,us.id as user,us.nrp,us.tgl_dinas,
                            case 
                                when us.is_active = '1' then 'ACTIVE' 
                                when us.is_active = '2' then 'INACTIVE' 
                                when us.is_active = '3' then 'DELETE' 
                            end status_name,
                            ur.role_name,
                            CASE 
                                WHEN us.tgl_dinas > current_date THEN 'PENSIUN'
                                WHEN us.tgl_dinas is null THEN 'TGL DINAS KOSONG'
                                ELSE
                                    CASE 
                                        WHEN lower(us.status) = '2' THEN 'PINDAH'
                                    ELSE 'AKTIF'
                                END
                            END keanggotaan,
                            lp.amount as limitpinjaman,
                            pj.id as idpinjam,
                            COALESCE(pj.amount,0) as pinjaman,
                            COALESCE(cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 as decimal(18,2)),0) as pinjamanbunga,
                            COALESCE(cast(((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) as decimal(18,2)),0) as totalbayar1,
                            
                            COALESCE(cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor)
                                -
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                                PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            as decimal(18,2)),0) as sisapinjaman,
                            pj.created_at tglaju,
                            pj.updated_at tgllunas,
                            case
                                when lower(pj.status_pinjaman) = 'lunas' then 'lunas'
                                else 'belum lunas'
                            END as status_pinjaman,
                            concat(DATE_FORMAT(current_date, '%Y-%m'),'-01') as tglbayar
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            LEFT JOIN pinjaman pj ON pj.user_id = us.id AND pj.status = 'approve'
                            LEFT JOIN limit_pinjaman lp ON lp.user_id = us.id 
                            LEFT JOIN simpanan sm ON sm.user_id = us.id AND sm.jenis = 'simpan'
                            LEFT JOIN simpanan st ON st.user_id = us.id AND st.jenis = 'tarik'
                        ";
                        
                        
                        $where = "
                             ur.role_name like '%anggota%' 
                        ";

                        if($fkeanggotaan){
                            if($fkeanggotaan == 'pindah'){
                                $where .= "
                                     AND lower(us.status) = '2'
                                ";
                            }else{
                                $where .= "
                                     AND lower(us.tgl_dinas) $fkeanggotaan
                                ";
                            }
                        }
                        if($fstatuspinjam == '1'){
                            $where .= "
                                 AND (lower(pj.status_pinjaman) = 'lunas' OR COALESCE(pj.tenor,0) = PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')))
                            ";
                        }elseif($fstatuspinjam == '2'){
                            $where .= "
                                 AND pj.status_pinjaman != 'lunas' AND COALESCE(pj.tenor,0) != PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m'))
                            ";
                        }

                        $where.="
                            GROUP BY 
                                us.name,us.id,us.nrp,us.tgl_dinas,us.is_active,us.status,
                                ur.role_name,lp.amount,pj.amount,pj.tenor,pj.created_at,pj.status_pinjaman,
                                pj.id,pj.created_at,pj.updated_at
                                ORDER BY pj.created_at desc
                        ";
                        $result = $MasterClass->selectGlobal($select,$table,$where);
                        
                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $result['data'],
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
    //CRUD FUNCTION
        public function saveUser(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        $now    = date('Y-m-d H:i:s');
                        $status = [];
                        if ($data->password){
                            $saved = User::updateOrCreate(
                                [
                                    'id' => $data->id,
                                ], 
                                [
                                    'name' => $data->name,
                                    'no_anggota'=> $data->noanggota,
                                    'pangkat'=> $data->pangkat,
                                    'nrp'=> $data->nrp,
                                    'alamat'=> $data->alamat,
                                    'handphone'=> $data->handphone,
                                    'tgl_dinas'=> $data->tgldinas,
                                    'status'=> $data->status,
                                    'role_id' => $data->role_id,
                                    'password' => Hash::make($data->password),
                                    'is_active' => '1',
                                    'updated_at' => $now,
                                ] // Kolom yang akan diisi
                            );

                        }else{
                        
                            $saved = User::updateOrCreate(
                                [
                                    'id' => $data->id,
                                ], 
                                [
                                    'name' => $data->name,
                                    'no_anggota'=> $data->noanggota,
                                    'pangkat'=> $data->pangkat,
                                    'nrp'=> $data->nrp,
                                    'alamat'=> $data->alamat,
                                    'handphone'=> $data->handphone,
                                    'tgl_dinas'=> $data->tgldinas,
                                    'status'=> $data->status,
                                    'role_id' => $data->role_id,
                                    'is_active' => '1',
                                ] // Kolom yang akan diisi
                            );
                            
                        }
                        
                        $saved2 = limit_pinjaman::updateOrCreate(
                            [
                                'id' => $data->idlimit,
                            ], 
                            [
                                'user_id' => $saved->id,
                                'amount'  => $data->limit_pinjaman,
                            ] // Kolom yang akan diisi
                        );

                        $saved = $MasterClass->checkErrorModel($saved);
                        $saved2 = $MasterClass->checkErrorModel($saved2);
                        
                        $status  = $saved;
                        $status2 = $saved2;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS && $status2['code'] == $MasterClass::CODE_SUCCESS){
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

                        $attributes     = [
                            'is_active' => '2'
                        ];
                        $where     = [
                            'id' => $data->id
                        ];
                        $saved      = $MasterClass->updateGlobal('users', $attributes,$where );
                        $status = $saved;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code' => $status['code'],
                            'info'  => $status['info'],
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
        public function approvalpinjaman(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        
                        $status = [];

                        if($data->jenis == 'statuslunas'){
                            $attributes     = [
                                'status_pinjaman' => $data->status,
                                'updated_at'      => date('Y-m-d H:i:s')
                            ];
                        }else{
                            $attributes     = [
                                'status' => $data->status
                            ];
                        }
                        $where     = [
                            'id' => $data->idpinjam
                        ];

                        $saved      = $MasterClass->updateGlobal('pinjaman', $attributes,$where );
                        $status = $saved;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code' => $status['code'],
                            'info'  => $status['info'],
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
        public function saveFileSampul(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $idkamar            = $request->idkamar;
                        
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'kos';
                        if(!empty($_FILES['form-sampul']['name'])){//jika file ada maka masukan file 
                            $where = [
                                'id_kamar'      => $idkamar,
                                'jenis'         => 'sampul'
                            ];
                            $MasterClass->deleteGlobal('foto_kamar', $where );

                            $nama_file          = $_FILES['form-sampul']['name'];
                            $type		        = $_FILES['form-sampul']['type'];
                            $ukuran		        = $_FILES['form-sampul']['size'];
                            $tmp_name		    = $_FILES['form-sampul']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/kos/'; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                            
                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
    
                                $attrphoto     = [
                                    'id_kamar'  => $idkamar,
                                    'file'      => $nama_file_upload,
                                    'alamat'    => $alamatfile,
                                    'size'      => $ukuran,
                                    'tipe'      => $type,
                                    'jenis'     => 'sampul',
                                    'created_at'=> $now,
                                ];
                                $savefoto      = $MasterClass->saveGlobal('foto_kamar', $attrphoto );
                                if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Gagal simpan data kamar",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }
    
                                
    
                            DB::commit();
                            $results = [
                                'code'  => $MasterClass::CODE_SUCCESS,
                                'info'  => 'ok',
                            ];
                        }else{//jika tidak ada anggao sukses
                            $results = [
                                'code'  => $MasterClass::CODE_SUCCESS,
                                'info'  => 'ok',
                            ];
                        }
            
            
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
        public function saveBukti(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $idkamar            = $request->idkamar;
                        $user_id            = $request->user_id;
                        $name               = $request->name;
                        $handphone          = $request->handphone;
                        $no_kamar           = $request->no_kamar;
                        $tipe_kamar         = $request->tipe_kamar;
                        $faskos             = $request->faskos;
                        $faskosp            = $request->faskosp;
                        $tgl_awal           = $request->tgl_awal;
                        $jmlbulan           = $request->jmlbulan;
                        $harga              = $request->harga;
                        $biayatambah        = $request->biayatambah;
                        $biaya              = $request->biaya;
                        $jenispembayaran    = $request->jenispembayaran;
                        if($jenispembayaran == '1'){
                            $jmlbulan           = 1 ;
                            $tgl_akhir          = date("Y-m-d", strtotime("+1 month", strtotime($tgl_awal)));
                        }else{
                            $tgl_awal           = date("Y-m-d", strtotime("+".$jmlbulan." month", strtotime($tgl_awal)));
                            $tgl_akhir          = date("Y-m-d", strtotime("+".$jmlbulan." month", strtotime($tgl_awal)));
                        }

                         if($user_id == '' || $user_id == null || $user_id == 'undefined'){//ngebaca yg upload apakah admin / penghuni
                            $user_id = $MasterClass->getSession('user_id') ; 
                         }
                        $now                = date('Y-m-d H:i:s');
                        $docname            = 'bukti';

                        $nama_file          = $_FILES['form-bukti']['name'];
                        $type		        = $_FILES['form-bukti']['type'];
                        $ukuran		        = $_FILES['form-bukti']['size'];
                        $tmp_name		    = $_FILES['form-bukti']['tmp_name'];
                        $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                        $alamatfile         = '../public/data/bukti/'; // directory file
                        $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                        
                        if (move_uploaded_file($tmp_name,$uploaddir)){
                            chmod($uploaddir, 0777);

                            $attrphoto     = [
                                'user_id'   => $user_id,
                                'tgl_awal'  => $tgl_awal,
                                'tgl_akhir' => $tgl_akhir,
                                'file'      => $nama_file_upload,
                                'alamat'    => $alamatfile,
                                'size'      => $ukuran,
                                'tipe'      => $type,
                                'jenis'     => 'bukti',
                                'created_at'=> $now,
                            ];
                            $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                            if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data",
                                ];
                                return $MasterClass->Results($results);
                            }

                            
                            $attrtransaksi     = [
                                'user_id'           => $user_id,
                                'name'              => $name,
                                'handphone'         => $handphone,
                                'no_kamar'          => $no_kamar,
                                'tipe'              => $tipe_kamar,
                                'fasilitas'         => $faskos,
                                'fasilitas_penghuni'=> $faskosp,
                                'tgl_awal'          => $tgl_awal,
                                'tgl_akhir'         => $tgl_akhir,
                                'jml_bulan'         => $jmlbulan,
                                'biaya_kamar'       => $harga,
                                'biaya_tambahan'    => $biayatambah,
                                'total_biaya'       => $biaya,
                                'created_at'        => $now,
                            ];
                            $savetransaksi      = $MasterClass->saveGlobal('history_transaksi', $attrtransaksi );
                            if($savetransaksi['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data",
                                ];
                                return $MasterClass->Results($results);
                            }

                            // update masa kos 1 bulan
                            $attributes     = [
                                'tgl_awal'      => $tgl_awal,
                                'tgl_akhir'     => $tgl_akhir,
                                'updated_at'    => $now,
                            ];
                            $where     = [
                                'id_kamar' => $idkamar,
                                'user_id' => $user_id,
                            ];
                            $updatemasa      = $MasterClass->updateGlobal('mapping_kamar', $attributes,$where );

                            if($updatemasa['code'] != $MasterClass::CODE_SUCCESS){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'info'  => "Gagal simpan data",
                                ];
                                return $MasterClass->Results($results);
                            }

                        }

                        DB::commit();
                        $results = [
                            'code'  => $MasterClass::CODE_SUCCESS,
                            'info'  => 'ok',
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
