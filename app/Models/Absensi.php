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

    public function jadwalPelajaran()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal_pelajaran');
    }
}
