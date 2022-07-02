<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Illuminate\Support\Facades\Auth;
use DB;

class AlamatController extends Controller
{
  public function regency()
  {
    Auth::user() == null 
    ? $user = null
    : $user = Kader::find(Auth::user()->anggota_id);
    if($user != null){
      if(Auth::user()->can('filter-kota/kabupaten') || Auth::user()->can('filter-kecamatan') || Auth::user()->can('filter-desa/kelurahan')){
        $value = $user->regencies_id;
        $rowName = 'id';
      }else{
        $value = '15';
        $rowName = 'province_id';
      }
    }else{
      $value = '15';
      $rowName = 'province_id';
    }

    $data = DB::table('_regencies')
    ->where($rowName, $value)
    ->get();
    
    return response()->json($data);
  }

  public function district(request $request)
  {
    Auth::user() == null
    ? $user = null
    : $user = Kader::find(Auth::user()->anggota_id);
    if($user != null){
      if(Auth::user()->can('filter-kecamatan') || Auth::user()->can('filter-desa/kelurahan')){
        $value = $user->districts_id;
        $rowName = 'id';
      }elseif(Auth::user()->can('filter-kota/kabupaten')){
        $value = $user->regencies_id;
        $rowName = 'regency_id';
      }else{
        $value = $request->regency_id;
        $rowName = 'regency_id';
      }
    }else{
      $value = $request->regency_id;
      $rowName = 'regency_id';
    }

    $data = DB::table('_districts')
    ->where($rowName, $value)
    ->get();
    
    return response()->json($data);
  }

  public function village(Request $request)
  {
    Auth::user() == null 
    ? $user = null
    : $user = Kader::find(Auth::user()->anggota_id);
    if($user != null){
      if(Auth::user()->can('filter-desa/kelurahan')){
        $value = $user->villages_id;
        $rowName = 'id';
      }elseif(Auth::user()->can('filter-kecamatan')){
        $value = $user->districts_id;
        $rowName = 'district_id';
      }else{
        $value = $request->district_id;
        $rowName = 'district_id';
      }
    }else{
      $value = $request->district_id;
      $rowName = 'district_id';
    }

    $data = DB::table('_villages')
    ->where($rowName, $value)
    ->get();
    
    return response()->json($data);
  }
}
