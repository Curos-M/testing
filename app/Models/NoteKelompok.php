<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoteKelompok extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'note_kelompok';
  protected $fillable = [
    'id_kelompok',
    'catatan',
    'photo',
    'created_by',
    'updated_by'
  ];
}
