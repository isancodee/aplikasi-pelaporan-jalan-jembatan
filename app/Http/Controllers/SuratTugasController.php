<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aduan;
use PDF; // Tambahkan ini di bagian atas
use App\Models\SuratTugas;
use Illuminate\Http\Request;

class SuratTugasController extends Controller
{
    public function index()
    {
        $suratTugas = SuratTugas::with(['aduan', 'petugas'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.surat_tugas.index', compact('suratTugas'));
    }

    public function suratPetugas()
    {
        $suratTugas = SuratTugas::with(['aduan', 'petugas'])->orderBy('created_at', 'desc')->paginate(10);
        return view('petugas.survei.surat_tugas', compact('suratTugas'));
    }

    public function create($aduan_id)
    {
        $aduan = Aduan::findOrFail($aduan_id);
        $petugas = User::where('role', 'petugas')->get();

        return view('admin.surat_tugas.create', compact('aduan', 'petugas'));
    }

    public function store(Request $request, $aduan_id)
    {
        // Debugging untuk memastikan request data
        // dd($request->all());

        $request->validate([
            'petugas_id' => 'required|exists:users,id',
            'nomor_surat' => 'required|unique:surat_tugas,nomor_surat',
            'tanggal_tugas' => 'required|date',
            'deskripsi_tugas' => 'nullable|string',
        ]);

        $aduan = Aduan::findOrFail($aduan_id);

        SuratTugas::create([
            'aduan_id' => $aduan->id,
            'petugas_id' => $request->petugas_id,
            'nomor_surat' => $request->nomor_surat, // Pastikan data ini dikirim
            'tanggal_tugas' => $request->tanggal_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
        ]);

        // Ubah status aduan menjadi "disetujui"
        $aduan->update(['status' => 'diproses']);

        return redirect()->route('admin.aduan.penugasan')->with('success', 'Surat tugas berhasil dibuat!');
    }

    public function destroy($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);
        $suratTugas->delete();

        return redirect()->route('admin.surat_tugas.index')->with('success', 'Surat tugas berhasil dihapus.');
    }



    public function lihatPDF($id)
    {
        $surat = SuratTugas::with(['aduan', 'petugas'])->findOrFail($id);

        $pdf = PDF::loadView('admin.surat_tugas.pdf', compact('surat'));
        return $pdf->stream('Surat_Tugas_' . $surat->nomor_surat . '.pdf');
    }
}
