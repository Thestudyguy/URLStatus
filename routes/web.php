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
Route::get('get-url', [URLController::class, 'getURL']);
Route::get('list-url', [URLController::class, 'listURL']);
Route::get('scan-url', [URLController::class, 'GetURLHeaders']);
Route::post('search-url', [URLController::class,'search']);
Route::post('remove-url', [URLController::class,'removeUrlfromList']);
Route::post('filter-url', [URLController::class,'FilterStatus']);
Route::post('get-status', [URLController::class,'getStatus']);
Route::get('send-email', [URLController::class,'sendMonthlyReport']);
Route::get('test-table', [URLController::class, 'getStatusandPIS']);
Route::post('store-data', [URLController::class, 'storeEmailandURL']);
Route::post('get-email/{id}', [URLController::class, 'getEmail']);
Route::get('register', [URLController::class, 'register']);
Route::post('register-user', [URLController::class, 'RegisterUser'])->name('registeruser');
//});
Route::get('/pages/client', function () {
    return view('pages.client');
})->name('clients');
Route::get('/', [URLController::class, 'GetClients']);
Route::get('/clients', [URLController::class, 'GetClients']);
Route::get('/clients', [NewClientController::class, 'GetClients']);
Route::post('save-new', [NewClientController::class, 'SaveNewClient']);