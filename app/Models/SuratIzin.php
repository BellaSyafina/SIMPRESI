<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratIzin extends Model
{
    protected $table = 'surat_izin';
    protected $primaryKey = 'id_surat_izin';
    protected $guarded = ['id_surat_izin'];

    public $timestamps = true;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}
