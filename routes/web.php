<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerifController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\PencarianController;
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
  Route::get('/',  [DashboardController::class, 'index']);	
  Route::post('/grid',  [DashboardController::class, 'grid']);	

  Route::get('/user',  [UserController::class, 'index'])->middleware('can:user-view');	
	Route::get('/user/edit/{id?}',  [UserController::class, 'edit'])->middleware('can:user-view');	
	Route::get('/user/grid',  [UserController::class, 'grid'])->middleware('can:user-view');	
	Route::post('/user',  [UserController::class, 'save']);
	Route::delete('/user/{id}',  [UserController::class, 'delete'])->middleware('can:user-delete');	

  Route::get('/anggota',  [KaderController::class, 'index'])->middleware('can:anggota-view');	
	Route::get('/anggota/edit/{id?}',  [KaderController::class, 'edit'])->middleware('can:anggota-view');	
	Route::get('/anggota/grid',  [KaderController::class, 'grid'])->middleware('can:anggota-view');	
  Route::get('/search/anak',  [KaderController::class, 'searchAnak']);
	Route::post('/anggota',  [KaderController::class, 'save']);
  Route::post('/anggota/verif/{id}',  [KaderController::class, 'verif']);
  Route::get('/pasangan',  [KaderController::class, 'pasangan']);
  Route::get('/anak/grid/{id}',  [KaderController::class, 'gridAnak']);
  Route::post('/anak/{id}',  [KaderController::class, 'getAnak']);
  Route::post('/anak',  [KaderController::class, 'saveAnak']);
	Route::delete('/anggota/{id}',  [KaderController::class, 'delete'])->middleware('can:anggota-delete');
  Route::delete('/anggota/anak/{id}',  [KaderController::class, 'deleteAnakKader']);
  Route::delete('/anak/{id}',  [KaderController::class, 'deleteAnak']);

  Route::get('/role', [RoleController::class, 'index'])->middleware('can:role-view');
	Route::get('/role/edit/{id?}', [RoleController::class, 'edit'])->middleware('can:role-view');
	Route::get('/role/grid', [RoleController::class, 'grid'])->middleware('can:role-view');
	Route::post('/role', [RoleController::class, 'save']);
	Route::delete('/role/{id}',  [RoleController::class, 'delete'])->middleware('can:role-delete');

  Route::get('/verifikasi',  [VerifController::class, 'index']);	
  Route::post('/verifikasi/{id}',  [VerifController::class, 'verif']);	
  Route::get('/verifikasi/grid',  [VerifController::class, 'grid']);	
  Route::post('/verifikasi/view/{id}',  [VerifController::class, 'view']);	

  Route::get('/kelompok',  [KelompokController::class, 'index']);
  Route::get('/kelompok/grid',  [KelompokController::class, 'grid']);
  Route::get('/kelompok/edit/{id}',  [KelompokController::class, 'edit']);
  Route::get('/kelompok/catatan/{id}',  [KelompokController::class, 'editNote']);
  Route::post('/kelompok/view/{id}',  [KelompokController::class, 'lihat']);
  Route::post('/kelompok',  [KelompokController::class, 'save']);
  Route::post('/binaan',  [KelompokController::class, 'searchBinaan']);
  Route::delete('/kelompok/{id}',  [KelompokController::class, 'delete']);
  Route::post('/kelompok/edit/anggota/{id}',  [KelompokController::class, 'addAnggota']);
  Route::delete('/kelompok/edit/anggota/{id}',  [KelompokController::class, 'deleteAnggota']);

  Route::get('/pencarian',  [PencarianController::class, 'index']);
  Route::get('/pencarian/grid',  [PencarianController::class, 'grid']);
  Route::get('/pembina',  [PencarianController::class, 'pembina']);
  
});
