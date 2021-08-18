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
        $file = null;
        $file1 = null;
        if($request->file){
          $file = Helpers::prepareFile($request->all(), '/images/anggota');
        }
  
        if($request->file1){
          $file1 = Helpers::prepareFile1($request->all(), '/images/ktp');
        }

  
        $prefix = DB::table('_regencies')
        ->where('province_id', '15')
        ->where('id', $request->regencies_id)
        ->select(["id", DB::Raw("
        Case WHEN id = '1501' THEN 'KRC'
          WHEN id = '1572' THEN 'SPN'
          ELSE 'NaN' END as prefix
        ")])
        ->first();
        
        $latest = DB::table('kader')->where('regencies_id', $request->regencies_id)->count();
        $no = $prefix->prefix . (str_pad((int)$latest + 1, 5, '0', STR_PAD_LEFT));
        
          $user = Kader::create([
            'nomor_urut' => $no,
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
            'jenjang_anggota' => "Pemula",
            'darah' => $request->darah,
            'ktp' => $file1->newName??null,
            'verif' => '0',
            'created_by' => '0'
          ]);
          $status = 'Berhasil menambah anggota baru.';

        $request->session()->flash('success', $status);
        DB::commit();
      }catch(\exception $e){
        DB::rollback();
        dd($e);
      }
      
  
      return view('registration.done');
    }
}
