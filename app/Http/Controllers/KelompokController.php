<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelompokController extends Controller
{
  function __construct()
	{
		$this->setTitle("Kelompok");
		$this->setUrl("kelompok");
	}

  public function index()
	{
		$this->setBreadcrumb(['Kelompok' => '#']);
    
		return $this->render('kelompok.index');
	}
}
