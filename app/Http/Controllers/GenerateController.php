<?php

namespace App\Http\Controllers;

use App\Models\MenusAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\JsonDataController;

use Illuminate\Support\Facades\DB;
use ReflectionClass;
use ReflectionMethod;
use App\Helpers\Master;

class GenerateController extends Controller
{
    public function generateview(Request $request){

        $javascriptFiles = [
            asset('action-js/global/global-action.js'),
            asset('action-js/generate/generate-action.js'),
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
    
        return view('pages.generate.index')
            ->with($data);
    }

    public function gendataview(Request $request){

        $javascriptFiles = [
            asset('action-js/global/global-action.js'),
            asset('action-js/generate/generate-action.js'),
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
    
        return view('pages.generate.gendata')
            ->with($data);
    }

    public function generate(Request $request){

        $MasterClass = new Master();

        $checkAuth = $MasterClass->Authenticated($MasterClass->getSession('user_id'));
        
        if($checkAuth['code'] == $MasterClass::CODE_SUCCESS){
            try {
                if ($request->isMethod('post')) {

                    $generalController  = GeneralController::class;
                    $jsonDataController = JsonDataController::class;
            
                    $results    = $this->processControllerMethods($generalController, "VIEW");
                    
                    if ($results['code'] == $MasterClass::CODE_SUCCESS) {
                        $results    = $this->processControllerMethods($jsonDataController, "JSON");
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
    
    private function processControllerMethods($controllerClass, $paramType) {
        
        $MasterClass = new Master();
     
        try {
            
            DB::beginTransaction();
            
            $status = [];
    
            $reflectionClass = new ReflectionClass($controllerClass);
            $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
            
            foreach ($methods as $method) {
                if ($method->name !== '__construct' && $method->class === $controllerClass && $method->name !== 'based') {
                    $methodName = $method->name;
    
                    // Simpan informasi metode ke dalam database AccessUser
                    $saved = MenusAccess::updateOrCreate(
                        ['method' => $methodName], // Kolom dan nilai kriteria
                        ['param_type' => $paramType, 'url' => '/' . $methodName] // Kolom yang akan diisi
                    );
                    $saved = $MasterClass->checkErrorModel($saved);
                    
                    $status = $saved;
                    
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
                
        
            // Commit the transaction if everything is successful
            
           
        } catch (\Exception $e) {
            // Roll back the transaction in case of an exception
            $results = [
                'code' => '102',
                'info'  => $e->getMessage(),
            ];

        }
        
        return $MasterClass->Results($results);
    
    }

}
