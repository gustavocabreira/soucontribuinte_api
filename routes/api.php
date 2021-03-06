<?php

use App\Http\Controllers\Api\EntidadeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->name('entidades.')->group(function() {
    Route::prefix('entidades')->group(function() {
        Route::get('uf', [EntidadeController::class, 'getUf'])->name('getUf');
        Route::get('', [EntidadeController::class, 'index'])->name('index');
    });
});

Route::post('register', [UserController::class, 'register'])->name('users.create');
Route::post('login', [UserController::class, 'login'])->name('users.login');

