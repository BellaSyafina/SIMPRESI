<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $primaryKey = 'id_notifikasi';

protected $fillable = [
    'id_siswa',
    // 'id_orang_tua', // HAPUS baris ini karena tidak ada di tabel
    'pesan',
    'status',
    'retry_count',
    'waktu_kirim',
];

    // Relasi ke siswa (opsional)
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}
