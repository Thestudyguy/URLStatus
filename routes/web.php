<?php

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

Route::get('/', [URLController::class, 'getURL']);
Route::get('list-url', [URLController::class, 'listURL']);
Route::get('scan-url', [URLController::class, 'GetURLHeaders']);
Route::post('search-url', [URLController::class,'search']);
Route::post('remove-url', [URLController::class,'removeUrlfromList']);
Route::post('filter-url', [URLController::class,'FilterStatus']);
Route::post('get-status', [URLController::class,'getStatus']);
Route::get('send-email', [URLController::class,'sendMonthlyReport']);
Route::get('test-method', [URLController::class,'SendEmailWhenAURLinURLCSTableSuddenlyBecome400or500ToNotifySirRuinzeAboutTheMatterAndItsShouldBeCheckingEveryDayLoL']);