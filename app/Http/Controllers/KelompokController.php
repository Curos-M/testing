<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelompok;
use App\Models\Kader;
use App\Models\NoteKelompok;

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

		return $data;
	}

  public function index()
	{
		$this->setBreadcrumb(['Kelompok' => '#']);
    
		return $this->render('kelompok.index');
	}
  public function grid()
	{
		$data = Kelompok::select([
      'id',
      'id_pembina',
      'nama_pembina',
      'nama_kelompok'
    ]);
		return datatables()->of($data)->toJson();
	}

  public function edit(Request $request, $id = null)
	{
		$user = Kelompok::select(
      'id',
      'nama_pembina',
      'nama_kelompok',
      )->find($id);
		$data = $user != null ? $user : $this->__db();
		$label = $user != null ? 'Ubah' : 'Tambah Baru';

	
		$this->setBreadcrumb(['Kelompok' => '#', $label => '#']);
    $this->setHeader($label);

		return $this->render('kelompok.edit', ['data' => $data]);
	}

  public function save(Request $request)
  {
    if(isset($request->id)){
			$request->validate([
        'nama_kelompok' => 'required'
			]);

			$data =	Kelompok::find($request->id);
			$data->update([
				'id_pembina' => Auth::user()->anggota_id,
				'nama_pembina' => Auth::user()->full_name,
				'nama_kelompok' => $request->nama_kelompok,
        'updated_by' => Auth::user()->getAuthIdentifier()
			]);
			$status = 'Berhasil mengubah Kelompok.';
      $aksi = 'Mengubah';
		} else {
			$request->validate([
        'nama_kelompok' => 'required'
			]);

			$data = Kelompok::create([
				'id_pembina' => Auth::user()->anggota_id,
				'nama_pembina' => Auth::user()->full_name,
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
    $data->kader = Kader::where('id_kelompok', $id)->select('nama_lengkap')->get();
    $data->note = NoteKelompok::where('id_kelompok', $id)->orderBy('created_at', 'desc')->first();

		return response()->json($data);
	}
}
