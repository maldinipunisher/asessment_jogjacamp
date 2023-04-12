<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CategoryController::class, 'index']);
Route::get('/{id}', [CategoryController::class, 'editIndex']);
Route::post('/{id}', [CategoryController::class, 'edit']);
Route::get('delete/{id}', [CategoryController::class, 'delete']);
Route::get('create', [CategoryController::class, 'createIndex']);
Route::post('create', [CategoryController::class, 'create']);
