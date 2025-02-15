<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $fillable = ['aduan_id', 'petugas_id', 'tindakan', 'rencana_biaya', 'foto_survei'];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
