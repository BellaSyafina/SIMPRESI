<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporanAbsensi extends Model
{
     use HasFactory;

    protected $table = 'laporan_absensi';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_siswa',
        'id_jadwal_pelajaran',
        'tanggal',
        'status',
        'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal_pelajaran');
    }
}
