<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kader extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kader';
    protected $fillable = [
      'photo',
      'nama_lengkap',
      'nama_panggilan',
      'tempat_lahir',
      'tanggal_lahir',
      'jenis_kelamin',
      'pendidikan',
      'alamat',
      'regencies_id',
      'districts_id',
      'villages_id',
      'telp',
      'job',
      'awal_anggota',
      'jenjang_anggota',
      'usia_jenjang',
      'binaan',
      'nama_pasangan',
      'status_pernikahan',
      'darah',
      'amanah',
      'created_by',
      'updated_by',
      'deleted_by'
  ];
}
