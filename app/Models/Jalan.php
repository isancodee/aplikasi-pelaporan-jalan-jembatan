<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    protected $table = 'jalans';
    protected $fillable = [
        'nama_jalan',
        'panjang_jalan',
        'kondisi_jalan'
    ];
}
