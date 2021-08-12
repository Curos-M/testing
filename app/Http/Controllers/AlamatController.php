<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\KaderController;
use DB;

class AlamatController extends Controller
{
  public function regency()
  {
    $data = DB::table('_regencies')
    ->where('province_id', '15')
    ->get();
    
    return response()->json($data);
  }

  public function district(request $request)
  {
    $data = DB::table('_districts')
    ->where('regency_id', $request->regency_id)
    ->get();
    
    return response()->json($data);
  }

  public function village(Request $request)
  {
    $data = DB::table('_villages')
    ->where('district_id', $request->district_id)
    ->get();
    
    return response()->json($data);
  }
}
