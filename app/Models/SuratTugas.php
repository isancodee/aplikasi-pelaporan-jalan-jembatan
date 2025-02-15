<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';
    protected $fillable = ['aduan_id', 'petugas_id', 'nomor_surat', 'tanggal_tugas', 'deskripsi_tugas'];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
