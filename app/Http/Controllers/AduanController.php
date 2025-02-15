<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aduan;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AduanController extends Controller
{
    public function index()
    {
        $aduans = Aduan::orderBy('created_at', 'desc')->get();
        return view('pengguna.pengaduan.index', compact('aduans'));
    }

    public function store(Request $request)
    {
        // Debug data yang dikirimkan untuk memastikan kecamatan ada
        // dd($request->all());

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_telp' => 'required|string',
            'tgl_aduan' => 'required|date',
            'jenis_aduan' => 'required|string',
            'keterangan' => 'required|string',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string', // Menambahkan validasi untuk kecamatan
            'latitude' => 'required',
            'longitude' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menyimpan foto
        $path = $request->file('foto')->store('aduan', 'public');

        // Menyimpan data ke database
        $aduan = Aduan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'tgl_aduan' => $request->tgl_aduan,
            'jenis_aduan' => $request->jenis_aduan,
            'keterangan' => $request->keterangan,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan, // Menyimpan kecamatan
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto' => $path,
            'status' => 'Menunggu Tanggapan'
        ]);

        return view('welcome')->with('success', 'Pengaduan berhasil dikirim!');
    }



    public function show($id)
    {
        $aduan = Aduan::findOrFail($id);
        return view('pengguna.pengaduan.show', compact('aduan'));
    }

    public function update(Request $request, $id)
    {
        $aduan = Aduan::findOrFail($id);
        $aduan->update($request->all());
        return view('pengguna.pengaduan.show', compact('aduan'));
    }

    public function destroy($id)
    {
        Aduan::findOrFail($id)->delete();
        return redirect()->route('admin.aduan')->with('success', 'Aduan berhasil dihapus');
    }

    public function tampil(Request $request)
    {
        $query = Aduan::query();

        // Pencarian berdasarkan nama atau jenis aduan
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('jenis_aduan', 'like', "%$search%");
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination
        $aduans = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('pengguna.pengaduan.tampil', compact('aduans'));
    }

    public function dashboard()
    {
        $totalAduan = Aduan::count();
        $aduanBaru = Aduan::where('status', 'Menunggu Tanggapan')->count();
        $aduanDiproses = Aduan::where('status', 'diproses')->count();
        $aduanDisetujui = Aduan::where('status', 'disetujui')->count();
        $aduanSelesai = Aduan::where('status', 'selesai')->count();
        $aduanTerbaru = Aduan::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalAduan',
            'aduanBaru',
            'aduanDiproses',
            'aduanDisetujui',
            'aduanSelesai',
            'aduanTerbaru'
        ));
    }

    public function daftarAduan(Request $request)
    {
        $query = Aduan::orderBy('created_at', 'desc');

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pencarian nama/alamat
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        $aduans = $query->paginate(10); // Pagination

        return view('admin.aduan.index', compact('aduans'));
    }




    public function beriTanggapan(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string',
        ]);

        $aduan = Aduan::findOrFail($id);
        $aduan->update([
            'tanggapan' => $request->tanggapan,
            'status' => 'diproses' // Ubah status jika diperlukan
        ]);

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Tanggapan,diproses,disetujui,selesai'
        ]);

        $aduan = Aduan::findOrFail($id);
        $aduan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }


    public function formTugaskan($id)
    {
        $aduan = Aduan::findOrFail($id);
        $petugas = User::where('role', 'petugas')->get(); // Ambil daftar petugas dari tabel user
        return view('admin.aduan.tugaskan', compact('aduan', 'petugas'));
    }

    public function listPenugasan()
    {
        $aduans = Aduan::whereIn('status', ['Menunggu Tanggapan', 'diproses'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $petugas = User::where('role', 'petugas')->get();

        return view('admin.aduan.penugasan', compact('aduans', 'petugas'));
    }



    public function tugaskanPetugas(Request $request, $id)
    {
        $request->validate([
            'petugas_id' => 'required|exists:users,id',
        ]);

        $aduan = Aduan::findOrFail($id);
        $aduan->update([
            'petugas_id' => $request->petugas_id,
            'status' => 'diproses',
        ]);

        return redirect()->route('admin.aduan.penugasan')->with('success', 'Petugas berhasil ditugaskan!');
    }



    public function pilihPetugas($id)
    {
        $aduan = Aduan::findOrFail($id);
        $petugas = User::where('role', 'petugas')->get(); // Ambil hanya user dengan role petugas
        return view('admin.aduan.tugaskan', compact('aduan', 'petugas'));
    }

    public function aduanMasyarakat()
    {
        // Mengambil data aduan dengan status 'selesai'
        $aduans = Aduan::where('status', 'selesai')->paginate(10);

        // Mengirim data ke view
        return view('admin.laporan.aduanMasyarakat', compact('aduans'));
    }

    public function generatePDF()
    {
        // Ambil hanya aduan dengan status 'selesai'
        $aduans = Aduan::where('status', 'selesai')->get();

        $pdf = Pdf::loadView('admin.laporan.aduan_pdf', compact('aduans'));
        return $pdf->stream('laporan-aduan.pdf');
    }
}
