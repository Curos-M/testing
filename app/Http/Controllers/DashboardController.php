<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
