<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;

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

  public function grid(Request $request)
	{
    $data = new \stdClass;

    $data->total_kader = Kader::where('verif', '1')->count();

		$data->kader_lk['total'] = Kader::where('verif', '1')->where('jenis_kelamin', '1')->count();
    $data->kader_pr['total'] = Kader::where('verif', '1')->where('jenis_kelamin', '0')->count();

    $data->kader_jenjang['pemula'] = Kader::where('verif', '1')->where('jenjang_anggota', '1')->count();
    $data->kader_jenjang['siaga'] = Kader::where('verif', '1')->where('jenjang_anggota', '2')->count();
    $data->kader_jenjang['muda'] = Kader::where('verif', '1')->where('jenjang_anggota', '3')->count();
    $data->kader_jenjang['pratama'] = Kader::where('verif', '1')->where('jenjang_anggota', '4')->count();
    $data->kader_jenjang['madya'] = Kader::where('verif', '1')->where('jenjang_anggota', '5')->count();
    $data->kader_jenjang['dewasa'] = Kader::where('verif', '1')->where('jenjang_anggota', '6')->count();
    $data->kader_jenjang['utama'] = Kader::where('verif', '1')->where('jenjang_anggota', '7')->count();

    $data->kader_darah['a'] = Kader::where('verif', '1')->where('darah', 'A')->count();
    $data->kader_darah['b'] = Kader::where('verif', '1')->where('darah', 'B')->count();
    $data->kader_darah['ab'] = Kader::where('verif', '1')->where('darah', 'AB')->count();
    $data->kader_darah['o'] = Kader::where('verif', '1')->where('darah', 'O')->count();


    $data->kader_usia['<20'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) < '20'")->count();
    $data->kader_usia['20-29'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '20' and date_part('year', age(now() , tanggal_lahir)) < '30'")->count();
    $data->kader_usia['30-39'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '30' and date_part('year', age(now() , tanggal_lahir)) < '40'")->count();
    $data->kader_usia['40-49'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '40' and date_part('year', age(now() , tanggal_lahir)) < '50'")->count();
    $data->kader_usia['50-59'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '50' and date_part('year', age(now() , tanggal_lahir)) < '60'")->count();
    $data->kader_usia['60-69'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '60' and date_part('year', age(now() , tanggal_lahir)) < '70'")->count();
    $data->kader_usia['>70'] = Kader::where('verif', '1')->whereRaw("date_part('year', age(now() , tanggal_lahir)) >= '70'")->count();

    

		return response()->json($data);
	}
}
