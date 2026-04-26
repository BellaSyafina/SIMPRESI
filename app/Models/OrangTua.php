<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';
    protected $primaryKey = 'id_orang_tua';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = ['id_orang_tua'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_orang_tua');
    }
}
