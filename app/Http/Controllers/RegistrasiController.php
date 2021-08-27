<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use App\Libs\Helpers;
use Illuminate\Support\Facades\DB;

class RegistrasiController extends Controller
{
    public function index()
    {
      if(env('APP_OPENREG')){
        return view('registration.index') ;
      }else{
        return view('errors.403') ;
      }     
    }

    public function save(Request $request)
    {
      $request->validate([
        'nik' => 'nullable|unique:kader,nik',
        'nama_lengkap' => 'required',
        'nama_panggilan' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'pendidikan' => 'required',
        'alamat' => 'required',
        'regencies_id' => 'required',
        'districts_id' => 'required',
        'villages_id' => 'required',
        'telp' => 'required|unique:kader,telp',
        'job' => 'required',
        'darah' => 'required',
      ]);
      
      try{
        DB::beginTransaction();
        if($request->file){
          $file = Helpers::prepareFile($request->all(), '/images/anggota');
        }
  
        if($request->file1){
          $file1 = Helpers::prepareFile1($request->all(), '/images/ktp');
        }
        
        $user = Kader::create([
          'photo' => $file->newName??null,
          'nik' => $request->nik,
          'nama_lengkap' => $request->nama_lengkap,
          'nama_panggilan' => $request->nama_panggilan,
          'tempat_lahir' => $request->tempat_lahir,
          'tanggal_lahir' => $request->tanggal_lahir,
          'jenis_kelamin' => $request->jenis_kelamin,
          'pendidikan' => $request->pendidikan,
          'alamat' => $request->alamat,
          'regencies_id' => $request->regencies_id,
          'districts_id' => $request->districts_id,
          'villages_id' => $request->villages_id,
          'telp' => $request->telp,
          'job' => $request->job,
          'awal_anggota' => now()->toDateString(),
          'usia_jenjang' => now()->toDateString(),
          'pembina' => '0',
          'status_pernikahan' => 'Belum Kawin',
          'jenjang_anggota' => "1",
          'darah' => $request->darah,
          'ktp' => $file1->newName??null,
          'verif' => '0',
          'created_by' => '0'
        ]);
        $status = 'Berhasil menambah anggota baru.';

        DB::commit();
      }catch(\exception $e){
        DB::rollback();
        dd($e);
      }
      
  
      return view('registration.done');
    }
}
