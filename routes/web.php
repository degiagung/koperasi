<?php

use App\Models\data_access;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\JsondataController ;
use Illuminate\Support\Facades\Route;


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

// VIEW / HALAMAN
    Route::get('/', function () {
        return view('pages.landingpage.guest');
    })->name('guest');
    Route::get('/kostan', function () {
        return view('pages.landingpage.kostan');
    })->name('kostan');
    Route::get('/contact', function () {
        return view('pages.landingpage.layouts');
    })->name('contact');
    Route::get('/booking', function () {
        return view('pages.landingpage.booking');
    })->name('booking');
    
    Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
    // Route::middleware(['auth'])->group(function () {
    // Route::get('/based', [ViewController::class, 'based']);

    // Route::middleware(['role:Superadmin'])->group(function () {
    //     Route::post('/generate', [GenerateController::class, 'generate'])->name('generate');
    // });
    
    $allowedRoutes = data_access::all();
    foreach ($allowedRoutes as $routeData) {
        
        $class  = $routeData->class ; 
        $url    = '/'.$class ; 
        Route::get($url, [ViewController::class, $class])->name($class);
        // ->middleware('auth');
    }

// });

// ACTION / CONTROLL
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/store', [RegisterController::class, 'store'])->name('store');
    Route::post('/getlistuser', [JsonDataController::class, 'getlistuser'])->name('getlistuser');
    Route::post('/getlistpenghuni', [JsonDataController::class, 'getlistpenghuni'])->name('getlistpenghuni');
    Route::post('/getlistkamar', [JsonDataController::class, 'getlistkamar'])->name('getlistkamar');
    Route::post('/getlisttransaksi', [JsonDataController::class, 'getlisttransaksi'])->name('getlisttransaksi');
    Route::post('/getlistmenu', [JsonDataController::class, 'getlistmenu'])->name('getlistmenu');
    Route::post('/getrole', [JsonDataController::class, 'getrole'])->name('getrole');
    Route::post('/saveUser', [JsonDataController::class, 'saveUser'])->name('saveUser');
    Route::post('/saveMenu', [JsonDataController::class, 'saveMenu'])->name('saveMenu');
    Route::post('/changestatususer', [JsonDataController::class, 'changestatususer'])->name('changestatususer');
    Route::post('/deleteMenu', [JsonDataController::class, 'deleteMenu'])->name('deleteMenu');

