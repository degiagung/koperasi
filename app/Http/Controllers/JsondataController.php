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
                        $saved = DB::select("SELECT * FROM menus_access ma LEFT JOIN users_access ua ON ma.id = ua.menu_access_id WHERE ua.role_id =".$role_id. " AND ua.i_view=1 order by coalesce(ma.urutan,10),ma.menu_name asc");

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
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $where = " WHERE role_name is not null " ;

                        if($MasterClass->getSession('role_name') != 'superadmin' ){
                            $where .= " AND role_name not like '%admin%'";
                        }
                        if($request->anggota == 'no'){
                            $where .= " AND role_name != 'anggota'";
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
        public function kesatuan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        $data = json_decode($request->getContent());

                        
                        DB::beginTransaction();
                
                        $status = [];
                        $saved = DB::select("SELECT * FROM kesatuan");
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
                            cast(lp.amount as decimal(18,0)) as limit_pinjaman,
                            cast(us.gaji as decimal(18,0)) as gaji,
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')) * cast(us.gaji as decimal(18,0)) as totalgaji
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
                        $userid      = $MasterClass->getSession('user_id') ;
                        $role        = $MasterClass->getSession('role_name') ;
                        $fstatus     = $request->status ;
                        $fkeanggotaan= $request->keanggotaan ;
                        $status = [];
                        $ftahun         = $request->tahun ;
                        $fbulan         = $request->bulan ;
                        
                        if($fbulan >= 1 && $fbulan <= 9){
                            $fbulan = "0".$fbulan ;
                        }
                        $wherefdate  = "";
                        $wherefdate1 = "";
                        $wherefdate2 = "";
                        $wherefdate3 = "";
                        $wherefdate4 = "";
                        if($ftahun){
                            
                            $wherefdate .= "
                                and DATE_FORMAT(tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate1 .= "
                                AND DATE_FORMAT(pj1.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate2 .= "
                                AND DATE_FORMAT(st.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate3 .= "
                                AND DATE_FORMAT(ss.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate4 .= "
                                AND DATE_FORMAT(su.tgl_approve, '%Y') = '$ftahun' 
                            ";
                        }
                        if($fbulan){
                            $fbulan = $ftahun.$fbulan ;
                            $wherefdate .= "
                                and DATE_FORMAT(tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate1 .= "
                                AND DATE_FORMAT(pj1.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate2 .= "
                                AND DATE_FORMAT(st.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate3 .= "
                                AND DATE_FORMAT(ss.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate4 .= "
                                AND DATE_FORMAT(su.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                        }
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
                            
                            cast(( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0)) as decimal(18,2)) as simpananpokok,
                            
                            cast(COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) * 50000 as decimal(18,2)) as simpananwajib,
                            
                            COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) jmldinas, 
                            coalesce(sum(su.amount),0.00)+coalesce(sum(ss.amount),0.00) as sukarela,

                            (
                                cast(( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0)) as decimal(18,2))
                            )
                            +
                            (
                                COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) * 50000
                            )
                            +
                            coalesce(sum(su.amount),0.00)
                            +
                            coalesce(sum(ss.amount),0.00)
                            as total,
                            coalesce(sum(st.amount),0) penarikan,
                            cast((
                                ( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                            )
                            +
                            (
                                COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) * 50000
                            )
                            +
                            coalesce(sum(su.amount),0.00)
                            +
                            coalesce(sum(ss.amount),0.00)
                            -
                            cast(coalesce(sum(st.amount),0) as decimal(18,2))
                            as decimal(18,2) ) as saldo,
                            st.created_at tgl_penarikan
                        ";
                        
                        $table = "
                            users us
                            LEFT JOIN users_roles ur ON us.role_id = ur.id
                            LEFT JOIN (
                                    select 
                                        user_id,
                                        CASE
                                            WHEN DATE_ADD(tgl_awal, INTERVAL durasi MONTH) >= CURRENT_DATE() THEN 
                                                amount * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),
                                                DATE_FORMAT(tgl_awal, '%Y%m')),0) 
                                            ELSE 
                                                amount * durasi
                                        END amount
                                    from 
                                        simpanan_sukarela su 
                                    where su.jenis = 'potong gaji' and su.status = 'approve' $wherefdate4
                                ) as su ON su.user_id = us.id
                            LEFT JOIN simpanan st ON st.user_id = us.id AND st.jenis = 'tarik' AND (st.status is not null or st.status != '') $wherefdate2
                            LEFT JOIN (
                                select 
                                    ss.user_id,sum(amount) as amount
                                from
                                    simpanan_sukarela ss
                                where
                                    ss.jenis = 'manual' and ss.status = 'approve' $wherefdate3
                                group by
                                    ss.user_id
                            ) ss ON ss.user_id = us.id                         
                        ";

                        
                        $where = "
                             us.role_id in (select id from users_roles where role_name  like '%anggota%')
                        ";
                        
                        if($role == 'anggota'){
                            $where .= "
                                 AND us.id = $userid  
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

                        $where.="
                            GROUP BY 
                                us.name,us.id,us.nrp,us.tgl_dinas,us.is_active,us.status,
                                ur.role_name,st.created_at
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
                        $userid         = $MasterClass->getSession('user_id') ;
                        $role           = $MasterClass->getSession('role_name');
                        $fstatus        = $request->status ;
                        $fkeanggotaan   = $request->keanggotaan ;
                        $fstatuspinjam  = $request->statuspinjam ;
                        $ftahun         = $request->tahun ;
                        $fbulan         = $request->bulan ;
                        
                        if($fbulan >= 1 && $fbulan <= 9){
                            $fbulan = "0".$fbulan ;
                        }
                        $wherefdate  = "";
                        $wherefdate1 = "";
                        $wherefdate2 = "";
                        $wherefdate3 = "";
                        $wherefdate4 = "";
                        if($ftahun){
                            
                            $wherefdate .= "
                                and DATE_FORMAT(pj.created_at, '%Y') = '$ftahun' 
                            ";
                        }
                        if($fbulan){
                            $fbulan = $ftahun.$fbulan ;
                            $wherefdate .= "
                                and DATE_FORMAT(pj.created_at, '%Y%m') = '$fbulan'
                            ";
                        }

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
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')) as totaltenor,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 as decimal(18,2)) as pinjamanbunga,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor as decimal(18,2)) as totalbayarperbulan1,
                            cast(((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as decimal(18,2)) as totalbayar1,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02)
                                -
                                ((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as decimal(18,2)
                            ) sisapinjaman1,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor as decimal(18,2)) as pinjaman2persen,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor as decimal(18,2)) totalbayarperbulan,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m'))
                            as decimal(18,2)) as totalbayar,
                            COALESCE(pj.amount,0) - cast(COALESCE(pj.amount,0) - COALESCE(pj.amount,0) / pj.tenor  * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m'))as decimal(18,2)) as sisalimit,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor)
                                -
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                                PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m'))
                            as decimal(18,2)) as sisapinjaman,
                            pj.tenor - PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')) as sisatenor,
                            
                            pj.tenor,
                            pj.created_at tglaju,
                            pj.updated_at tgllunas,
                            pj.tgl_approve tglapprove,
                            case
                                when lower(pj.status_pinjaman) = 'lunas' then 'lunas'
                                else 'belum lunas'
                            END as status_pinjaman,
                            concat(DATE_FORMAT(current_date, '%Y-%m'),'-01') as tglbayar
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            JOIN pinjaman pj ON pj.user_id = us.id AND pj.status = 'approve' $wherefdate
                            LEFT JOIN limit_pinjaman lp ON lp.user_id = us.id 
                        ";
                        
                        
                        $where = "
                             ur.role_name like '%anggota%' 
                        ";

                        if($role == 'anggota'){
                            $where .= "
                                 AND us.id = $userid  
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
                                pj.id,pj.created_at,pj.updated_at,pj.tgl_approve
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
                        $ftahun         = $request->tahun ;
                        $fbulan         = $request->bulan ;
                        if($fbulan >= 1 && $fbulan <= 9){
                            $fbulan = "0".$fbulan ;
                        }
                        $status = [];
                        
                        $wherefdate  = "";
                        if($ftahun){
                            
                            $wherefdate .= "
                                and DATE_FORMAT(pj.tgl_approve, '%Y') = '$ftahun' 
                            ";
                        }
                        if($fbulan){
                            $fbulan = $ftahun.$fbulan ;
                            $wherefdate .= "
                                and DATE_FORMAT(pj.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                        }
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
                            COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as totaltenor,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 as decimal(18,2)) as pinjamanbunga,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor as decimal(18,2)) as totalbayarperbulan1,
                            cast(((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as decimal(18,2)) as totalbayar1,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor as decimal(18,2)) as pinjaman2persen,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor as decimal(18,2)) totalbayarperbulan,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                            COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0)
                            as decimal(18,2)) as totalbayar,
                            cast(COALESCE(lp.amount,0) - COALESCE(pj.amount,0) + (COALESCE(pj.amount,0)/pj.tenor*COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0)) as decimal(18,2)) as sisalimit,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 )
                                -
                                ((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0)
                            as decimal(18,2)) as sisapinjaman,
                            pj.tenor - COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as sisatenor,
                            pj.tenor,
                            pj.status,
                            pj.jenis,
                            pj.tgl_approve,
                            lower(pj.status_pinjaman) as status_pinjaman
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            JOIN pinjaman pj ON pj.user_id = us.id $wherefdate
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
                                pj.status,pj.jenis,pj.id,pj.tgl_approve
                                ORDER BY coalesce(pj.status,'waiting') desc,pj.created_at desc
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
        public function getlaporan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $userid         = $MasterClass->getSession('user_id') ;
                        $role           = $MasterClass->getSession('role_name') ;
                        $fstatus        = $request->status ;
                        $fkeanggotaan   = $request->keanggotaan ;
                        $fstatuspinjam  = $request->statuspinjam ;
                        $ftahun         = $request->tahun ;
                        $fbulan         = $request->bulan ;
                        if($fbulan >= 1 && $fbulan <= 9){
                            $fbulan = "0".$fbulan ;
                        }
                        $status = [];
                        
                        $wherefdate  = "";
                        $wherefdate1 = "";
                        $wherefdate2 = "";
                        $wherefdate3 = "";
                        $wherefdate4 = "";
                        if($ftahun){
                            
                            $wherefdate .= "
                                and DATE_FORMAT(tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate1 .= "
                                AND DATE_FORMAT(pj1.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate2 .= "
                                AND DATE_FORMAT(st.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate3 .= "
                                AND DATE_FORMAT(ss.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate4 .= "
                                AND DATE_FORMAT(su.tgl_approve, '%Y') = '$ftahun' 
                            ";
                        }
                        if($fbulan){
                            $fbulan = $ftahun.$fbulan ;
                            $wherefdate .= "
                                and DATE_FORMAT(tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate1 .= "
                                AND DATE_FORMAT(pj1.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate2 .= "
                                AND DATE_FORMAT(st.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate3 .= "
                                AND DATE_FORMAT(ss.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate4 .= "
                                AND DATE_FORMAT(su.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                        }

                        // dd($wherefdate);

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
                            COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) jmldinas,
                            ( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                            +
                            (50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                            + 
                            coalesce(sum(su.amount),0.00)
                            as sukarela,

                            (
                                cast(( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0)) as decimal(18,2))
                            )
                            +
                            (
                                COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) * 50000
                            )
                            +
                            coalesce(sum(su.amount),0.00)
                            +
                            coalesce(sum(ss.amount),0.00)
                            as simpanan,

                            coalesce(sum(st.amount),0) tariksimpanan,
                            cast((
                                ( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                            )
                            +
                            (
                                COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) * 50000
                            )
                            +
                            coalesce(sum(su.amount),0.00) 
                            +
                            coalesce(sum(ss.amount),0.00)
                            -
                            cast(coalesce(sum(st.amount),0) as decimal(18,2))
                            as decimal(18,2) ) as sisasimpanan,
                            pj.amount pinjaman,
                            cast(((COALESCE(pj1.amount,0) + COALESCE(pj1.amount,0)*0.02) / pj1.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj1.tgl_approve, '%Y%m')),0) as decimal(18,2)) as totalbayar,
                            cast(pj1.amount - ((COALESCE(pj1.amount,0) + COALESCE(pj1.amount,0)*0.02) / pj1.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj1.tgl_approve, '%Y%m')),0) as decimal(18,2)) as sisapinjaman

                        ";
                        
                        $table = "
                            users us
                            LEFT JOIN users_roles ur ON us.role_id = ur.id
                            LEFT JOIN (
                                select 
                                    sum(amount) amount,
                                    user_id
                                from pinjaman
                                where status = 'approve' $wherefdate
                                group by user_id
                            ) pj ON pj.user_id = us.id 
                            LEFT JOIN pinjaman pj1 ON pj1.user_id = us.id AND pj1.status = 'approve' and pj1.status_pinjaman != 'lunas' and COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj1.tgl_approve, '%Y%m')),0) < pj1.tenor $wherefdate1
                            LEFT JOIN (
                                    select 
                                        user_id,
                                        CASE
                                            WHEN DATE_ADD(tgl_awal, INTERVAL durasi MONTH) >= CURRENT_DATE() THEN 
                                                amount * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),
                                                DATE_FORMAT(tgl_awal, '%Y%m')),0) 
                                            ELSE 
                                                amount * durasi
                                        END amount
                                    from 
                                        simpanan_sukarela su 
                                    where su.jenis = 'potong gaji' and su.status = 'approve' $wherefdate4
                            ) as su ON su.user_id = us.id                          
                            LEFT JOIN simpanan st ON st.user_id = us.id AND st.jenis = 'tarik' AND (st.status is not null or st.status != '') $wherefdate2
                            LEFT JOIN (
                                select 
                                    ss.user_id,sum(amount) as amount
                                from
                                    simpanan_sukarela ss
                                where
                                    ss.jenis = 'manual' and ss.status = 'approve' $wherefdate3
                                group by
                                    ss.user_id
                            ) ss ON ss.user_id = us.id
                        ";
                        
                        $where = "
                             us.role_id in (select id from users_roles where role_name  like '%anggota%')
                        ";
                        
                        if($role == 'anggota'){
                            $where .= "
                                 AND us.id = $userid  
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
                                ur.role_name,
                                pj.amount,pj1.amount,pj1.tenor,pj1.tgl_approve
                        ";
                        $result      = $MasterClass->selectGlobal($select,$table,$where);
                        $selectcount = " 
                            sum(a.simpanan) as simpanan,
                            sum(a.tariksimpanan) as tariksimpanan,
                            sum(a.sisasimpanan) as sisasimpanan,
                            sum(a.pinjaman) as pinjaman,
                            sum(a.totalbayar) as totalbayar,
                            sum(a.sisapinjaman) as sisapinjaman
                            from (select
                        " ;
                          
                        $ressum = $MasterClass->selectGlobal($selectcount.$select,$table,$where.') as a');

                        if($result['data']){
                            $datas = [
                                'data' => $result['data'],
                                'sum' => $ressum['data'],
                            ];
                        }else{
                            $datas = null ;
                        }

                        $results = [
                            'code'  => $result['code'],
                            'info'  => $result['info'],
                            'data'  => $datas
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
        public function getlimitpinjaman(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $userid= $MasterClass->getSession('user_id') ;
                        $saved = DB::select("SELECT a.* FROM limit_pinjaman a,users b where a.user_id = b.id and b.id = ".$userid);
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
        public function getpengajuansukarela(Request $request){

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
                        $fjenis         = $request->jenis ;

                        $status = [];
                        
                        $ftahun         = $request->tahun ;
                        $fbulan         = $request->bulan ;
                        
                        if($fbulan >= 1 && $fbulan <= 9){
                            $fbulan = "0".$fbulan ;
                        }
                        $wherefdate  = "";
                        if($ftahun){
                            
                            $wherefdate .= "
                                and DATE_FORMAT(su.tgl_approve, '%Y') = '$ftahun' 
                            ";
                        }
                        if($fbulan){
                            $fbulan = $ftahun.$fbulan ;
                            $wherefdate .= "
                                and DATE_FORMAT(su.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                        }

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
                            su.jenis,
                            su.id idsukarela,su.status,su.amount,su.created_at tgl_pengajuan,su.tgl_approve,DATE_FORMAT(su.tgl_awal, '%Y%m') as tgl_awal,su.durasi,
                            bt.file
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            JOIN simpanan_sukarela su ON us.id = su.user_id $wherefdate
                            LEFT JOIN bukti_transaksi bt ON bt.id = su.id_bukti
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
                                 AND (lower(su.status) = '$fstatuspinjam')
                            ";
                        }
                        if($fjenis ){
                            $where .= "
                                 AND (lower(su.jenis) = '$fjenis')
                            ";
                        }

                        $where.="
                            ORDER BY coalesce(su.status,'waiting') desc,su.created_at desc
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
        public function getsimpananperson(Request $request){
            
            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $userid= $MasterClass->getSession('user_id') ;
                        
                        $select = "COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) jmldinas,
                                cast(
                                    ( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                                    +
                                    (50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                                    + 
                                    coalesce(sum(su.amount),0.00)
                                    +
                                    coalesce(sum(ss.amount),0.00)
                                    -
                                    coalesce(sum(st.amount),0) as decimal(18,2)
                                ) as amount";
                        $table  = "
                                users us
                                left join (
                                    select 
                                        user_id,
                                        tgl_awal,
                                        CASE
                                            WHEN DATE_ADD(tgl_awal, INTERVAL durasi MONTH) >= CURRENT_DATE() THEN 
                                                amount * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),
                                                DATE_FORMAT(tgl_awal, '%Y%m')),0) 
                                            ELSE 
                                                amount * durasi
                                        END amount
                                    from 
                                        simpanan_sukarela su 
                                    where su.jenis = 'potong gaji' and su.status = 'approve'
                                ) as su ON su.user_id = us.id
                                LEFT JOIN simpanan st ON st.user_id = us.id AND st.jenis = 'tarik' AND (st.status is not null or st.status != '')
                                LEFT JOIN (
                                select 
                                    ss.user_id,sum(amount) as amount
                                from
                                    simpanan_sukarela ss
                                where
                                    ss.jenis = 'manual' and ss.status = 'approve'
                                group by
                                    ss.user_id
                            ) ss ON ss.user_id = us.id
                        ";
                        $result = $MasterClass->selectGlobal($select,$table,"us.id = $userid");

                        $status = $result;
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
        public function getlistpenarikan(Request $request){

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
                        $status = [];
                        $ftahun         = $request->tahun ;
                        $fbulan         = $request->bulan ;
                        
                        if($fbulan >= 1 && $fbulan <= 9){
                            $fbulan = "0".$fbulan ;
                        }
                        $wherefdate  = "";
                        $wherefdate1 = "";
                        $wherefdate2 = "";
                        $wherefdate3 = "";
                        $wherefdate4 = "";
                        if($ftahun){
                            
                            $wherefdate .= "
                                and DATE_FORMAT(sm.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate1 .= "
                                AND DATE_FORMAT(su.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            $wherefdate2 .= "
                                AND DATE_FORMAT(ss.tgl_approve, '%Y') = '$ftahun' 
                            ";
                            
                        }
                        if($fbulan){
                            $fbulan = $ftahun.$fbulan ;
                            $wherefdate .= "
                                and DATE_FORMAT(sm.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate1 .= "
                                AND DATE_FORMAT(su.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                            $wherefdate2 .= "
                                AND DATE_FORMAT(ss.tgl_approve, '%Y%m') = '$fbulan'
                            ";
                        }
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
                            sm.created_at as tgl_pengajuan,
                            sm.tgl_approve,
                            cast(sm.amount as decimal(18,2) ) as jml_pengajuan,
                            sm.id as idpenarikan,
                            sm.status,
                            cast(( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                            +
                            (50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                            + 
                            coalesce(sum(su.amount),0.00)
                            +
                            coalesce(sum(ss.amount),0.00)
                            as decimal(18,2))
                            as simpanan
                            
                            
                        ";
                        
                        $table = "
                            users us
                            JOIN users_roles ur ON us.role_id = ur.id
                            JOIN simpanan sm ON sm.user_id = us.id and sm.jenis = 'tarik' $wherefdate
                            LEFT JOIN simpanan sm1 ON sm1.user_id = us.id and sm1.jenis = 'tarik' and (sm1.status != '' or sm1.status is not null)
                            LEFT JOIN (
                                    select 
                                        user_id,
                                        CASE
                                            WHEN DATE_ADD(tgl_awal, INTERVAL durasi MONTH) >= CURRENT_DATE() THEN 
                                                amount * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),
                                                DATE_FORMAT(tgl_awal, '%Y%m')),0) 
                                            ELSE 
                                                amount * durasi
                                        END amount
                                    from 
                                        simpanan_sukarela su 
                                    where su.jenis = 'potong gaji' and su.status = 'approve' $wherefdate1
                                ) as su ON su.user_id = us.id
                            LEFT JOIN (
                                select 
                                    ss.user_id,sum(amount) as amount
                                from
                                    simpanan_sukarela ss
                                where
                                    ss.jenis = 'manual' and ss.status = 'approve' $wherefdate2
                                group by
                                    ss.user_id
                            ) ss ON ss.user_id = us.id
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

                        $where.="
                            GROUP BY
                                us.name,us.id,us.nrp,us.tgl_dinas,us.no_anggota,us.pangkat,
                                sm.created_at,sm.tgl_approve,sm.amount,sm.id,sm.status,us.is_active
                            ORDER BY coalesce(sm.status,'waiting') desc,sm.created_at desc
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
        public function getbuktipinjaman(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $id     = $request->id ;
                        $userid = $MasterClass->getSession('user_id') ;
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a where id_parent = $id  ORDER BY created_at desc");
                        $saved  = $MasterClass->checkErrorModel($saved);
                        
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
        public function getbuktisimpanan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $id     = $request->id ;
                        $userid = $MasterClass->getSession('user_id') ;
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a where user_id = $id AND keterangan = 'wajib' ORDER BY created_at desc");
                        $saved  = $MasterClass->checkErrorModel($saved);
                        
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
        public function getbuktipokok(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $id     = $request->id ;
                        
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a where user_id = $id and keterangan = 'pokok'  ORDER BY created_at desc");
                        $saved  = $MasterClass->checkErrorModel($saved);
                        
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
        public function getbuktitarik(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $idprnt = $request->id ;
                        $userid = $request->userid ;
                        
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a where user_id = $userid and keterangan = 'tarik' and id_parent = $idprnt  ORDER BY created_at desc");
                        $saved  = $MasterClass->checkErrorModel($saved);
                        
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
        public function buktilunas(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $id = $request->id ;
                        $userid = $request->userid ;
                        
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a,pinjaman b where a.id = b.bukti and a.user_id = $userid and a.keterangan = 'bukti lunas pinjaman' and b.id = $id  ORDER BY created_at desc");
                        $saved  = $MasterClass->checkErrorModel($saved);
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
        public function getbuktimanual(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $userid = $request->userid ;
                        $id     = $request->id ;
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a where id = $id AND user_id = $userid AND keterangan = 'manual' ");
                        $saved  = $MasterClass->checkErrorModel($saved);
                        
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
        public function getSimpananbyanggota(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $userid      = $MasterClass->getSession('user_id') ;
                        $role        = $MasterClass->getSession('role_name') ;
                        $fstatus     = $request->status ;
                        $fkeanggotaan= $request->keanggotaan ;
                        $status      = [];
                        $dataArray   = array();
                        
                        $sukarela1 = DB::select("
                        
                            select 
                                tgl_approve tgl_transaksi,
                                amount nominal,
                                'sukarela', 
                                PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(tgl_approve, '%Y%m')) as periode
                            from 
                                simpanan_sukarela su 
                            where 
                                su.jenis = 'potong gaji' 
                                and su.status = 'approve'
                                and su.user_id = $userid  
                        ");

                        if(count($sukarela1) >=1 ){
                            for ($i=0; $i < count($sukarela1); $i++) { 
                                $data       = $sukarela1[$i];
                                $periode    = $data->periode;
                                $array      = array();
                                for ($j=0; $j < $periode ; $j++) { 
                                    array_push($array,$data);
                                    print_r($data);
                                }die;
                            }
                        }
                        dd($sukarela1);
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
        public function getPinjamandashboard(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();     
                        $userid = $MasterClass->getSession('user_id');
                        $role = $MasterClass->getSession('role_name');
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
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')) as totaltenor,

                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02 as decimal(18,2)) as pinjamanbunga,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor as decimal(18,2)) as totalbayarperbulan1,
                            cast(((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as decimal(18,2)) as totalbayar1,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02)
                                -
                                ((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02) / pj.tenor) * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')),0) as decimal(18,2)
                            ) sisapinjaman1,
                            
                            cast(COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor as decimal(18,2)) as pinjaman2persen,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor as decimal(18,2)) totalbayarperbulan,
                            cast((COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                            PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m'))
                            as decimal(18,2)) as totalbayar,
                            COALESCE(pj.amount,0) - cast(COALESCE(pj.amount,0) - COALESCE(pj.amount,0) / pj.tenor  * PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m'))as decimal(18,2)) as sisalimit,
                            cast(
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor)
                                -
                                (COALESCE(pj.amount,0) + COALESCE(pj.amount,0)*0.02*pj.tenor) / pj.tenor * 
                                PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m'))
                            as decimal(18,2)) as sisapinjaman,
                            pj.tenor - PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(pj.tgl_approve, '%Y%m')) as sisatenor,
                            
                            pj.tenor,
                            pj.created_at tglaju,
                            pj.updated_at tgllunas,
                            pj.tgl_approve tglapprove,
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
                        
                        if($role == 'anggota'){
                            $where .= "
                                 AND us.id = $userid  
                            ";
                        }

                        $where.="
                            GROUP BY 
                                us.name,us.id,us.nrp,us.tgl_dinas,us.is_active,us.status,
                                ur.role_name,lp.amount,pj.amount,pj.tenor,pj.created_at,pj.status_pinjaman,
                                pj.id,pj.created_at,pj.updated_at,pj.tgl_approve
                                ORDER BY pj.created_at desc limit 1
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
        public function profileanggota(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $id     = $MasterClass->getSession('user_id') ;
                        $userid = $MasterClass->getSession('user_id') ;
                        $saved  = DB::select("SELECT PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(tgl_dinas, '%Y%m')) los,a.* FROM users a where id = $id");
                        $saved  = $MasterClass->checkErrorModel($saved);
                        
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
        public function getdetailsimpanan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $id     = $request->id ;
                        
                        $result = DB::select("
                            SELECT 
                                *,
                                 CASE
                                    WHEN DATE_ADD(tgl_awal, INTERVAL durasi MONTH) >= CURRENT_DATE() THEN 
                                        COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),
                                        DATE_FORMAT(tgl_awal, '%Y%m')),0) 
                                    ELSE 
                                        durasi
                                END durasi2,
                                DATE_ADD(tgl_awal, INTERVAL durasi MONTH) tgl_akhir,
                                DATE_ADD(tgl_awal, INTERVAL 1 MONTH) as tgl_awal1
                            FROM
                                simpanan_sukarela
                            WHERE
                                status = 'approve'
                                AND user_id = $id
                            ORDER BY id desc
                        ");
                        $result = $MasterClass->checkErrorModel($result);
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
        public function getlistbuktipotonggaji(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        $id     = $request->id ;
                        $saved  = DB::select("SELECT a.* FROM bukti_transaksi a where user_id = $id AND keterangan = 'potong gaji' ORDER BY created_at desc");
                        $saved  = $MasterClass->checkErrorModel($saved);
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
        public function getnotif(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {
                        
                        DB::beginTransaction();
                
                        $status = [];
                        if($MasterClass->getSession('role_name') == 'superadmin' || $MasterClass->getSession('role_name') == 'bendahara koperasi'){
                            $saved  = DB::select("
                                SELECT 
                                    count(pj.id) pinjaman,count(sm.id) simpanan 
                                FROM 
                                    users us
                                    LEFT JOIN pinjaman pj ON us.id = pj.user_id and pj.status is null and pj.status_pinjaman != 'lunas'
                                    LEFT JOIN simpanan sm ON us.id = sm.user_id and sm.status is null
                            ");
                            $saved  = $MasterClass->checkErrorModel($saved);
                            $status = $saved;
                            $results = [
                                'code' => $status['code'],
                                'info' => $status['info'],
                                'data' =>  $status['data'],
                            ];
                        }else{
                            $results = [
                                'code' => '0',
                                'info' => 'ok',
                                'data' => null,
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
    //CRUD FUNCTION
        public function saveUser(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $data = json_decode($request->getContent());
                        $cekuser = DB::select("select * from users where nrp = '$data->nrp'");
                        if($cekuser){
                            $results = [
                                'code' => '1',
                                'message'  => "NRP sudah tersedia",
                            ] ;
                            return $MasterClass->Results($results);

                        }
                        $now    = date('Y-m-d H:i:s');
                        $status = [];
                        if ($data->password){
                            $saved = User::updateOrCreate(
                                [
                                    'id' => $data->id,
                                ], 
                                [
                                    'name' => $data->name,
                                    'nrp'=> $data->nrp,
                                    'alamat'=> $data->alamat,
                                    'handphone'=> $data->handphone,
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
                                    'nrp'=> $data->nrp,
                                    'alamat'=> $data->alamat,
                                    'handphone'=> $data->handphone,
                                    'role_id' => $data->role_id,
                                    'is_active' => '1',
                                ] // Kolom yang akan diisi
                            );
                            
                        }
                        $saved = $MasterClass->checkErrorModel($saved);
                        
                        $status  = $saved;
    
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
        public function saveAnggota(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        // dd($data);
                        $now        = date('Y-m-d H:i:s');
                        $noanggota  = $data->kesatuan.$MasterClass->getIncrement('users')['data'].date('m').date('Y');
                        $limit      = str_replace('.','',$data->limit_pinjaman);
                        $gaji       = str_replace('.','',$data->gaji);
                        $status = [];

                        $attr       = [
                                    'name' => $data->name,
                                    'no_anggota'=> $noanggota,
                                    'pangkat'=> $data->pangkat,
                                    'nrp'=> $data->nrp,
                                    'alamat'=> $data->alamat,
                                    'handphone'=> $data->handphone,
                                    'tgl_dinas'=> $data->tgldinas,
                                    'gaji' => $gaji,
                                    'kesatuan' => $data->kesatuan,
                                    'status'=> $data->status,
                                    'role_id' => $data->role_id,
                                    'password' => Hash::make($data->password),
                                    'is_active' => '1',
                                    'updated_at' => $now,
                                ] ;// Kolom yang akan diisi 
                                
                        if (!$data->password){
                            unset($attr['password']);  
                        }
                        if ($data->save == '0'){
                            unset($attr['no_anggota']);  
                        }
                        $saved = User::updateOrCreate(
                            [
                                'id' => $data->id,
                            ], 
                            $attr
                        );
                        if($limit == null){
                            $limit = 0 ;
                        }
                        $saved2 = limit_pinjaman::updateOrCreate(
                            [
                                'id' => $data->idlimit,
                            ], 
                            [
                                'user_id' => $saved->id,
                                'amount'  => $limit,
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
                                'status'          => $data->status,
                                'approve_by'      => $MasterClass->getSession('name'),
                                'tgl_approve'     => date('Y-m-d H:i:s')

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
        public function actionpengajuanpinjaman(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        $pinjaman   = $data->pinjaman ;
                        $tenor      = $data->tenor ;
                        $jenis      = $data->keperluan ;
                        $userid     = $MasterClass->getSession('user_id') ;
                        $idtrans    = 'trans-'.date('YmdHis').$userid ;
                        $now        = date('Y-m-d H:i:s') ;
                        $status = [];

                        $cekpengajuan = $MasterClass->selectGlobal(
                            "*,PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(tgl_approve, '%Y%m')) los",
                            'pinjaman',
                            "user_id = $userid order by created_at desc limit 1");
                        if($cekpengajuan['data']){
                            if($cekpengajuan['data'][0]->status == 'approve' && $cekpengajuan['data'][0]->status_pinjaman != 'lunas'){   
                                if($cekpengajuan['data'][0]->los < $cekpengajuan['data'][0]->tenor ){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'message'  => "Mohon maaf ,silahkan lunasi pinjaman anda sebelumnya terlebih dahulu.",
                                    ];
                                    return $MasterClass->Results($results);
                                }                           
                            }
                        }
                        $attributes     = [
                            'user_id'           => $userid,
                            'id_transaksi'      => $idtrans,
                            'amount'            => $pinjaman,
                            'status_pinjaman'   => 'belum lunas',
                            'jenis'             => $jenis,
                            'tenor'             => $tenor,
                            'status'            => 'approve',
                            'tgl_approve'       => $now,
                            'created_at'        => $now,
                        ];
                        $saved      = $MasterClass->saveGlobal('pinjaman', $attributes );
                        $status = $saved;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::select("update limit_pinjaman set amount = amount - $pinjaman where user_id = $userid ");
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code'      => $status['code'],
                            'message'   => 'Pengajuan berhasil',
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
        public function actionpengajuansukarela(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        $jumlah     = str_replace('.','',$data->jumlah);
                        $bulan      = $data->bulan.'-01' ;
                        $durasi     = $data->durasi ;
                        $userid     = $MasterClass->getSession('user_id') ;
                        $now        = date('Y-m-d H:i:s') ;
                        $status = [];

                        $cekpengajuan = $MasterClass->selectGlobal(
                            "*",
                            'simpanan_sukarela',
                            "user_id = $userid and DATE_ADD(tgl_awal, INTERVAL 1 MONTH) >= $bulan and jenis = 'potong gaji'");
                        if($cekpengajuan['data']){
                            DB::rollBack();
                            $results = [
                                'code' => '1',
                                'message'  => "Mohon maaf ,masih ada simpanan sukarela yang berjalan diperiode tersebut.",
                            ];
                            return $MasterClass->Results($results);
                        }
                        $attributes     = [
                            'user_id'           => $userid,
                            'amount'            => $jumlah,
                            'tgl_awal'          => $bulan,
                            'durasi'            => $durasi,
                            'status'            => 'approve',
                            'tgl_approve'       => $now,
                            'created_at'        => $now,
                        ];
                        $saved      = $MasterClass->saveGlobal('simpanan_sukarela', $attributes );
                        $status = $saved;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code'      => $status['code'],
                            'message'   => 'Pengajuan berhasil',
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
        public function actionpengajuansukarelamanual(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $jumlah     = str_replace('.','',$request->jumlah) ;
                        $now        = date('Y-m-d H:i:s');
                        $userid     = $MasterClass->getSession('user_id') ;
                        $status = [];

                        $docname            = 'bukti';
                        if(!empty($_FILES['buktimanual']['name'])){//jika file ada maka masukan file 
                            
                            $nama_file          = $_FILES['buktimanual']['name'];
                            $tmp_name		    = $_FILES['buktimanual']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/bukti/'; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                            
                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
    
                                $attrphoto     = [
                                    'file'      => $uploaddir,
                                    'user_id'   => $userid,
                                    'keterangan'=> 'manual',
                                    'created_at'=> $now,
                                ];
                                $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                                
                                if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Pengajuan Gagal",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }
                            

                            $attributes     = [
                                'user_id'           => $userid,
                                'jenis'             => 'manual',
                                'amount'            => $jumlah,
                                'status'            => 'approve',
                                'tgl_approve'       => $now,
                                'id_bukti'          => $savefoto['data'],
                                'created_at'        => $now,
                            ];
                            $saved      = $MasterClass->saveGlobal('simpanan_sukarela', $attributes );
                            $status = $saved;
        
                            if($status['code'] != $MasterClass::CODE_SUCCESS){
                                DB::commit();
                                $results = [
                                    'code'      => $status['code'],
                                    'info'   => 'Pengajuan Gagal',
                                ];
                                return $MasterClass->Results($results);
                            }


                            DB::commit();
                            $results = [
                                'code'      => $status['code'],
                                'info'   => 'Pengajuan Berhasil',
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
        public function approvalsukarela(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        
                        $status = [];

                        $namelogin  = $MasterClass->getSession('name') ;
                        $attributes     = [
                            'status'          => $data->status,
                            'approve_by'      => $namelogin,
                            'tgl_approve'     => date('Y-m-d H:i:s')
                        ];
                        
                        $where     = [
                            'id' => $data->id
                        ];
                        $saved      = $MasterClass->updateGlobal('simpanan_sukarela', $attributes,$where );
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
        public function actionpenarikan(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        $jumlah     = $data->jumlah ;
                        $userid     = $MasterClass->getSession('user_id') ;
                        $now        = date('Y-m-d H:i:s') ;
                        $status = [];

                        // simpanan pokok
                        // ( 50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) / COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                        //         +
                        $cekpengajuan = DB::select("
                            select 
	
                                COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0) jmldinas,
                                
                                (50000 * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),DATE_FORMAT(us.tgl_dinas, '%Y%m')),0))
                                + 
                                coalesce(sum(su.amount),0.00)
                                -
                                coalesce(sum(sm.amount),0)
                                as amount
                            FROM
                                users us
                                left join (
                                    select 
                                        user_id,
                                        tgl_awal,
                                        CASE
                                            WHEN DATE_ADD(tgl_awal, INTERVAL durasi MONTH) >= CURRENT_DATE() THEN 
                                                amount * COALESCE(PERIOD_DIFF(DATE_FORMAT(SYSDATE(), '%Y%m'),
                                                DATE_FORMAT(tgl_awal, '%Y%m')),0) 
                                            ELSE 
                                                amount * durasi
                                        END amount
                                    from 
                                        simpanan_sukarela su 
                                ) as su ON su.user_id = us.id
                                left join simpanan sm on sm.user_id = us.id and (sm.status != '' or sm.status is not null) and sm.jenis = 'tarik'
                            WHERE
                                us.id = $userid
                                
                                
                        ");
                        if($cekpengajuan){
                            if($cekpengajuan[0]->amount < $jumlah){
                                DB::rollBack();
                                $results = [
                                    'code' => '1',
                                    'message'  => "Uang Simpanan tidak cukup.",
                                ];
                                return $MasterClass->Results($results);
                            }
                        }

                        $attributes     = [
                            'user_id'           => $userid,
                            'jenis'             => 'tarik',
                            'amount'            => $jumlah,
                            'status'            => 'approve',
                            'tgl_approve'       => $now,
                            'created_at'        => $now,
                        ];
                        $saved      = $MasterClass->saveGlobal('simpanan', $attributes );
                        $status = $saved;
    
                        if($status['code'] == $MasterClass::CODE_SUCCESS){
                            DB::commit();
                        }else{
                            DB::rollBack();
                        }
            
                        $results = [
                            'code'      => $status['code'],
                            'message'   => 'Pengajuan berhasil',
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
        public function approvaltariksimpan(Request $request){

            $MasterClass = new Master();

            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     

                        $data = json_decode($request->getContent());
                        
                        $status = [];

                        $namelogin  = $MasterClass->getSession('name') ;
                        $attributes     = [
                            'status'          => $data->status,
                            'approve_by'      => $namelogin,
                            'tgl_approve'     => date('Y-m-d H:i:s')
                        ];
                        
                        $where     = [
                            'id' => $data->id,
                        ];
                        $saved      = $MasterClass->updateGlobal('simpanan', $attributes,$where );
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
        public function saveBuktipinjam(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $id         = $request->id ;
                        $no         = $request->no ;
                        $now        = date('Y-m-d H:i:s');
                        $userid     = $MasterClass->getSession('user_id') ;
                        $status = [];

                        $docname            = 'bukti';
                        if(!empty($_FILES['bukti']['name'])){//jika file ada maka masukan file 
                            
                            $nama_file          = $_FILES['bukti']['name'];
                            $tmp_name		    = $_FILES['bukti']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/bukti/'; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                            
                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
    
                                $attrphoto     = [
                                    'file'      => $uploaddir,
                                    'user_id'   => $userid,
                                    'id_parent' => $id,
                                    'tenor'     => $no,
                                    'created_at'=> $now,
                                ];
                                $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                                if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Upload Gagal",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }

                            DB::commit();
                            $results = [
                                'code'      => $MasterClass::CODE_SUCCESS,
                                'info'      => 'Upload Berhasil',
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
        public function saveBuktiSimpanan(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $id         = $request->id ;
                        $no         = $request->no ;
                        $jenis      = $request->jenis ;
                        $now        = date('Y-m-d H:i:s');
                        $status = [];
                        
                        $docname            = 'bukti';
                        if(!empty($_FILES['bukti']['name'])){//jika file ada maka masukan file 
                            
                            $nama_file          = $_FILES['bukti']['name'];
                            $tmp_name		    = $_FILES['bukti']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/bukti/'; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                            
                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
    
                                $attrphoto     = [
                                    'file'      => $uploaddir,
                                    'user_id'   => $id,
                                    'keterangan'=> $jenis,
                                    'tenor'     => $no,
                                    'created_at'=> $now,
                                ];
                                if($jenis == 'pokok'){
                                    unset($attrphoto['tenor']);
                                }
                                $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                                if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Upload Gagal",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }

                            DB::commit();
                            $results = [
                                'code'      => $MasterClass::CODE_SUCCESS,
                                'info'      => 'Upload Berhasil',
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
        public function saveBuktitarik(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $id         = $request->id ;
                        $userid     = $request->userid ;
                        $now        = date('Y-m-d H:i:s');
                        $idlogin    = $MasterClass->getSession('user_id') ;
                        $status = [];

                        $docname            = 'bukti';
                        if(!empty($_FILES['bukti']['name'])){//jika file ada maka masukan file 
                            
                            $nama_file          = $_FILES['bukti']['name'];
                            $tmp_name		    = $_FILES['bukti']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/bukti/'; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                            
                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
    
                                $attrphoto     = [
                                    'file'      => $uploaddir,
                                    'user_id'   => $userid,
                                    'id_parent' => $id,
                                    'keterangan'=> 'tarik',
                                    'created_at'=> $now,
                                ];
                                $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                                if($savefoto['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Upload Gagal",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }

                            DB::commit();
                            $results = [
                                'code'      => $MasterClass::CODE_SUCCESS,
                                'info'      => 'Upload Berhasil',
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
        public function lunasipinjaman(Request $request){

            $MasterClass = new Master();
            
            $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
            
            if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
                try {
                    if ($request->isMethod('post')) {

                        DB::beginTransaction();     
                        $id         = $request->id ;
                        $now        = date('Y-m-d H:i:s');
                        $idlogin    = $MasterClass->getSession('user_id') ;
                        $status = [];
                        
                        $docname            = 'bukti';
                        if(!empty($_FILES['bukti']['name'])){//jika file ada maka masukan file 
                            
                            $nama_file          = $_FILES['bukti']['name'];
                            $tmp_name		    = $_FILES['bukti']['tmp_name'];
                            $nama_file_upload   = strtolower(str_replace(' ','_',$docname.'-'.$nama_file));
                            $alamatfile         = '../public/data/bukti/'; // directory file
                            $uploaddir          = $alamatfile.$nama_file_upload; // directory file
                            
                            if (move_uploaded_file($tmp_name,$uploaddir)){
                                chmod($uploaddir, 0777);
    
                                $attrphoto     = [
                                    'file'      => $uploaddir,
                                    'user_id'   => $idlogin,
                                    'keterangan'=> 'bukti lunas pinjaman',
                                    'created_at'=> $now,
                                ];
                                $savefoto      = $MasterClass->saveGlobal('bukti_transaksi', $attrphoto );
                                
                                $attributes     = [
                                    'status_pinjaman' => 'lunas',
                                    'updated_at'      => $now,
                                    'bukti'        => $savefoto['data']
                                ];
                                $where     = [
                                    'id' => $id
                                ];
                                $savepinjam      = $MasterClass->updateGlobal('pinjaman', $attributes,$where );
                                
                                if($savefoto['code'] != $MasterClass::CODE_SUCCESS || $savepinjam['code'] != $MasterClass::CODE_SUCCESS){
                                    DB::rollBack();
                                    $results = [
                                        'code' => '1',
                                        'info'  => "Upload Gagal",
                                    ];
                                    return $MasterClass->Results($results);
                                }
                            }

                            DB::commit();
                            $results = [
                                'code'      => $MasterClass::CODE_SUCCESS,
                                'info'      => 'Upload Berhasil',
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
}
