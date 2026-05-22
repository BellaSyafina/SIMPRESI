<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiPelajaran extends Model
{
    protected $table = 'sesi_pelajaran';
    protected $primaryKey = 'id_sesi';
    protected $guarded = ['id_sesi'];

    public $timestamps = false;

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'id_sesi', 'id_sesi');
    }
}
