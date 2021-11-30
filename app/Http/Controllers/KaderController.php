<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Models\Anak;
use App\Models\User;

use Illuminate\Http\Request;
use DB;
use Validation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Libs\Helpers;
use App\Models\Kelompok;
use Yajra\DataTables\Contracts\DataTable;


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
    $data->id_kelompok = null;
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
    $data->rekomendasi = null;
    $data->verif = 0;
    $data->verif_user = null;
    $data->verif_date = null;

		return $data;
	}

	public function index()
	{
		$this->setBreadcrumb(['Master Data' => '#', 'Anggota' => '#']);
    
		return $this->render('kader.index');
	}

	public function grid(Request $request)
	{
    $user = Kader::find(Auth::user()->anggota_id);
		$data = Kader::leftJoin('jenjang as j', 'jenjang_anggota', '=', 'j.id')
    ->when(Auth::user()->can('filter-kota/kabupaten'), function($query) use($user){
      return $query->where('regencies_id', $user->regencies_id);
    })->when(Auth::user()->can('filter-kecamatan'), function($query) use($user){
      return $query->where('districts_id', $user->districts_id);
    })->when(Auth::user()->can('filter-desa/kelurahan'), function($query) use($user){
      return $query->where('villages_id', $user->villages_id);
    })
    ->select([
      'kader.id',
      'kader.nomor_urut',
      'nama_lengkap',
      'telp',
      'j.nama as nama_jenjang',
      'verif'
    ]);
		return datatables()->of($data)->toJson();
	}

  public function pasangan(Request $request)
	{
		$data = Kader::where('nama_lengkap', 'LIKE', '%'. $request->search . '%')
    ->whereNotIn('jenis_kelamin', [$request->jenis_kelamin])
    ->where('status_pernikahan', 'Kawin')
    ->whereNull('pasangan_id')
    ->where('verif', '1');
    if($request->id){
      $data = $data->whereNotIn('id', [$request->id]);
    }
    $data = $data->take(5)->get();
		return response()->json($data);
	}


  public function searchAnak(Request $request)
	{
  
		$data = Kader::where('nama_lengkap', 'LIKE', '%'. $request->search . '%')
    ->where('verif', '1')
    ->whereRaw("tanggal_lahir - interval '18 y' > ?", [$request->tanggal_lahir])
    ->whereNull('ortu_id');
    
    $data= $data->take(5)->get();
    // dd($data);
		return response()->json($data);
	}

  public function gridAnak(Request $request, $id = null)
	{
		$anak = Anak::join('kader as k','kader_id', '=' , 'k.id')
    ->where('kader_id', $id)
    ->orWhere('k.pasangan_id', $id)
    ->select(
      'anak.id',
      'nama',
      DB::raw("date_part('year', tahun_lahir) as tahun_lahir"),
      'anak.pendidikan',
      DB::raw("CASE WHEN tarbiyah is true THEN 'Ya' ELSE 'Tidak' END as tarbiyah"),
      DB::raw('0 as anggota')
    );
    $pasangan = Kader::where('pasangan_id', $id)->first();
    $data = Kader::whereIn('ortu_id', [$id, $pasangan->id??null])
    ->select([
      'id',
      'nama_lengkap as nama',
      DB::raw("date_part('year', tanggal_lahir) as tahun_lahir"),
      'pendidikan',
      DB::raw("CASE WHEN nama_pembina is null and id_kelompok is null THEN 'Tidak' ELSE 'Ya' END as tarbiyah"),
      DB::raw('1 as anggota')
    ])->union($anak)->orderBy('tahun_lahir', 'asc')->get();

		return response()->json($data);
	}

	public function edit(Request $request, $id = null)
	{
    $user = Kader::find(Auth::user()->anggota_id);
		$kader = Kader::join("_regencies as r", "regencies_id", "=", "r.id")
    ->join("_districts as d", "districts_id", "=", "d.id")
    ->join("_villages as v", "villages_id", "=", "v.id")
    ->leftjoin("users as u", 'verif_by', '=', 'u.id')
    ->leftJoin("kader as p", "kader.pasangan_id", '=', 'p.id')
    ->leftJoin("kelompok as k", "kader.id_kelompok", '=', 'k.id')
    ->when(Auth::user()->can('filter-kota/kabupaten'), function($query) use($user){
      return $query->where('kader.regencies_id', $user->regencies_id);
    })->when(Auth::user()->can('filter-kecamatan'), function($query) use($user){
      return $query->where('kader.districts_id', $user->districts_id);
    })->when(Auth::user()->can('filter-desa/kelurahan'), function($query) use($user){
      return $query->where('kader.villages_id', $user->villages_id);
    })
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
      'kader.verif',
      'kader.nama_pembina as nama_pembinaStr',
      'kader.rekomendasi',
      'p.nama_lengkap as nama_pasangan',
      'k.nama_pembina as nama_pembina',
      'kader.id_kelompok',
      'u.full_name as verif_user',
      DB::Raw("to_char(kader.verif_at, 'dd-mm-yyyy hh24:mi:ss')as verif_date")
      )->find($id);
      if($id && !$kader){
        abort(404);
      }
		$data = $kader != null ? $kader : $this->__db();
		$label = $kader != null ? 'Ubah' : 'Tambah Baru';
    $kelompok = Kelompok::where('id_pembina', $id)->select('id')->get();
    $data->jumlah_binaan = 0;
    foreach($kelompok as $k){
      $count = Kader::where('id_kelompok', $k->id)->count();
      $data->jumlah_binaan += $count;
    }
    $jenjang = DB::table('jenjang')->get();

    $user = Auth::user()->anggota_id;
    $userKader = Kader::find($user);
    if($userKader){
      if($userKader->jenjang_anggota > '5')
        $data->jenjang_visible = true;
      else
        $data->jenjang_visible = false;
    }else
      $data->jenjang_visible = true;

		$this->setBreadcrumb(['Master Data' => '#', 'Anggota' => '/anggota', $label => '#']);
    $this->setHeader($label);

		return $this->render('kader.edit', ['data' => $data, 'jenjang' => $jenjang]);
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
        $file = Helpers::prepareAnggota($request->all(), '/images/anggota');
        if($val)
          Helpers::removeFile($val->photo, 'images/anggota');
      }
      $oldPath = isset($request->photo) ? $request->photo : null ;
      $filePath = isset($file) ? $file->newName : $oldPath; 

      if($request->ktp != ($val ? $val->ktp : null )){
        $file1 = Helpers::prepareKtp($request->all(), '/images/ktp');
        if($val)
          Helpers::removeFile($val->ktp, 'images/ktp');
      }
      $oldPath1 = isset($request->ktp) ? $request->ktp : null ;
      $filePath1 = isset($file1) ? $file1->newName : $oldPath1; 

      $prefix = Helpers::prefix($request);

      $latest = DB::table('kader')->where('regencies_id', $request->regencies_id)->whereNotNull('nomor_urut')->count();

      $no = $prefix->prefix . (str_pad((int)$latest + 1, 5, '0', STR_PAD_LEFT));

      $kelompok = Kelompok::where('id_pembina', $val->id)->select('id')->get();
      if(!$pembina && $kelompok){
        foreach($kelompok as $k){
          Kader::where('id_kelompok', $k->id)->update(['id_kelompok' => null, 'updated_by' => Auth::user()->getAuthIdentifier()]);
        }
        Kelompok::where('id_pembina', $val->id)->update(['deleted_at' => now()->toDateTimeString(), 'deleted_by' => Auth::user()->getAuthIdentifier()]);
      }

      if(isset($request->id)){
        $kader =	Kader::find($request->id);
        $kader->update([
          'photo' => $filePath,
          'nik' => $request->nik,
          'nama_lengkap' => $request->nama_lengkap,
          'nama_panggilan' => $request->nama_panggilan,
          'tempat_lahir' => $request->tempat_lahir,
          'tanggal_lahir' => $request->tanggal_lahir,
          'jenis_kelamin' => $request->jenis_kelamin,
          'pendidikan' => $request->pendidikan,
          'alamat' => $request->alamat,
          'provinces_id' => "15",
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
        $request->validate(['nik' => 'nullable|unique:kader,nik']);
  
        $kader = Kader::create([
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
          'provinces_id' => "15",
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
      if($request->nama_pembina){
        $kader->update(['nama_pembina' => $request->nama_pembina, 'id_kelompok' => null]);
      }

      if($request->hidden_pasangan == "true"  && $request->pasangan != null){
        $kader->update(['pasangan_id' => $request->pasangan, 'pasangan' => null]);
        Kader::where('pasangan_id' ,$kader->id)->update(['pasangan_id' => null]);
        Kader::find($request->pasangan)->update(['pasangan' => null, 'pasangan_id' => $kader->id]);
      }elseif($request->hidden_pasangan == "false"  && $request->pasangan != null){
        $kader->update(['pasangan' => $request->pasangan, 'pasangan_id' => null]);
        Kader::where('pasangan_id' ,$kader->id)->update(['pasangan_id' => null]);
      }elseif($request->pasangan == null){
        Kader::where('pasangan_id' ,$kader->id)->update(['pasangan_id' => null]);
        $kader->update(['pasangan' => null, 'pasangan_id' => null]);
      }
      
      $user = User::where('anggota_id', $kader->id)->first();
      if($pembina && !$user){
        User::create([
          'username' => $kader->nomor_urut,
          'password' => bcrypt(Carbon::parse($kader->tanggal_lahir)->format('dmy')),
          'full_name' => $kader->nama_lengkap,
          'anggota_id' => $kader->id,
          'created_by' => Auth::user()->getAuthIdentifier()
        ])->assignRole('Ketua UPA');
      }elseif(!$pembina && $user){
        User::where('anggota_id', $kader->id)->delete();
      }

      $request->session()->flash('success', $status);
      DB::commit();
    }catch(\exception $e){
      DB::rollback();
      dd($e);
    }
		

		return redirect('/anggota/edit'.'/'.$kader->id);
	}

	public function delete(request $request, $id)
	{
    try{
      DB::beginTransaction();
      $data = Kader::find($id);
      $anak = Anak::where('kader_id', $id);
      $anakKader = Kader::where('ortu_id', $id);
      $user = User::where('anggota_id', $id);

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
      
      if($anakKader && $data->pasangan_id){
        $anakKader->update(['ortu_id' => $data->pasangan_id]);
        $request->session()->flash('warning', 'Silahkan update data pasangan anggota');
        Kader::find($data->pasangan_id)->update(['pasangan_id' => null]);
      }elseif($anakKader && !$data->pasangan_id){
        $anakKader->update(['ortu_id' => null]);
      }

      $kelompok = Kelompok::where('id_pembina', $id)->select('id')->get();
      if($kelompok){
        foreach($kelompok as $k){
          Kader::where('id_kelompok', $k->id)->update(['id_kelompok' => null, 'updated_by' => Auth::user()->getAuthIdentifier()]);
        }
        Kelompok::where('id_pembina', $id)->update(['deleted_at' => now()->toDateTimeString(), 'deleted_by' => Auth::user()->getAuthIdentifier()]);
      }

      if($user)
        $user->delete();
        
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
      dd($e);
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
      $data->update(['deleted_at' => now()->toDateTimeString(), 'deleted_by' => Auth::user()->getAuthIdentifier()]);
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

  public function deleteAnakKader($id)
	{
    
		$data = Kader::find($id);
    if($data){
      $data->update(['ortu_id' => null]);
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

  public function getAnak($id)
	{
    
		$data = Anak::where('id', $id)->first();

		return response()->json($data);
	}

  public function saveAnak(Request $request)
	{
    // dd($request->all());

    if($request->anggota){
      $user =	Kader::find($request->id);
      $user->update([
        'ortu_id' => $request->ortu_id,
        'updated_by' => Auth::user()->getAuthIdentifier()
      ]);
      $results = array(
        'status' => 'success',
        'action' => 'Tambah Anak',
        'messages' => 'Anak berhasil ditambah'
      );
    }else{
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
    }


		return response()->json($results);
	}


  public function verif(Request $request, $id){

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
      $request->session()->flash('success', 'Verifikasi Berhasil');
    }else{
      $request->session()->flash('error', 'Gagal Memverifikasi, NIK Tidak Boleh Kosong');
    }
    return redirect('/anggota/edit'.'/'.$data->id);
  }
}
