<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kelompok';
    protected $fillable = [
      'id_pembina',
      'nama_pembina',
      'nama_kelompok',
      'created_by',
      'updated_by'
    ];
}
