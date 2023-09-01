<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CpuController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\RamController;
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
    
    Route::get('/ram', [RamController::class, 'index'])->name('ram.index');
    Route::get('/ram/create', [RamController::class, 'create'])->name('ram.create');
    Route::post('/ram', [RamController::class, 'store'])->name('ram.store');
    Route::get('/ram/{id}', [RamControllerroller::class, 'show'])->name('ram.show');
    Route::delete('/ram/{id}', [RamController::class, 'destroy'])->name('ram.destroy');
});
