<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\RoleController;

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

  Route::get('/user',  [UserController::class, 'index'])->middleware('can:user-view');	
	Route::get('/user/edit/{id?}',  [UserController::class, 'edit'])->middleware('can:user-view');	
	Route::get('/user/grid',  [UserController::class, 'grid'])->middleware('can:user-view');	
	Route::post('/user',  [UserController::class, 'save']);
	Route::delete('/user/{id}',  [UserController::class, 'delete'])->middleware('can:user-delete');	

  Route::get('/kader',  [KaderController::class, 'index'])->middleware('can:kader-view');	
	Route::get('/kader/edit/{id?}',  [KaderController::class, 'edit'])->middleware('can:kader-view');	
	Route::get('/kader/grid',  [KaderController::class, 'grid'])->middleware('can:kader-view');	
	Route::post('/kader',  [KaderController::class, 'save']);
  Route::get('/pasangan',  [KaderController::class, 'pasangan']);
  Route::get('/pembina',  [KaderController::class, 'pembina']);
  Route::get('/pembina/grid/{id}',  [KaderController::class, 'gridBinaan']);
  Route::get('/anak/grid/{id}',  [KaderController::class, 'gridAnak']);
  Route::post('/anak',  [KaderController::class, 'saveAnak']);
	Route::delete('/kader/{id}',  [KaderController::class, 'delete'])->middleware('can:kader-delete');
  Route::delete('/anak/{id}',  [KaderController::class, 'deleteAnak']);

  Route::get('/role', [RoleController::class, 'index'])->middleware('can:role-view');
	Route::get('/role/edit/{id?}', [RoleController::class, 'edit'])->middleware('can:role-view');
	Route::get('/role/grid', [RoleController::class, 'grid'])->middleware('can:role-view');
	Route::post('/role', [RoleController::class, 'save']);
	Route::delete('/role/{id}',  [RoleController::class, 'delete'])->middleware('can:role-delete');
  
  Route::get('/regency',  [AlamatController::class, 'regency']);
  Route::get('/district',  [AlamatController::class, 'district']);	
  Route::get('/village',  [AlamatController::class, 'village']);
});
