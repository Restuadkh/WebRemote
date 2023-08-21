<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CpuController;
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
    Route::get('/cpu/{item}', [CpuController::class, 'show'])->name('cpu.show');
    Route::delete('/cpu/{item}', [CpuController::class, 'destroy'])->name('cpu.destroy');
});