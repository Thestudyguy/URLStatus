<?php

use App\Http\Controllers\NewClientController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\URLController;
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
//Route::middleware('isUserPrivileged')->group(function(){
Route::get('/', [NewClientController::class, 'default']);
Route::get('/clients', [NewClientController::class, 'GetClients']);
Route::post('save-new', [NewClientController::class, 'SaveNewClient']);