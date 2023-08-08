<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CpuController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('Dashboard', [DashboardController::class, 'index']);

// Route::get('Dashboard', 
//     function(){
//         return view('Dashboard');
//     }
// );
Route::group(['middleware' => ['web']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
    Route::get('/home/get/{id}', [App\Http\Controllers\HomeController::class, 'get'])->name('home.get');
    Route::get('/cpu', [CpuController::class, 'index']);
    Route::get('/cpu/{id}', [CpuController::class, 'show'])->name('CPU.show');
    Route::post('/cpu', [CpuController::class, 'store'])->name('CPU.store');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
// Route::get('/home/get/{id}', [App\Http\Controllers\HomeController::class, 'get'])->name('home.get');
// Route::get('/cpu', [CpuController::class, 'index']);
// Route::get('/cpu/{id}', [CpuController::class, 'show'])->name('CPU.show');
// Route::post('/cpu', [CpuController::class, 'store'])->name('CPU.store');
