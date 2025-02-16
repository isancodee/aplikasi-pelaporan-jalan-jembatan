<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aduan;
use App\Models\Survei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function dashboard()
    {
        // Ambil semua aduan yang statusnya "diproses" atau "disetujui"
        $aduans = Aduan::whereIn('status', ['diproses', 'disetujui'])
            ->with(['survei', 'perbaikan'])  // Eager load relasi survei dan perbaikan
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('petugas.dashboard', compact('aduans'));
    }


    // Menampilkan daftar petugas
    public function index()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    // Menyimpan petugas baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas' // Default role petugas
        ]);

        return redirect()->route('petugas')->with('success', 'Petugas berhasil ditambahkan.');
    }

    // Menghapus petugas

    // Menghapus petugas
    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }


    public function formSurvei($id)
    {
        $aduan = Aduan::findOrFail($id);
        $petugas = User::where('role', 'petugas')->get(); // Ambil daftar petugas dari database
        return view('petugas.input_hasil_survei', compact('aduan', 'petugas'));
    }

    public function simpanSurvei(Request $request, $id)
    {
        $request->validate([
            'aduan_id' => 'required|exists:aduans,id',
            'tindakan' => 'required|string',
            'rencana_biaya' => 'required|numeric',
            'foto_survei' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika sudah pakai login, gunakan Auth::id() sebagai petugas_id
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
}
