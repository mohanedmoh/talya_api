<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operations;

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
Route::post('/modify_payment', [Operations::class, 'modify_payment'])->name('modify_payment');
Route::post('/modify_owner', [Operations::class, 'modify_owner'])->name('modify_owner');
Route::post('/cancel_operation', [Operations::class, 'cancel_operation'])->name('cancel_operation');
Route::post('/payments', [Operations::class, 'get_total_payments'])->name('total_payment');
Route::post('/insert_operation', [Operations::class, 'insert_payment'])->name('operation_new');
Route::post('/insert_operation_cost', [Operations::class, 'insert_operation_cost'])->name('operation_cost_new');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

