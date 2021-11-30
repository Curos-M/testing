<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PencarianController extends Controller
{
  function __construct()
	{
		$this->setTitle("Pencarian");
		$this->setUrl("pencarian");
	}

  public function index()
	{
		$this->setBreadcrumb(['Pencarian' => '#']);
    $jenjang = DB::table('jenjang')->get();
		return $this->render('pencarian.index', ['jenjang' => $jenjang]);
	}

  public function grid(Request $request)
	{
    $user = Kader::find(Auth::user()->anggota_id);
		$kader = Kader::where('kader.verif', '1')
    ->leftJoin('_regencies as r', 'kader.regencies_id', '=', 'r.id')
    ->leftJoin('_districts as d', 'kader.districts_id', '=', 'd.id')
    ->leftJoin('_villages as v', 'kader.villages_id', '=', 'v.id')
    ->leftJoin('jenjang as j', 'kader.jenjang_anggota', '=', 'j.id')
    ->leftJoin('kelompok as k', 'kader.id_kelompok', '=', 'k.id')
    ->leftJoin('kader as p', 'k.id_pembina', '=', 'p.id')
    ->when($request->search, function($query) use($request){
      if($request->type == 1)
        $query->where(DB::raw("lower(kader.nama_lengkap)"), "like", DB::raw("lower('%".$request->search."%')"));
      if($request->type == 2)
        $query->where(DB::raw("lower(kader.nomor_urut)"), "like", DB::raw("lower('%".$request->search."%')"));
      if($request->type == 3)
        $query->where(DB::raw("lower(kader.nik)"), "like", DB::raw("lower('%".$request->search."%')"));
    })->when($request->darah, function($query, $value){
      $query->where('kader.darah', $value);
    })->when($request->jenjang, function($query, $value){
      $query->where('kader.jenjang_anggota', $value);
    })->when($request->kota, function($query, $value){
      $query->where('kader.regencies_id', $value);
    })->when($request->kecamatan, function($query, $value){
      $query->where('kader.districts_id', $value);
    })->when($request->desa, function($query, $value){
      $query->where('kader.villages_id', $value);
    })->when($request->pembina, function($query, $value){
      $query->where('k.id_pembina', $value);
    })->when($request->umur, function($query, $value){
      switch($value){
        case 1:
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) < '20'");
          break;
        case 2:
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '20' and date_part('year', age(now() , kader.tanggal_lahir)) < '30'");
          break;
        case 3: 
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '30' and date_part('year', age(now() , kader.tanggal_lahir)) < '40'");
          break;
        case 4:
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '40' and date_part('year', age(now() , kader.tanggal_lahir)) < '50'");
          break;
        case 5:
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '50' and date_part('year', age(now() , kader.tanggal_lahir)) < '60'");
          break;
        case 6:
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '60' and date_part('year', age(now() , kader.tanggal_lahir)) < '70'");
          break;
        case 7:
          $query->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '70'");
          break;    
      }
    })->when(Auth::user()->can('filter-kota/kabupaten'), function($query) use($user){
      return $query->where('kader.regencies_id', $user->regencies_id);
    })->when(Auth::user()->can('filter-kecamatan'), function($query) use($user){
      return $query->where('kader.districts_id', $user->districts_id);
    })->when(Auth::user()->can('filter-desa/kelurahan'), function($query) use($user){
      return $query->where('kader.villages_id', $user->villages_id);
    });
    
    $data = $kader->select([
      'kader.id',
      'kader.photo',
      'kader.nomor_urut',
      'kader.nama_lengkap',
      'kader.telp',
      'kader.nik',
      'kader.tempat_lahir',
      DB::raw("date_part('year', age(now() , kader.tanggal_lahir))||' Tahun' as usia"),
      DB::raw("kader.tempat_lahir||', '||to_char(kader.tanggal_lahir, 'dd-mm-yyyy') as tempat_tanggal_lahir"),
      'kader.alamat',
      'v.name as village_name',
      'd.name as districts_name',
      'r.name as regencies_name',
      DB::raw("case when kader.jenis_kelamin is true then 'Laki-Laki' else 'Perempuan' end as jenis_kelamin"),
      'j.nama as nama_jenjang',
      'kader.usia_jenjang',
      DB::raw("date_part('year', age(now() , kader.usia_jenjang))||' Tahun - '|| date_part('month', age(now() , kader.usia_jenjang))|| ' Bulan' as usia_jenjang_raw"),
      'kader.darah',
      DB::raw("CASE WHEN p.nama_lengkap is not null THEN p.nama_lengkap WHEN kader.nama_pembina is not null THEN kader.nama_pembina ELSE '-' END as nama_pembina"),
      'k.nama_kelompok',
      'kader.job',
      'kader.pendidikan'
    ]);

		return datatables()->of($data)->toJson();
	}

  public function pembina(Request $request)
	{
		$data = Kader::whereRaw("lower(nama_lengkap) LIKE lower('%". $request->search ."%')")
    ->where('pembina', '1')->where('verif', '1')->take(5)->get();
		return response()->json($data);
	}
}
