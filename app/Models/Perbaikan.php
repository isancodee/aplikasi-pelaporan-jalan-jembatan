<?php

namespace App\Models;

use App\Models\User;
use App\Models\Aduan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'aduan_id',
        'petugas_id',
        'tindakan',
        'foto_sebelum_perbaikan',
        'foto_perbaikan',
        'dana_digunakan',
    ];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
