<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tindakan extends Model
{
    use HasFactory;

    protected $table = 'tindakans'; // Nama tabel di database
    protected $fillable = [
        'aduan_id',
        'petugas_id',
        'tanggal_tindakan',
        'deskripsi',
        'foto_sebelum',
        'foto_sesudah',
        'biaya',
        'status',
    ];

    // Relasi ke Aduan
    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id')->where('role', 'petugas');
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
