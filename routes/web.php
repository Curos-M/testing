<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\AlamatController;

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

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('login', [AuthController::class, 'postLogin']);

Route::group(['middleware' => 'auth'], function() {
  Route::get('/', function () {
      return view('welcome');
  });

  Route::get('/user',  [UserController::class, 'index']);	
	Route::get('/user/edit/{id?}',  [UserController::class, 'edit']);	
	Route::get('/user/grid',  [UserController::class, 'grid']);	
	Route::post('/user',  [UserController::class, 'save']);
	Route::delete('/user/{id}',  [UserController::class, 'delete']);	

  Route::get('/kader',  [KaderController::class, 'index']);	
	Route::get('/kader/edit/{id?}',  [KaderController::class, 'edit']);	
	Route::get('/kader/grid',  [KaderController::class, 'grid']);	
	Route::post('/kader',  [KaderController::class, 'save']);
	Route::delete('/kader/{id}',  [KaderController::class, 'delete']);
  
  Route::get('/regency',  [AlamatController::class, 'regency']);
  Route::get('/district',  [AlamatController::class, 'district']);	
  Route::get('/village',  [AlamatController::class, 'village']);
});
