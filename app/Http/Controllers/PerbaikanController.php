<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerbaikanController extends Controller
{
    public function index()
    {
        $perbaikans = Perbaikan::orderBy('created_at', 'desc')->get();
        return view('petugas.perbaikan.index', compact('perbaikans'));
    }

    public function create($aduan_id)
    {
        $aduan = Aduan::findOrFail($aduan_id);
        return view('petugas.perbaikan.create', compact('aduan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aduan_id' => 'required|exists:aduans,id',
            'tindakan' => 'required|string',
            'dana_digunakan' => 'required|numeric',
            'foto_sebelum_perbaikan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_perbaikan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto sebelum perbaikan
        $fotoSebelumPath = $request->file('foto_sebelum_perbaikan')->store('perbaikan/sebelum', 'public');

        // Simpan foto setelah perbaikan
        $fotoPerbaikanPath = $request->file('foto_perbaikan')->store('perbaikan/setelah', 'public');

        // Ambil aduan
        $aduan = Aduan::findOrFail($request->aduan_id);

        // Jika aduan belum memiliki petugas, gunakan petugas yang sedang login
        $petugas_id = $aduan->petugas_id ?? auth()->id();

        // Simpan data ke database
        Perbaikan::create([
            'aduan_id' => $aduan->id,
            'petugas_id' => $petugas_id,
            'tindakan' => $request->tindakan,
            'dana_digunakan' => $request->dana_digunakan,
            'foto_sebelum_perbaikan' => $fotoSebelumPath,
            'foto_perbaikan' => $fotoPerbaikanPath,
        ]);

        return redirect()->route('petugas.dashboard')->with('success', 'Laporan hasil perbaikan berhasil disimpan!');
    }

    public function show($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        return view('petugas.perbaikan.show', compact('perbaikan'));
    }

    public function edit($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        return view('petugas.perbaikan.edit', compact('perbaikan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tindakan' => 'required|string',
            'dana_digunakan' => 'required|numeric',
            'foto_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $perbaikan = Perbaikan::findOrFail($id);

        // Cek apakah ada foto baru diupload
        if ($request->hasFile('foto_perbaikan')) {
            $fotoPath = $request->file('foto_perbaikan')->store('perbaikan', 'public');
            $perbaikan->foto_perbaikan = $fotoPath;
        }

        $perbaikan->tindakan = $request->tindakan;
        $perbaikan->dana_digunakan = $request->dana_digunakan;
        $perbaikan->save();

        return redirect()->route('petugas.perbaikan.index')->with('success', 'Laporan perbaikan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Perbaikan::findOrFail($id)->delete();
        return redirect()->route('admin.laporan.perbaikan')->with('success', 'Laporan berhasil dihapus');
    }

    public function laporanPerbaikan()
    {
        // Ambil semua laporan perbaikan
        $laporanPerbaikan = Perbaikan::with('aduan', 'petugas')->latest()->get();

        return view('admin.aduan.laporan_perbaikan', compact('laporanPerbaikan'));
    }

    public function ubahStatusAduan($id)
    {
        // Update status aduan menjadi 'Selesai'
        $updated = Aduan::where('id', $id)->update(['status' => 'Selesai']);

        if ($updated) {
            // Redirect ke halaman laporan perbaikan dengan pesan sukses
            return redirect()->route('admin.laporan.perbaikan')->with('success', 'Status aduan berhasil diubah menjadi Selesai!');
        }

        return redirect()->route('admin.laporan.perbaikan')->with('error', 'Gagal mengubah status aduan.');
    }

    
}
