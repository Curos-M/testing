<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelompok;
use App\Models\Kader;
use App\Models\NoteKelompok;
use Illuminate\Support\Facades\DB;

class KelompokController extends Controller
{
  function __construct()
	{
		$this->setTitle("Kelompok");
		$this->setUrl("kelompok");
	}

  private function __db()
	{
		$data = new \StdClass();
		$data->id = null;
		$data->id_pembina = null;
		$data->nama_pembina = null;
		$data->nama_kelompok = null;
    $data->jenjang_anggota = null;

		return $data;
	}

  public function index()
	{
		$this->setBreadcrumb(['Kelompok' => '#']);
    $user = Auth::user();
    
		return $this->render('kelompok.index', ['user' => $user]);
	}
  public function grid()
	{
    $user = Auth::user();
    
		$data = Kelompok::when($user, function($query, $user){
      if($user->id != '1')
      $query->where('id_pembina', $user->anggota_id);
    })->select([
      'id',
      'id_pembina',
      'nama_pembina',
      'nama_kelompok'
    ])->orderBy('updated_at', 'desc');
		return datatables()->of($data)->toJson();
	}

  public function edit(Request $request, $id = null)
	{
		$user = Kelompok::join('kader as k', 'kelompok.id_pembina', '=', 'k.id')
    ->select(
      'kelompok.id',
      'kelompok.nama_pembina',
      'id_pembina',
      'nama_kelompok',
      'k.jenjang_anggota'
      )->find($id);
		$data = $user != null ? $user : $this->__db();
		$label = $user != null ? 'Ubah' : 'Tambah Baru';

    $kader = Kader::where('id_kelompok', $id)->select('nama_lengkap')->get();

	
		$this->setBreadcrumb(['Kelompok' => '#', $label => '#']);
    $this->setHeader($label);

		return $this->render('kelompok.edit', ['data' => $data]);
	}

  public function save(Request $request)
  {
    $request->validate([
      'nama_kelompok' => 'required',
      'id_pembina' => 'required'
    ]);
    $kader = Kader::where('id', $request->id_pembina)->first();
    if(isset($request->id)){
			$data =	Kelompok::find($request->id);
			$data->update([
				'id_pembina' => $request->id_pembina,
				'nama_pembina' => $kader->nama_lengkap,
				'nama_kelompok' => $request->nama_kelompok,
        'updated_by' => Auth::user()->getAuthIdentifier()
			]);
			$status = 'Berhasil mengubah Kelompok.';
      $aksi = 'Mengubah';
		} else {
			$data = Kelompok::create([
				'id_pembina' => $request->id_pembina,
				'nama_pembina' => $kader->nama_lengkap,
				'nama_kelompok' => $request->nama_kelompok,
        'created_by' => Auth::user()->getAuthIdentifier()
			]);
			$status = 'Berhasil menambah kelompok baru.';
      $aksi = 'Menambah';
		}
    $results = array(
			'status' => 'success',
			'action' => $aksi.' Kelompok',
			'messages' => $status
		);
    if($request->noJson){
      $request->session()->flash('success', $status);
		  return redirect('/kelompok/edit/'.$data->id);
    }else
		  return response()->json($results);
  }
  public function delete($id)
	{
		$user = Kelompok::destroy($id);

		$results = array(
			'status' => 'success',
			'action' => 'Hapus Kelompok',
			'messages' => 'Kelompok berhasil dihapus'
		);

		return response()->json($results);
	}
  public function lihat($id)
	{
		$data = Kelompok::find($id);
    $data->kader = Kader::where('id_kelompok', $id)->select(['id', 'nomor_urut', 'nama_lengkap', 'telp'])->get();
    $data->note = NoteKelompok::where('id_kelompok', $id)->select([
      'catatan',
      'photo',
      DB::raw("to_char(created_at, 'dd-mm-yyyy') as tanggal")
    ])->orderBy('created_at', 'desc')->first();

		return response()->json($data);
	}

  public function searchBinaan(Request $request)
	{
		$data = Kader::whereRaw("lower(nama_lengkap) LIKE lower('%". $request->search ."%')")
    ->whereNull('id_kelompok')
    ->whereNotIn('id', [$request->id])
    ->where('verif', '1')
    ->where('jenjang_anggota', '<', $request->jenjang);
    $data= $data->take(5)->get();

    return response()->json($data);
	}
  
  public function addAnggota(Request $request)
  {
    $data = Kader::where('id', $request->id);
    if($data){
      $data->update(['id_kelompok' => $request->id_kelompok, 'nama_pembina' => null, 'updated_by' => Auth::user()->getAuthIdentifier()]);
      $results = array(
        'status' => 'success',
        'action' => 'Tambah Anggota',
        'messages' => 'Anggota berhasil ditambah'
      );
    }else{
      $results = array(
        'status' => 'error',
        'action' => 'Kesalahan',
        'messages' => 'Anggota tidak ditemukan'
      );
    }
    return response()->json($results);
  }

  public function deleteAnggota($id)
	{
		$user = Kader::where('id', $id);
    if($user){
      $user->update(['id_kelompok' => null, 'updated_by' => Auth::user()->getAuthIdentifier()]);
      $results = array(
        'status' => 'success',
        'action' => 'Hapus Anggota',
        'messages' => 'Anggota berhasil dihapus'
      );
    }else{
      $results = array(
        'status' => 'error',
        'action' => 'Kesalahan',
        'messages' => 'Anggota tidak ditemukan'
      );
    }

		return response()->json($results);
	}
}
