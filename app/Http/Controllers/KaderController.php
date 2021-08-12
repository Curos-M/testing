<?php

namespace App\Http\Controllers;

use App\Models\Kader;

use Illuminate\Http\Request;
use DB;
use Validation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class KaderController extends Controller
{
	function __construct()
	{
		$this->setTitle("Kader");
		$this->setUrl("kader");
	}

	private function __db()
	{
		$data = new \StdClass();
		$data->id = null;
		$data->photo = null;
		$data->nama_lengkap = null;
		$data->nama_panggilan = null;
    $data->tempat_lahir = null;
    $data->tanggal_lahir = null;
    $data->jenis_kelamin = null;
    $data->pendidikan = null;
    $data->alamat = null;
    $data->regencies_id = null;
    $data->districts_id = null;
    $data->villages_id = null;
    $data->kota = null;
    $data->camat = null;
    $data->desa = null;
    $data->telp = null;
    $data->job = null;
    $data->awal_anggota = null;
    $data->jenjang_anggota = null;
    $data->usia_jenjang = null;
    $data->binaan = null;
    $data->nama_pasangan = null;
    $data->status_pernikahan = null;
    $data->darah = null;
    $data->amanah = null;

		return $data;
	}

	public function index()
	{
		$this->setBreadcrumb(['Master Data' => '#', 'Kader' => '#']);
    
		return $this->render('kader.index');
	}

	public function grid(Request $request)
	{
		$data = Kader::all();

		return response()->json($data);
	}

	public function edit(Request $request, $id = null)
	{
		$user = Kader::join("_regencies as r", "regencies_id", "=", "r.id")
    ->join("_districts as d", "districts_id", "=", "d.id")
    ->join("_villages as v", "villages_id", "=", "v.id")
    ->select('kader.id',
      'nama_lengkap',
      'photo',
      'nama_lengkap',
      'nama_panggilan',
      'tempat_lahir',
      DB::raw("to_char(tanggal_lahir, 'dd-mm-yyyy') as tanggal_lahir"),
      'jenis_kelamin',
      'pendidikan',
      'alamat',
      'regencies_id',
      'r.name as kota',
      'districts_id',
      'd.name as camat',
      'villages_id',
      'v.name as desa',
      'telp',
      'job',
      DB::raw("to_char(awal_anggota, 'dd-mm-yyyy') as awal_anggota"),
      'jenjang_anggota',
      'usia_jenjang',
      'binaan',
      'nama_pasangan',
      'status_pernikahan',
      'darah',
      'amanah',
      )->find($id);
      // dd($user);
		$data = $user != null ? $user : $this->__db();
		$label = $user != null ? 'Ubah' : 'Tambah Baru';
		
		$this->setBreadcrumb(['Master Data' => '#', 'Kader' => '/kader', $label => '#']);
    $this->setHeader($label);

		return $this->render('kader.edit', ['data' => $data]);
	}

	public function save(Request $request)
	{
    // dd($request->all());
    // $date = Carbon::createFromFormat('Y-m-d',$request->tanggal_lahir);
    // $usableDate = $date->format('Y-m-d');
    $request->validate([
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
      'telp' => 'required',
      'job' => 'required',
      'awal_anggota' => 'required',
      'jenjang_anggota' => 'required',
      'usia_jenjang' => 'required',
      'status_pernikahan' => 'required',
      'darah' => 'required',
    ]);
		if(isset($request->id)){

			$user =	Kader::find($request->id);
			$user->update([
				'photo' => $request->photo,
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
        'awal_anggota' => $request->awal_anggota,
        'jenjang_anggota' => $request->jenjang_anggota,
        'usia_jenjang' => $request->usia_jenjang,
        'binaan' => $request->binaan,
        'nama_pasangan' => $request->nama_pasangan,
        'status_pernikahan' => $request->status_pernikahan,
        'darah' => $request->darah,
        'amanah' => $request->amanah,
        'updated_by' => Auth::user()->getAuthIdentifier()
			]);
			$status = 'Berhasil mengubah kader.';
		} else {

			$user = Kader::create([
				'photo' => $request->photo,
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
        'awal_anggota' => $request->awal_anggota,
        'jenjang_anggota' => $request->jenjang_anggota,
        'usia_jenjang' => $request->usia_jenjang,
        'binaan' => $request->binaan,
        'nama_pasangan' => $request->nama_pasangan,
        'status_pernikahan' => $request->status_pernikahan,
        'darah' => $request->darah,
        'amanah' => $request->amanah,
        'created_by' => Auth::user()->getAuthIdentifier()
			]);
			$status = 'Berhasil menambah kader baru.';
		}

		$request->session()->flash('success', $status);

		return redirect('/kader');
	}

	public function delete($id)
	{
		$data = Kader::find($id);
    if($data){
      $data->update(['deleted_by' => Auth::user()->getAuthIdentifier()]);
      $data->destroy($id);
      $results = array(
        'status' => 'success',
        'action' => 'Hapus Kader',
        'messages' => 'Kader berhasil dihapus'
      );
    }else{
      $results = array(
        'status' => 'error',
        'action' => 'Kesalahan',
        'messages' => 'Kader tidak ditemukan'
      );
    }

		return response()->json($results);
	}
}
