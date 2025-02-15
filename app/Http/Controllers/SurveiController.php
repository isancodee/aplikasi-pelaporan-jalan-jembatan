<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aduan;
use App\Models\Jalan;
use App\Models\Survei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveiController extends Controller
{
    public function index()
    {
        $surveis = Survei::with('aduan', 'petugas')->orderBy('created_at', 'desc')->get();
        return view('admin.survei.index', compact('surveis'));
    }

    public function create($aduan_id)
    {
        $aduan = Aduan::findOrFail($aduan_id);
        $petugas = User::where('role', 'petugas')->get(); // Ambil daftar petugas

        return view('petugas.survei.create', compact('aduan', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aduan_id' => 'required|exists:aduans,id',
            'tindakan' => 'required|string',
            'rencana_biaya' => 'required|numeric|min:1000|max:999999999999',
            'foto_survei' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil petugas ID dari Auth jika sudah login, jika tidak dari request
        $petugas_id = Auth::check() ? Auth::id() : $request->petugas_id;

        if (!$petugas_id) {
            return back()->withErrors(['petugas_id' => 'Petugas harus dipilih.']);
        }

        // Simpan file foto survei
        $fotoPath = $request->file('foto_survei')->store('survei', 'public');

        // Simpan hasil survei ke database
        Survei::create([
            'aduan_id' => $request->aduan_id,
            'petugas_id' => $petugas_id,
            'tindakan' => $request->tindakan,
            'rencana_biaya' => $request->rencana_biaya,
            'foto_survei' => $fotoPath,
        ]);

        return redirect()->route('petugas.dashboard')->with('success', 'Hasil survei berhasil disimpan!');
    }

    public function destroy($id)
    {
        $survei = Survei::findOrFail($id);
        $survei->delete();

        return redirect()->route('admin.survei.index')->with('success', 'Survei  berhasil dihapus.');
    }

    public function approve($id)
    {
        $survei = Survei::findOrFail($id);
        $survei->status = 'disetujui';
        $survei->save();

        // Ubah status aduan juga
        $aduan = Aduan::findOrFail($survei->aduan_id);
        $aduan->status = 'disetujui';
        $aduan->save();

        return redirect()->route('admin.survei.index')->with('success', 'Survei berhasil disetujui dan status aduan diperbarui!');
    }


    public function reject($id)
    {
        $survei = Survei::findOrFail($id);
        $survei->status = 'ditolak';
        $survei->save();

        return redirect()->route('admin.survei.index')->with('error', 'Survei telah ditolak.');
    }

    public function peringkatKerusakan()
    {
        // Ambil jalan dengan jumlah laporan kerusakan terbanyak
        $jalanPeringkat = Jalan::withCount('aduans')
            ->orderByDesc('aduans_count')
            ->get();

        return view('admin.laporan.peringkatKerusakan', compact('jalanPeringkat'));
    }
}
 // public function store(Request $request, $aduan_id)
    // {
    //     $request->validate([
    //         'tindakan' => 'required|string',
    //         'rencana_biaya' => 'required|numeric',
    //         'foto_survei' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $fotoPath = null;
    //     if ($request->hasFile('foto_survei')) {
    //         $fotoPath = $request->file('foto_survei')->store('survei_foto', 'public');
    //     }

    //     Survei::create([
    //         'aduan_id' => $aduan_id,
    //         'petugas_id' => Auth::id(),
    //         'tindakan' => $request->tindakan,
    //         'rencana_biaya' => $request->rencana_biaya,
    //         'foto_survei' => $fotoPath,
    //     ]);

    //     // Ubah status aduan menjadi "disetujui"
    //     $aduan = Aduan::findOrFail($aduan_id);
    //     $aduan->update(['status' => 'disetujui']);

    //     return redirect()->route('petugas.aduan')->with('success', 'Hasil survei berhasil disimpan!');
    // }