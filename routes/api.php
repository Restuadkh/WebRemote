<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CpuController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\ErrorApacheController;
use App\Http\Controllers\LogApacheController;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\TemperatureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    // Route::resource('items', 'ItemController');
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    Route::get('/cpu', [CpuController::class, 'index'])->name('cpu.index');
    Route::get('/cpu/create', [CpuController::class, 'create'])->name('cpu.create');
    Route::post('/cpu', [CpuController::class, 'store'])->name('cpu.store');
    Route::get('/cpu/{id}', [CpuController::class, 'show'])->name('cpu.show');
    Route::delete('/cpu/{id}', [CpuController::class, 'destroy'])->name('cpu.destroy');

    Route::get('/db', [DatabaseController::class, 'index'])->name('db.index');
    Route::get('/db/create', [DatabaseController::class, 'create'])->name('db.create');
    Route::post('/db', [DatabaseController::class, 'store'])->name('db.store');
    Route::get('/db/{id}', [DatabaseController::class, 'show'])->name('db.show');
    Route::delete('/db/{id}', [DatabaseController::class, 'destroy'])->name('db.destroy');
    Route::get('/db/proseslist', [DatabaseController::class, 'showProcessList'])->name('db.showProcessList'); 
    Route::get('/db/getproseslist', [DatabaseController::class, 'getProcessList'])->name('db.getproseslist'); 
    
    Route::get('/ram', [RamController::class, 'index'])->name('ram.index');
    Route::get('/ram/create', [RamController::class, 'create'])->name('ram.create');
    Route::post('/ram', [RamController::class, 'store'])->name('ram.store');
    Route::get('/ram/{id}', [RamControllerroller::class, 'show'])->name('ram.show');
    Route::delete('/ram/{id}', [RamController::class, 'destroy'])->name('ram.destroy');

    
    Route::get('/memory', [MemoryController::class, 'index'])->name('memory.index');
    Route::get('/memory/create', [MemoryController::class, 'create'])->name('memory.create');
    Route::post('/memory', [MemoryController::class, 'store'])->name('memory.store');
    Route::get('/memory/{id}', [MemoryController::class, 'show'])->name('memory.show');
    Route::delete('/memory/{id}', [MemoryController::class, 'destroy'])->name('memory.destroy');
    
    Route::get('/errorapache', [ErrorApacheController::class, 'index'])->name('errorapache.index');
    Route::get('/errorapache/create', [ErrorApacheController::class, 'create'])->name('errorapache.create');
    Route::post('/errorapache', [ErrorApacheController::class, 'store'])->name('errorapache.store');
    Route::get('/errorapache/{id}', [ErrorApacheController::class, 'show'])->name('errorapache.show');
    Route::delete('/errorapache/{id}', [ErrorApacheController::class, 'destroy'])->name('errorapache.destroy');
    
    Route::get('/temp', [TemperatureController::class, 'index'])->name('temp.index');
    Route::get('/temp/create', [TemperatureController::class, 'create'])->name('temp.create');
    Route::post('/temp', [TemperatureController::class, 'store'])->name('temp.store');
    Route::get('/temp/{id}', [TemperatureController::class, 'show'])->name('temp.show');
    Route::delete('/temp/{id}', [TemperatureController::class, 'destroy'])->name('temp.destroy');
});
