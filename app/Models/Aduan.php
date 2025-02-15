<?php

namespace App\Models;

use App\Models\Tindakan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aduan extends Model
{
    use HasFactory;

    protected $table = 'aduans';
    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'tgl_aduan',
        'jenis_aduan',
        'keterangan',
        'alamat',
        'kecamatan',
        'latitude',
        'longitude',
        'foto',
        'status',
        'tanggapan',
        'petugas_id',
        'jadwal_survei'
    ];

    public function survei()
    {
        return $this->hasOne(Survei::class, 'aduan_id');
    }

    public function perbaikan()
    {
        return $this->hasOne(Perbaikan::class, 'aduan_id');
    }

    public function suratTugas()
    {
        return $this->hasOne(SuratTugas::class, 'aduan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Relasi ke Tindakan (pastikan ada model Tindakan)
    public function tindakan()
    {
        return $this->hasOne(Tindakan::class, 'aduan_id');
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }
}
