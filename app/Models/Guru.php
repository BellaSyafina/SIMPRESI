<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    // nama tabel
    protected $table = 'guru';

    // primary key custom
    protected $primaryKey = 'id_guru';

    // biar Laravel gak bingung tipe ID
    public $incrementing = true;

    protected $keyType = 'int';

    // kolom yang boleh diisi
    protected $fillable = [
        'nuptk',
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'jabatan',
        'alamat',
        'id_user'
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
