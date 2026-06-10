<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    // Nama tabel di database phpMyAdmin kamu
    protected $table = 'mahasiswa'; 

    // WAJIB: Beritahu Laravel kalau primary key kamu bukan 'id'
    protected $primaryKey = 'id_mahasiswa';

    // Jika primary key kamu bukan auto-incrementing integer, ubah ke false (tapi biasanya true)
    public $incrementing = true;

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'id_jurusan'
    ];

    /**
     * Relasi belongsTo ke Model Jurusan
     */
    public function detail_jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}