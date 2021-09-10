<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Illuminate\Support\Facades\DB;

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
		$kader = Kader::where('kader.verif', '1')
    ->leftJoin('_regencies as r', 'kader.regencies_id', '=', 'r.id')
    ->leftJoin('_districts as d', 'kader.districts_id', '=', 'd.id')
    ->leftJoin('_villages as v', 'kader.villages_id', '=', 'v.id')
    ->leftJoin('jenjang as j', 'kader.jenjang_anggota', '=', 'j.id')
    ->leftJoin('kader as p', 'kader.id_pembina', '=', 'p.id');
    if($request->search){
      if($request->type == 1)
        $kader->where(DB::raw("lower(kader.nama_lengkap)"), "like", DB::raw("lower('%".$request->search."%')"));
      if($request->type == 2)
        $kader->where(DB::raw("lower(kader.nomor_urut)"), "like", DB::raw("lower('%".$request->search."%')"));
      if($request->type == 3)
        $kader->where(DB::raw("lower(kader.nik)"), "like", DB::raw("lower('%".$request->search."%')"));
    }
    if($request->darah){
      $kader->where('kader.darah', $request->darah);
    }
    if($request->jenjang){
      $kader->where('kader.jenjang_anggota', $request->jenjang);
    }
    if($request->kota){
      $kader->where('kader.regencies_id', $request->kota);
    }
    if($request->kecamatan){
      $kader->where('kader.districts_id', $request->kecamatan);
    }
    if($request->desa){
      $kader->where('kader.villages_id', $request->desa);
    }
    if($request->pembina){
      $kader->where('kader.id_pembina', $request->pembina);
    }
    switch($request->umur){
      case 1:
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) < '20'");
        break;
      case 2:
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '20' and date_part('year', age(now() , kader.tanggal_lahir)) < '30'");
        break;
      case 3: 
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '30' and date_part('year', age(now() , kader.tanggal_lahir)) < '40'");
        break;
      case 4:
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '40' and date_part('year', age(now() , kader.tanggal_lahir)) < '50'");
        break;
      case 5:
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '50' and date_part('year', age(now() , kader.tanggal_lahir)) < '60'");
        break;
      case 6:
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '60' and date_part('year', age(now() , kader.tanggal_lahir)) < '70'");
        break;
      case 7:
        $kader->whereRaw("date_part('year', age(now() , kader.tanggal_lahir)) >= '70'");
        break;    
    }
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
      'kader.job',
      'kader.pendidikan'
    ]);

		return datatables()->of($data)->toJson();
	}
}
