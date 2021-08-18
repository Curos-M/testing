<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Models\Anak;

use Illuminate\Http\Request;
use DB;
use Validation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Libs\Helpers;
use stdClass;

use function GuzzleHttp\Promise\all;

class KaderController extends Controller
{
	function __construct()
	{
		$this->setTitle("Anggota");
		$this->setUrl("anggota");
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
    $data->nama_pembina = null;
    $data->id_pembina = null;
    $data->pasangan_id = null;
    $data->pasangan = null;
    $data->nama_pasangan = null;
    $data->status_pernikahan = null;
    $data->darah = null;
    $data->amanah = null;
    $data->pembina = 0;
    $data->nama_pembinaStr = null;
    $data->nik = null;
    $data->ktp = null;
    $data->nomor_urut = null;

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

  public function pasangan(Request $request)
	{
		$data = Kader::where('nama_lengkap', 'LIKE', '%'. $request->search . '%')
    ->whereNotIn('jenis_kelamin', [$request->jenis_kelamin])
    ->where('status_pernikahan', 'Kawin')
    ->whereNull('pasangan_id');
    if($request->id){
      $data = $data->whereNotIn('id', [$request->id]);
    }
    $data = $data->take(5)->get();
		return response()->json($data);
	}

  public function pembina(Request $request)
	{
		$data = Kader::where('nama_lengkap', 'LIKE', '%'. $request->search . '%')
    ->where('pembina', '1');
    if($request->id && $request->ortu){
      $data = $data->whereNotIn('id', [$request->id]);
    }
    $data= $data->take(5)->get();
		return response()->json($data);
	}

  public function gridBinaan(Request $request, $id = null)
	{
    $anak = Anak::join('kader as k','kader_id', '=', 'k.id')->where('pembimbing_id', $id)
    ->select(['nama', 'k.id', DB::raw('1 as anak'),'k.nama_lengkap as nama_ortu']);
		$data = Kader::where('id_pembina', $id)
    ->select(['nama_lengkap as nama', 'id', DB::raw('0 as anak'),DB::raw('null as nama_ortu')])->union($anak)->get();

		return response()->json($data);
	}

  public function gridAnak(Request $request, $id = null)
	{
		$data = Anak::join('kader as k','kader_id', '=' , 'k.id')
    ->where('kader_id', $id)
    ->orWhere('k.pasangan_id', $id)
    ->select(
      'anak.id',
      'nama',
      DB::raw("date_part('year', tahun_lahir) as tahun_lahir"),
      'anak.pendidikan',
      DB::raw("CASE WHEN tarbiyah is true THEN 'Ya' ELSE 'Tidak' END as tarbiyah")
    )->get();

		return response()->json($data);
	}

	public function edit(Request $request, $id = null)
	{
    // dd(Kader::latest()->first()->id);
		$user = Kader::join("_regencies as r", "regencies_id", "=", "r.id")
    ->join("_districts as d", "districts_id", "=", "d.id")
    ->join("_villages as v", "villages_id", "=", "v.id")
    ->leftJoin("kader as p", "kader.pasangan_id", '=', 'p.id')
    ->leftJoin("kader as b", "kader.id_pembina", '=', 'b.id')
    ->select('kader.id',
      'kader.nik',
      'kader.nomor_urut',
      'kader.ktp',
      'kader.nama_lengkap',
      'kader.photo',
      'kader.nama_panggilan',
      'kader.tempat_lahir',
      'kader.tanggal_lahir',
      'kader.jenis_kelamin',
      'kader.pendidikan',
      'kader.alamat',
      'kader.regencies_id',
      'r.name as kota',
      'kader.districts_id',
      'd.name as camat',
      'kader.villages_id',
      'v.name as desa',
      'kader.telp',
      'kader.job',
      'kader.awal_anggota',
      'kader.jenjang_anggota',
      'kader.usia_jenjang',
      'kader.pasangan',
      'kader.status_pernikahan',
      'kader.darah',
      'kader.amanah',
      'kader.pasangan_id',
      'kader.pembina',
      'kader.nama_pembina as nama_pembinaStr',
      'p.nama_lengkap as nama_pasangan',
      'b.nama_lengkap as nama_pembina',
      'kader.id_pembina'
      )->find($id);
      // dd($user);
		$data = $user != null ? $user : $this->__db();
		$label = $user != null ? 'Ubah' : 'Tambah Baru';
    $data->jumlah_binaan = Kader::where('id_pembina', $id)->count();
	
		$this->setBreadcrumb(['Master Data' => '#', 'Anggota' => '/anggota', $label => '#']);
    $this->setHeader($label);

		return $this->render('kader.edit', ['data' => $data]);
	}

	public function save(Request $request)
	{
    $pembina = $request->pembina ? 1 : 0;
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
    try{
      DB::beginTransaction();
      $val = Kader::find($request->id);
      $file = null;
      $file1 = null;
      if($request->photo != ($val ? $val->photo : null )){
        $file = Helpers::prepareFile($request->all(), '/images/anggota');
        if($val)
          Helpers::removeFile($val->photo, 'images/anggota');
      }
      $oldPath = isset($request->photo) ? $request->photo : null ;
      $filePath = isset($file) ? $file->newName : $oldPath; 

      if($request->ktp != ($val ? $val->ktp : null )){
        $file1 = Helpers::prepareFile1($request->all(), '/images/ktp');
        if($val)
          Helpers::removeFile($val->ktp, 'images/ktp');
      }
      $oldPath1 = isset($request->ktp) ? $request->ktp : null ;
      $filePath1 = isset($file1) ? $file1->newName : $oldPath1; 

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
      // dd($latest);

      $no = $prefix->prefix . (str_pad((int)$latest + 1, 5, '0', STR_PAD_LEFT));
      // dd($no);
      if(isset($request->id)){
        $user =	Kader::find($request->id);
        $user->update([
          'photo' => $filePath,
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
          'awal_anggota' => $request->awal_anggota,
          'jenjang_anggota' => $request->jenjang_anggota,
          'usia_jenjang' => $request->usia_jenjang,
          'status_pernikahan' => $request->status_pernikahan,
          'pembina' => $pembina,
          'darah' => $request->darah,
          'amanah' => $request->amanah,
          'ktp' => $filePath1,
          'updated_by' => Auth::user()->getAuthIdentifier()
        ]);
        $status = 'Berhasil mengubah anggota.';
      } else {
  
        $user = Kader::create([
          'nomor_urut' => $no,
          'photo' => $filePath,
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
          'awal_anggota' => $request->awal_anggota,
          'jenjang_anggota' => $request->jenjang_anggota,
          'usia_jenjang' => $request->usia_jenjang,
          'status_pernikahan' => $request->status_pernikahan,
          'pembina' => $pembina,
          'darah' => $request->darah,
          'amanah' => $request->amanah,
          'ktp' => $filePath1,
          'verif' => '1',
          'created_by' => Auth::user()->getAuthIdentifier()
        ]);
        $status = 'Berhasil menambah anggota baru.';
      }
      if(!ctype_alpha($request->id_pembina) && $request->id_pembina != null){
        $user->update(['id_pembina' => $request->id_pembina, 'nama_pembina' => null]);
      }elseif(ctype_alpha($request->id_pembina) && $request->id_pembina != null){
        $user->update(['nama_pembina' => $request->id_pembina, 'id_pembina' => null]);
      }elseif($request->id_pembina == null){
        $user->update(['nama_pembina' => null, 'id_pembina' => null]);
      }

      if(!ctype_alpha($request->pasangan) && $request->pasangan != null){
        $user->update(['pasangan_id' => $request->pasangan, 'pasangan' => null]);
        Kader::where('pasangan_id' ,$user->id)->update(['pasangan_id' => null]);
        Kader::find($request->pasangan)->update(['pasangan' => null, 'pasangan_id' => $user->id]);
      }elseif(ctype_alpha($request->pasangan) && $request->pasangan != null){
        $user->update(['pasangan' => $request->pasangan, 'pasangan_id' => null]);
        Kader::where('pasangan_id' ,$user->id)->update(['pasangan_id' => null]);
      }elseif($request->pasangan == null){
        Kader::where('pasangan_id' ,$user->id)->update(['pasangan_id' => null]);
        $user->update(['pasangan' => null, 'pasangan_id' => null]);
      }

      if(!$request->pembina){
        $binaanKader = Kader::where('id_pembina' ,$user->id);
        if($binaanKader){
          $binaanKader->update(['id_pembina' => null]);
        }
        $binaanAnak = Anak::where('pembimbing_id' ,$user->id);
        if($binaanAnak){
          $binaanAnak->update(['pembimbing_id' => null]);
        }
      }
      $request->session()->flash('success', $status);
      DB::commit();
    }catch(\exception $e){
      DB::rollback();
      dd($e);
    }
		

		return redirect('/anggota/edit'.'/'.$user->id);
	}

	public function delete(request $request, $id)
	{
    try{
      DB::beginTransaction();
      $data = Kader::find($id);
      $anak = Anak::where('kader_id', $id);
      if($anak && $data->pasangan_id == null){
        $anak->update([
          'deleted_at' => now()->toDateTimeString(),
          'deleted_by' => Auth::user()->getAuthIdentifier()
        ]);
      }elseif($anak && $data->pasangan_id){
        $anak->update([
          'kader_id' => $data->pasangan_id
        ]);
        $request->session()->flash('warning', 'Silahkan update data pasangan anggota');
        Kader::find($data->pasangan_id)->update(['pasangan_id' => null]);
      }
      if($data){
        $data->update(['deleted_by' => Auth::user()->getAuthIdentifier()]);
        $data->destroy($id);
        if($anak && $data->pasangan_id){
          $results = array(
            'url'    => url('/anggota/edit'.'/'.$data->pasangan_id)
          );
          $request->session()->flash('success', 'Anggota Berhasil Dihapus');
        }else{
          $results = array(
            'status' => 'success',
            'action' => 'Hapus Anggota',
            'messages' => 'Anggota berhasil dihapus'
          );
        }
        
      }
      DB::commit();
    }catch(\Exception $e){
      DB::rollback();
      $results = array(
        'status' => 'error',
        'action' => 'Kesalahan',
        'messages' => 'Hubungi Administrator'
      ); 
    }	
    return  response()->json($results);
	}

  public function deleteAnak($id)
	{
		$data = Anak::find($id);
    if($data){
      $data->update(['deleted_by' => Auth::user()->getAuthIdentifier()]);
      $data->destroy($id);
      $results = array(
        'status' => 'success',
        'action' => 'Hapus Anak',
        'messages' => 'Anak berhasil dihapus'
      );
    }else{
      $results = array(
        'status' => 'error',
        'action' => 'Kesalahan',
        'messages' => 'Anak tidak ditemukan'
      );
    }

		return response()->json($results);
	}

  public function saveAnak(Request $request)
	{
    // dd($request->all());

    $request->validate([
      'nama' => 'required',
      'tahun_lahir' => 'required',
      'pendidikan' => 'required',
      'tarbiyah' => 'required',
    ]);
    try{
      DB::beginTransaction();
      if(isset($request->id)){

        $user =	Anak::find($request->id);
        $user->update([
          'kader_id' => $request->kader_id,
          'nama' => $request->nama,
          'tahun_lahir' => Carbon::createFromFormat('Y',$request->tahun_lahir)->format('Y-m-d'),
          'pendidikan' => $request->pendidikan,
          'tarbiyah' => $request->tarbiyah,
          'updated_by' => Auth::user()->getAuthIdentifier()
        ]);
        $results = array(
          'status' => 'success',
          'action' => 'Edit Anak',
          'messages' => 'Anak berhasil dirubah'
        );
      } else {
  
        $user = Anak::create([
          'kader_id' => $request->kader_id,
          'nama' => $request->nama,
          'tahun_lahir' => Carbon::createFromFormat('Y',$request->tahun_lahir)->format('Y-m-d'),
          'pendidikan' => $request->pendidikan,
          'tarbiyah' => $request->tarbiyah,
          'created_by' => Auth::user()->getAuthIdentifier()
        ]);
        $results = array(
          'status' => 'success',
          'action' => 'Tambah Anak',
          'messages' => 'Anak berhasil ditambah'
        );
      }

      if(!ctype_alpha($request->pembimbing_id) && $request->pembimbing_id != null){
        $user->update(['pembimbing_id' => $request->pembimbing_id, 'pembimbing' => null]);
      }elseif(ctype_alpha($request->id_pembina) && $request->id_pembina != null){
        $user->update(['pembimbing' => $request->pembimbing_id, 'pembimbing_id' => null]);
      }elseif($request->id_pembina == null){
        $user->update(['pembimbing' => null, 'pembimbing_id' => null]);
      }

      DB::commit();
    }catch(\Exception $e){
      DB::rollback();
      $results = array(
        'status' => 'error',
        'action' => 'Kesalahan',
        'messages' => 'Hubungi Administrator'
      );
      dd($e);
    }


		return response()->json($results);
	}
}
