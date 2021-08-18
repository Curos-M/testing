<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegistrasiController;

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

Route::get('/registrasi',  [RegistrasiController::class, 'index']);
Route::post('/registrasi',  [RegistrasiController::class, 'save']);

Route::get('/regency',  [AlamatController::class, 'regency']);
Route::get('/district',  [AlamatController::class, 'district']);	
Route::get('/village',  [AlamatController::class, 'village']);

Route::group(['middleware' => 'auth'], function() {
  Route::get('/', function () {
      return view('welcome');
  });

  Route::get('/user',  [UserController::class, 'index'])->middleware('can:user-view');	
	Route::get('/user/edit/{id?}',  [UserController::class, 'edit'])->middleware('can:user-view');	
	Route::get('/user/grid',  [UserController::class, 'grid'])->middleware('can:user-view');	
	Route::post('/user',  [UserController::class, 'save']);
	Route::delete('/user/{id}',  [UserController::class, 'delete'])->middleware('can:user-delete');	

  Route::get('/anggota',  [KaderController::class, 'index'])->middleware('can:anggota-view');	
	Route::get('/anggota/edit/{id?}',  [KaderController::class, 'edit'])->middleware('can:anggota-view');	
	Route::get('/anggota/grid',  [KaderController::class, 'grid'])->middleware('can:anggota-view');	
	Route::post('/anggota',  [KaderController::class, 'save']);
  Route::get('/pasangan',  [KaderController::class, 'pasangan']);
  Route::get('/pembina',  [KaderController::class, 'pembina']);
  Route::get('/pembina/grid/{id}',  [KaderController::class, 'gridBinaan']);
  Route::get('/anak/grid/{id}',  [KaderController::class, 'gridAnak']);
  Route::post('/anak',  [KaderController::class, 'saveAnak']);
	Route::delete('/anggota/{id}',  [KaderController::class, 'delete'])->middleware('can:anggota-delete');
  Route::delete('/anak/{id}',  [KaderController::class, 'deleteAnak']);

  Route::get('/role', [RoleController::class, 'index'])->middleware('can:role-view');
	Route::get('/role/edit/{id?}', [RoleController::class, 'edit'])->middleware('can:role-view');
	Route::get('/role/grid', [RoleController::class, 'grid'])->middleware('can:role-view');
	Route::post('/role', [RoleController::class, 'save']);
	Route::delete('/role/{id}',  [RoleController::class, 'delete'])->middleware('can:role-delete');
  
});
