<?php
namespace App\Libs;

use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Helpers
{
  public static function prefix($data)
  {
    
    $prefix = DB::table('_regencies')
      ->where('province_id', '15')
      ->where('id', $data->regencies_id)
      ->select(["id", DB::Raw("
      Case WHEN id = '1501' THEN 'KRC'
        WHEN id = '1572' THEN 'SPN'
        ELSE 'NaN' END as prefix
      ")])
      ->first();
    return $prefix;
  }

  public static function prepareFile($inputs, $subFolder)
  {
    $file = new \StdClass;
    try {
      $file = isset($inputs['file']) ? $inputs['file'] : null;
      $path = 'public' . $subFolder;
        if (!File::isDirectory($path)) {
          Storage::makeDirectory($path);
        }
      if($file != null){
        $file->path = storage_path('app/public') . $subFolder;
        $file->newName = time()."_".$file->getClientOriginalName();
        $file->originalName = explode('.',$file->getClientOriginalName())[0];
        // $file->move($file->path ,$file->newName);
        Image::make($file)->save($file->path. "/" . $file->newName);

        //buat folder tumbnail
        $critPath = $path .'/'. 'thumbnail/';
        if (!File::isDirectory($critPath)) {
          Storage::makeDirectory($critPath);
        }
        $tumbPath = $file->path .'/'. 'thumbnail/';
        $img = Image::make($file);
        $img->resize(332, 500)->orientate()->save($tumbPath . "/" . $file->newName);
      }
    } catch (\Exception $e){
      dd($e);
        // supress
    }
    return $file;
  }

  public static function prepareAnggota($inputs, $subFolder)
  {
    $file = new \StdClass;
    try {
      $file = isset($inputs['file']) ? $inputs['file'] : null;
      $path = 'public' . $subFolder;
        if (!File::isDirectory($path)) {
          Storage::makeDirectory($path);
        }
      if($file != null){
        $file->path = storage_path('app/public') . $subFolder;
        $file->newName = time()."_".$inputs['nama_lengkap'].'.'.$file->getClientOriginalExtension();
        $file->originalName = explode('.',$file->getClientOriginalName())[0];
        // $file->move($file->path ,$file->newName);
        Image::make($file)->orientate()->resize(300, 400)->save($file->path. "/" . $file->newName);
      }
    } catch (\Exception $e){
      dd($e);
        // supress
    }
    return $file;
  }

  public static function prepareKtp($inputs, $subFolder)
  {
    $file = new \StdClass;
    try {
      $file = isset($inputs['file1']) ? $inputs['file1'] : null;
      $path = 'public' . $subFolder;
        if (!File::isDirectory($path)) {
          Storage::makeDirectory($path);
        }
      if($file != null){
        $file->path = storage_path('app/public') . $subFolder;
        $file->newName = time()."_".$inputs['nama_lengkap'].'.'.$file->getClientOriginalExtension();
        $file->originalName = explode('.',$file->getClientOriginalName())[0];
        // $file->move($file->path ,$file->newName);
        Image::make($file)->orientate()->resize(300, 225)->save($file->path. "/" . $file->newName);

      }
    } catch (\Exception $e){
      dd($e);
        // supress
    }
    return $file;
  }

  public static function removeFile($inputs, $subFolder)
  {
    if(Storage::exists('public/'.$subFolder.'/'.$inputs)){
      Storage::delete('public/'.$subFolder.'/'.$inputs);
      if(Storage::exists('public/'.$subFolder.'/'.'thumbnail/'.$inputs))
        Storage::delete('public/'.$subFolder.'/'.'thumbnail/'.$inputs);
    }
  }
  
}