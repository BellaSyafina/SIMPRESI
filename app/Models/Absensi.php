<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';

    public $incrementing = true;

    protected $keyType = 'int';
    protected $guarded = ['id_absensi'];

    // 🔥 relasi siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // 🔥 relasi pertemuan
    public function pertemuan()
    {
        return $this->belongsTo(PertemuanPelajaran::class, 'id_pertemuan', 'id_pertemuan');
    }

    // 🔥 helper badge
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'hadir' => 'success',
            'izin' => 'warning',
            'sakit' => 'info',
            'alpa' => 'danger',

            default => 'secondary',
        };
    }

    public function suratIzin()
    {
        return $this->hasOne(SuratIzin::class, 'id_siswa', 'id_siswa')
        ->whereDate('tanggal', optional($this->pertemuan)->tanggal);
    }
}
