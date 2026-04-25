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
    protected $guarded = ['id_kelas'];

    public $timestamps = true;

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
