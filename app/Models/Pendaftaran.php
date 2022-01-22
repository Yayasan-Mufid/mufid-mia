<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'kode',
        'email',
        'nama',
        'nohp_whatsapp',
        'nohp_telegram',
        'alamat',
        'tgl_lahir',
        'gender',
        'domisili',
        'angkatan',
        'konfirmasi',
        'tolak_tf',
        'status',
        'bukti_tf',
        'waktu_konfirmasi',
        'waktu_tolak_tf',
        'nominal',
        'Keterangan'
    ];

    public function scopeMenungguKonfirmasi($query)
    {
        return $query->where('status', '=', 1);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', '=', 2);
    }

    public function scopeIkhwan($query)
    {
        return $query->where('gender', '=', 'L');
    }

    public function scopeAkhwat($query)
    {
        return $query->where('gender', '=', 'P');
    }
}
