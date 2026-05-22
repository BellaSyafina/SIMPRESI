<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertemuanPelajaran extends Model
{
    protected $table = 'pertemuan_pelajaran';
    protected $primaryKey = 'id_pertemuan';
    protected $guarded = ['id_pertemuan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal_pelajaran');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_pertemuan', 'id_pertemuan');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'selesai' => 'success',
            'dibatalkan' => 'danger',
            default => 'warning',
        };
    }
}
