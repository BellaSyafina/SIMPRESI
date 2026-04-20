<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    // Nama tabel di database
    protected $table = 'kelas';

    // Primary key
    protected $primaryKey = 'id_kelas';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_kelas',
        'wali_kelas',
        'ruang',
        'jumlah_siswa',
        'tingkat'
    ];

    public $timestamps = true;
}
