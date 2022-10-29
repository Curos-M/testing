<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\KaderController;

class DashboardController extends Controller
{
  function __construct()
	{
		$this->setTitle("Dashboard");
		$this->setUrl("/");
	}

  public function index()
	{
    if(!Auth::user()->can('dashboard-view')){
      $kader = new KaderController;
      return $kader->edit(Auth::user()->anggota_id);
    }
		$this->setBreadcrumb(['Dashboard' => '#']);
    $data = new \stdClass;
    $data->kota = null;
    $data->kecamatan = null;
    $data->desa = null;
    $data->status = null;
    $data->tahun = null;
    $user = Kader::find(Auth::user()->anggota_id);
    if(Auth::user()->can('filter-kota/kabupaten') || Auth::user()->can('filter-kecamatan') || Auth::user()->can('filter-desa/kelurahan')){
      $data->kota = DB::table('_regencies')->select(['id' ,'name'])->find($user->regencies_id);
      $data->status = 'kota';
    }
    if(Auth::user()->can('filter-kecamatan') || Auth::user()->can('filter-desa/kelurahan')){
      $data->kecamatan = DB::table('_districts')->select(['id' ,'name'])->find($user->districts_id);
      $data->status = 'kecamatan';
    }
    if(Auth::user()->can('filter-desa/kelurahan')){
      $data->desa = DB::table('_villages')->select(['id' ,'name'])->find($user->villages_id);
      $data->status = 'desa';
    }
    $data->tahun = Kader::select([DB::raw("distinct to_char(awal_anggota, 'yyyy') as tahun")])->orderBy("tahun", 'asc')->get();
    
		return $this->render('dashboard.index', ['data' => $data]);
	}

  public function query($request)
  {
    $user = Kader::find(Auth::user()->anggota_id);
    if(Auth::user()->can('filter-kota/kabupaten')){
      $request->kota = $user->regencies_id;
    }
    if(Auth::user()->can('filter-kecamatan')){
      $request->kecamatan = $user->districts_id;
    }
    if(Auth::user()->can('filter-desa/kelurahan')){
      $request->desa = $user->villages_id;
    }
    $data = Kader::where('verif', '1')
    ->when($request->kota, function ($query, $id) {
      return $query->where('regencies_id', $id);  
    })->when($request->kecamatan, function ($query, $id) {
      return $query->where('districts_id', $id); 
    })->when($request->desa, function ($query, $id) {
      return $query->where('villages_id', $id);  
    });
    return $data;
  }
  public function grid(Request $request)
	{
    $data = new \stdClass;

    $data->total_kader = $this->query($request)->count();

		$data->kader_lk['total'] = $this->query($request)->where('jenis_kelamin', '1')->count();
    $data->kader_pr['total'] = $this->query($request)->where('jenis_kelamin', '0')->count();

    $data->kader_jenjang['pemula'] = $this->query($request)->where('jenjang_anggota', '1')->count();
    $data->kader_jenjang['siaga'] = $this->query($request)->where('jenjang_anggota', '2')->count();
    $data->kader_jenjang['muda'] = $this->query($request)->where('jenjang_anggota', '3')->count();
    $data->kader_jenjang['pratama'] = $this->query($request)->where('jenjang_anggota', '4')->count();
    $data->kader_jenjang['madya'] = $this->query($request)->where('jenjang_anggota', '5')->count();
    $data->kader_jenjang['dewasa'] = $this->query($request)->where('jenjang_anggota', '6')->count();
    $data->kader_jenjang['utama'] = $this->query($request)->where('jenjang_anggota', '7')->count();

    $data->kader_darah['a'] = $this->query($request)->where('darah', 'A')->count();
    $data->kader_darah['b'] = $this->query($request)->where('darah', 'B')->count();
    $data->kader_darah['ab'] = $this->query($request)->where('darah', 'AB')->count();
    $data->kader_darah['o'] = $this->query($request)->where('darah', 'O')->count();

    $data->kader_usia['<20'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) < '20'")->count();
    $data->kader_usia['20-29'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '20' and date_part('year', age(now() , tanggal_lahir)) < '30'")->count();
    $data->kader_usia['30-39'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '30' and date_part('year', age(now() , tanggal_lahir)) < '40'")->count();
    $data->kader_usia['40-49'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '40' and date_part('year', age(now() , tanggal_lahir)) < '50'")->count();
    $data->kader_usia['50-59'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '50' and date_part('year', age(now() , tanggal_lahir)) < '60'")->count();
    $data->kader_usia['60-69'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '60' and date_part('year', age(now() , tanggal_lahir)) < '70'")->count();
    $data->kader_usia['>70'] = $this->query($request)->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '70'")->count();
    
    $idDomisili = DB::table('_regencies')->where('province_id', '15')->pluck('id');
    $qDom = 'regencies_id';
    if($request->kecamatan){
      $idDomisili = DB::table('_villages')->where('district_id', $request->kecamatan)->pluck('id');
      $qDom = 'villages_id';
    }  
    elseif($request->kota){
      $idDomisili = DB::table('_districts')->where('regency_id', $request->kota)->pluck('id');
      $qDom = 'districts_id';
    }
      
    foreach($idDomisili as $index => $id)
    {
      $data->sumDomisili[$index] = $this->query($request)->where($qDom, $id)->count();
    }

    $namaDomisili = DB::table('_regencies')->where('province_id', '15')->pluck('name');
    if($request->kecamatan)
      $namaDomisili = DB::table('_villages')->where('district_id', $request->kecamatan)->pluck('name');
    elseif($request->kota)
      $namaDomisili = DB::table('_districts')->where('regency_id', $request->kota)->pluck('name');
    foreach($namaDomisili as $index => $nama)
    {
      $data->namaDomisili[$index] = $nama;
    }
    
		return response()->json($data);
	}

  public function pertumbuhan(Request $request){
    $tahun = $request->tahun;
    $data = Kader::select([
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '01' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as jan"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '02' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as feb"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '03' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as mar"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '04' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as apr"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '05' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as mei"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '06' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as jun"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '07' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as jul"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '08' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as agu"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '09' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as sep"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '10' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as okt"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '11' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as nov"),
      DB::raw("(select count(*) from kader where to_char(awal_anggota, 'mm') = '12' and to_char(awal_anggota, 'yyyy') = '".$tahun."') as des")
    ])->first();
    
    return response()->json($data);
  }
}
