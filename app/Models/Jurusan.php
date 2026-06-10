<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusans';

    // WAJIB: Beritahu Laravel kalau primary key-nya adalah id_jurusan
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'nama_jurusan',
        'akreditasi'
    ];
}