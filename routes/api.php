<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClientController;
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

    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients/add', [ClientController::class, 'store']);
    Route::get('clients/search/{lastName}', [ClientController::class, 'search']);
    Route::get('clients/get/{id}', [ClientController::class, 'show']);
