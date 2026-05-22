<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $primaryKey = 'id_jadwal_pelajaran';

    protected $guarded = ['id_jadwal_pelajaran'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function sesi()
    {
        return $this->belongsTo(SesiPelajaran::class, 'id_sesi');
    }

    public function pertemuan()
    {
        return $this->hasMany(PertemuanPelajaran::class, 'id_jadwal_pelajaran', 'id_jadwal_pelajaran');
    }
}
