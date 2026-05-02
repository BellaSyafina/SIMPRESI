<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mata_pelajaran';
    protected $guarded = ['id_mata_pelajaran'];

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran', 'id_mata_pelajaran', 'id_guru');
    }
}
