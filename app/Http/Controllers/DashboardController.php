<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  function __construct()
	{
		$this->setTitle("Dashboard");
		$this->setUrl("/");
	}

  public function index()
	{
		$this->setBreadcrumb(['Dashboard' => '#']);
    
		return $this->render('dashboard.index');
	}

  public function query($request)
  {
    return Kader::where('verif', '1')
    ->when($request->kota, function ($query, $id) {
      return $query->where('regencies_id', $id);  
    })->when($request->kecamatan, function ($query, $id) {
      return $query->where('districts_id', $id); 
    })->when($request->desa, function ($query, $id) {
      return $query->where('villages_id', $id);  
    });
  }
  public function grid(Request $request)
	{
    $data = new \stdClass;

    $data->total_kader = $this->query($request)->where('verif', '1')->count();

		$data->kader_lk['total'] = $this->query($request)->where('verif', '1')->where('jenis_kelamin', '1')->count();
    $data->kader_pr['total'] = $this->query($request)->where('verif', '1')->where('jenis_kelamin', '0')->count();

    $data->kader_jenjang['pemula'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '1')->count();
    $data->kader_jenjang['siaga'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '2')->count();
    $data->kader_jenjang['muda'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '3')->count();
    $data->kader_jenjang['pratama'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '4')->count();
    $data->kader_jenjang['madya'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '5')->count();
    $data->kader_jenjang['dewasa'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '6')->count();
    $data->kader_jenjang['utama'] = $this->query($request)->where('verif', '1')->where('jenjang_anggota', '7')->count();

    $data->kader_darah['a'] = $this->query($request)->where('verif', '1')->where('darah', 'A')->count();
    $data->kader_darah['b'] = $this->query($request)->where('verif', '1')->where('darah', 'B')->count();
    $data->kader_darah['ab'] = $this->query($request)->where('verif', '1')->where('darah', 'AB')->count();
    $data->kader_darah['o'] = $this->query($request)->where('verif', '1')->where('darah', 'O')->count();


    $data->kader_usia['<20'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) < '20'")->count();
    $data->kader_usia['20-29'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '20' and date_part('year', age(now() , tanggal_lahir)) < '30'")->count();
    $data->kader_usia['30-39'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '30' and date_part('year', age(now() , tanggal_lahir)) < '40'")->count();
    $data->kader_usia['40-49'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '40' and date_part('year', age(now() , tanggal_lahir)) < '50'")->count();
    $data->kader_usia['50-59'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '50' and date_part('year', age(now() , tanggal_lahir)) < '60'")->count();
    $data->kader_usia['60-69'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '60' and date_part('year', age(now() , tanggal_lahir)) < '70'")->count();
    $data->kader_usia['>70'] = $this->query($request)->where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '70'")->count();

    

		return response()->json($data);
	}
}
