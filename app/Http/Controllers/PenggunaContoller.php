<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class PenggunaContoller extends Controller
{
    public function index()
    {
        // Ambil data aduan dengan pagination
        $aduans = Aduan::paginate(10);

        return view('pengguna.pengaduan.daftarAduan', compact('aduans'));
    }
}
