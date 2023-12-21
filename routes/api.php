<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompanyController;

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

Route::prefix('v1/companies')->group(function () {
    Route::get('/',[CompanyController::class, 'get']);
});

Route::prefix('v1/tasks')->group(function () {
    Route::get('/',[TaskController::class, 'get']);
    Route::post('/create',[TaskController::class, 'create']);
});