<?php

use App\Http\Controllers\Api\MessageController;
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

Route::post('/messages/createBulk', [MessageController::class, 'createBulk']);
Route::post('/messages/create', [MessageController::class, 'create']);
Route::get('/messages/read', [MessageController::class, 'read']);
Route::get('/messages/list', [MessageController::class, 'list']);
