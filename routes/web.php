<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JsonDataController;
use App\Models\MenusAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenerateController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk melakukan proses login
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/sign-up', [AuthController::class, 'signup'])->name('sign-up')->middleware('guest');
Route::post('/createaccount', [AuthController::class, 'createaccount'])->name('createaccount');

Route::get('/generateview', [GenerateController::class, 'generateview']);
Route::get('/gendataview', [GenerateController::class, 'gendataview']);

Route::middleware(['auth'])->group(function () { // harus login terlebih dahulu

    Route::get('/', [GeneralController::class, 'dashboard'])->name('/');
    Route::post('getlimitpinjaman', [JsonDataController::class, 'getlimitpinjaman'])->name('getlimitpinjaman');
    Route::post('actionpengajuanpinjaman', [JsonDataController::class, 'actionpengajuanpinjaman'])->name('actionpengajuanpinjaman');

    Route::middleware(['role:Superadmin'])->group(function () {
        Route::post('/generate', [GenerateController::class, 'generate'])->name('generate');
    });

    if(Session::get('menu')){
        $allowedRoutes = Session::get('menu');
    }else{
       Session::put('menu', MenusAccess::all());
       $allowedRoutes = Session::get('menu');
    //    dd($allowedRoutes);
    }
   
    if($allowedRoutes) {
        foreach ($allowedRoutes as $routeData) {
            // Route::middleware(['role:' . $routeData->role])->group(function () use ($routeData) {
                // Anda dapat menggunakan $routeData->id untuk mengidentifikasi setiap entri secara unik
                if ($routeData->param_type == "VIEW"){
                    Route::get($routeData->url, [GeneralController::class, $routeData->method])->name($routeData->name);
                }else{
                    Route::post($routeData->url, [JsonDataController::class, $routeData->method])->name($routeData->name);
                }
            // });
        }
    }
});