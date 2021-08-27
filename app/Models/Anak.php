<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anak extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anak';
    protected $fillable = [
      'kader_id',
      'nama',
      'tahun_lahir',
      'pendidikan',
      'tarbiyah',
      'pembimbing_id',
      'pembimbing',
      'created_by',
      'updated_by',
      'deleted_at',
      'deleted_by'
    ];
}
