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
    
		return $this->render('pencarian.index');
	}

  public function grid()
	{
		$data = Kader::where('kader.verif', '1')
    ->leftJoin('_regencies as r', 'kader.regencies_id', '=', 'r.id')
    ->leftJoin('_districts as d', 'kader.districts_id', '=', 'd.id')
    ->leftJoin('_villages as v', 'kader.villages_id', '=', 'v.id')
    ->leftJoin('jenjang as j', 'kader.jenjang_anggota', '=', 'j.id')
    ->leftJoin('kader as p', 'kader.id_pembina', '=', 'p.id')
    ->select([
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

		return datatables()->eloquent($data)->orderColumn('nama_lengkap', function($query, $order){
      $query->orderBy('nama_lengkap', $order);
    })->orderColumn('tggl_daftar', function($query, $order){
      $query->orderBy('created_at', $order);
    })->toJson();
	}
}
