<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\CpuController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::group(['middleware' => ['web']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
    Route::get('/home/get/{id}', [App\Http\Controllers\HomeController::class, 'get'])->name('home.get');
    Route::get('/CPU', [CpuController::class, 'index']);
    Route::get('/CPU/{id}', [CpuController::class, 'show'])->name('CPU.show');
    Route::get('/CPU/{id}/{core}', [CpuController::class, 'show'])->name('CPU.show');
    Route::post('/CPU', [CpuController::class, 'store'])->name('CPU.store');
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
// Route::get('/home/get/{id}', [App\Http\Controllers\HomeController::class, 'get'])->name('home.get');
Route::get('/cpu', [CpuController::class, 'index']);
Route::get('/cpu/{id}', [CpuController::class, 'show'])->name('CPU.show');
Route::post('/cpu', [CpuController::class, 'store'])->name('CPU.store'); 
Route::get('/db', [DatabaseController::class, 'index'])->name('db.index');
Route::get('/db/get', [DatabaseController::class, 'show'])->name('db.show');
Route::get('/db/create', [DatabaseController::class, 'create'])->name('db.create');
Route::post('/db', [DatabaseController::class, 'store'])->name('db.store');
Route::get('/db/test', [DatabaseController::class, 'test'])->name('db.test');
Route::get('/dbs/{id}', [DatabaseController::class, 'get'])->name('dbs.get');
Route::delete('/db/{id}', [DatabasController::class, 'destroy'])->name('db.destroy');

Route::get('/ram', [RamController::class, 'index'])->name('ram.index');
Route::get('/ram/get', [RamController::class, 'show'])->name('ram.show');
Route::get('/ram/create', [RamController::class, 'create'])->name('ram.create');
Route::post('/ram', [RamController::class, 'store'])->name('ram.store');
Route::get('/ram/test', [RamController::class, 'test'])->name('ram.test');
Route::get('/rams/{id}', [RamController::class, 'get'])->name('rams.get');
Route::delete('/ram/{id}', [RamController::class, 'destroy'])->name('ram.destroy');


Route::get('/memory', [MemoryController::class, 'index'])->name('memory.index');
Route::get('/memory/create', [MemoryController::class, 'create'])->name('memory.create');
Route::post('/memory', [MemoryController::class, 'store'])->name('memory.store');
Route::get('/memory/{id}', [MemoryControllerroller::class, 'show'])->name('memory.show');
Route::delete('/memory/{id}', [MemoryController::class, 'destroy'])->name('memory.destroy');