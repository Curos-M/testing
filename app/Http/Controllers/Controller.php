<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $breadcrumb = ["Dashboard" => "#"];
    private $header = null;
    private $title = "Dashboard";
    private $url = '#';
    private $responses = array( 'state_code' => '', 'status' => '', 'messages' => array(), 'data' => Array()); 
  
    public function setBreadcrumb($value=[])
    {
      $this->breadcrumb = $value;
    }
  
    public function pushBreadCrumb($value=[])
    {
      array_push($this->breadcrumb, $value);
    }
    
    public function getBreadcrumb()
    {
      return $this->breadcrumb;
    }
  
    public function setTitle($value)
    {
      return $this->title = $value;
    }
  
    public function getTitle()
    {
      return $this->title;
    }
    
    public function setUrl($value)
    {
      return $this->url = $value;
    }
  
    public function getUrl()
    {
      return $this->url;
    }

    public function setHeader($value)
    {
      $this->header = $value;
    }

    public function getHeader()
    {
      return $this->header;
    }
  
    public function render($view, $additional=[])
    {
      $data = [
        'breadcrumb'  => $this->breadcrumb,
        'title'       => $this->title,
        'link'				=> $this->url,
        'header'      => $this->header,
        'username'    => Auth::user()->full_name,
        'canEdit'     => Auth::user()->can($this->url.'-edit'),
        'canAdd'      => Auth::user()->can($this->url.'-add'),
        'canDelete'   => Auth::user()->can($this->url.'-delete'),
        'anggota_id'  => Auth::user()->anggota_id
      ];
      return view($view, array_merge($data, $additional));
    }
}
