<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Illuminate\Support\Facades\DB;
use App\Libs\Helpers;
use Illuminate\Support\Facades\Auth;

class VerifController extends Controller
{
	function __construct()
	{
		$this->setTitle("Verifikasi");
		$this->setUrl("verifikasi");
	}

  public function index()
	{
		$this->setBreadcrumb(['Verifikasi' => '#']);
		return $this->render('verif.index');
	}

  public function grid()
	{
		$data = Kader::where('verif', '0')->select([
      'id',
      'nama_lengkap',
      'telp',
      'nik',
      DB::raw("to_char(created_at, 'dd-mm-yyyy hh24:mi:ss') as tggl_daftar"),
      'created_at'
    ]);

		return datatables()->eloquent($data)->orderColumn('nama_lengkap', function($query, $order){
      $query->orderBy('nama_lengkap', $order);
    })->orderColumn('tggl_daftar', function($query, $order){
      $query->orderBy('created_at', $order);
    })->toJson();
	}

  public function verif($id){

    $data =	Kader::find($id);

    $prefix = Helpers::prefix($data);
    $latest = DB::table('kader')->where('regencies_id', $data->regencies_id)->whereNotNull('nomor_urut')->count();
    $no = $prefix->prefix . (str_pad((int)$latest + 1, 5, '0', STR_PAD_LEFT));

    if($data->nik){
      $data->update([
        'nomor_urut' => $no,
        'verif' => '1',
        'verif_by' => Auth::user()->getAuthIdentifier(),
        'verif_at' => now()->toDateTimeString(),
      ]);
      $results = array(
          'status' => 'success',
          'action' => 'Verifikasi',
          'messages' => 'Anggota berhasil Diverifikasi'
        );
    }else{
      $results = array(
        'status' => 'error',
        'action' => 'Verifikasi',
        'messages' => 'Verifikasi Gagal, NIK tidak boleh kosong'
      );
    }
    return response()->json($results);
  }

  public function view($id)
	{
		$data = Kader::where('kader.id', $id)
    ->leftJoin('_regencies as r', 'regencies_id', '=', 'r.id')
    ->leftJoin('_districts as d', 'districts_id', '=', 'd.id')
    ->leftJoin('_villages as v', 'villages_id', '=', 'v.id')
    ->select([
      'kader.id',
      'nik',
      'nama_lengkap',
      'nama_panggilan',
      'tempat_lahir',
      DB::raw("to_char(tanggal_lahir, 'dd-mm-yyyy') as tanggal_lahir_raw"),
      DB::raw("CASE WHEN jenis_kelamin is true THEN 'Laki-Laki' ELSE 'Perempuan' END as jenis_kelamin_raw"),
      'pendidikan',
      'alamat',
      'r.name as regencies_name',
      'd.name as districts_name',
      'v.name as villages_name',
      'telp',
      'job',
      'darah',
      'photo',
      'ktp',
      DB::raw("CASE WHEN rekomendasi is null THEN '-' ELSE rekomendasi END as rekomendasi")
    ])
    ->first();

		return response()->json($data);
	}
}
