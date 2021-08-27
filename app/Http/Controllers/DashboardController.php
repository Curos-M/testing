<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
	{
		$this->setBreadcrumb(['Dashboard' => '#']);
    
		return $this->render('dashboard.index');
	}
}
