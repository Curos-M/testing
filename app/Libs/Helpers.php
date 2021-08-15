<?php
namespace App\Libs;

use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Helpers
{
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
        $img->resize(332, 500)->save($tumbPath . "/" . $file->newName);
      }
    } catch (\Exception $e){
      dd($e);
        // supress
    }
    return $file;
  }
  
}