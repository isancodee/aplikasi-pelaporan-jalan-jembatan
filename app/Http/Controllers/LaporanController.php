<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Survei;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

use App\Exports\SurveiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanStatusExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function laporanRekapitulasi(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan'); // Bisa kosong (semua bulan)

        // Query utama untuk laporan bulanan
        $query = Aduan::whereYear('created_at', $tahun);

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        // Rekap jumlah laporan per bulan dengan laporan selesai
        $rekapBulanan = Aduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total, SUM(CASE WHEN status = "Selesai" THEN 1 ELSE 0 END) as selesai')
            ->whereYear('created_at', $tahun)
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('created_at', $bulan);
            })
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Rekap jumlah laporan per jenis aduan
        $rekapJenis = Aduan::selectRaw('jenis_aduan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('created_at', $bulan);
            })
            ->groupBy('jenis_aduan')
            ->get();

        // Hitung persentase laporan selesai (tanpa groupBy)
        $totalLaporan = $query->count();
        $totalSelesai = $query->where('status', 'Selesai')->count();
        $persentaseSelesai = $totalLaporan > 0 ? ($totalSelesai / $totalLaporan) * 100 : 0;

        // Ambil data lokasi aduan untuk peta
        $lokasiAduan = Aduan::select('id', 'jenis_aduan', 'latitude', 'longitude', 'status')
            ->whereYear('created_at', $tahun)
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('created_at', $bulan);
            })->get();

        return view('admin.laporan.rekapitulasi', compact('tahun', 'bulan', 'rekapBulanan', 'rekapJenis', 'persentaseSelesai', 'lokasiAduan'));
    }
    public function exportRekapitulasiPDF(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan');

        // Ambil data yang sama seperti laporan rekapitulasi
        $query = Aduan::whereYear('created_at', $tahun);
        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        $rekapBulanan = Aduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total, SUM(CASE WHEN status = "Selesai" THEN 1 ELSE 0 END) as selesai')
            ->whereYear('created_at', $tahun)
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('created_at', $bulan);
            })
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $rekapJenis = Aduan::selectRaw('jenis_aduan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('created_at', $bulan);
            })
            ->groupBy('jenis_aduan')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.rekapitulasi_pdf', compact('tahun', 'bulan', 'rekapBulanan', 'rekapJenis'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Rekapitulasi_{$tahun}.pdf");
    }

    public function laporanStatus(Request $request)
    {
        $tindakan = $request->input('tindakan');
        $tanggal = $request->input('tanggal');

        $lokasi = $request->input('lokasi');

        $query = Perbaikan::with(['aduan', 'petugas'])->whereNotNull('tindakan');


        if (!empty($tindakan)) {
            $query->where('tindakan', $tindakan);
        }

        // Filter berdasarkan rentang tanggal menggunakan created_at
        if (!empty($tanggal)) {
            $query->whereDate('created_at', $tanggal);
        }

        if (!empty($lokasi)) {
            $query->whereHas('aduan', function ($q) use ($lokasi) {
                $q->where('lokasi', 'LIKE', '%' . $lokasi . '%');
            });
        }

        $laporan = $query->get();

        return view('admin.laporan.status_penanganan', compact('laporan', 'tindakan', 'tanggal', 'lokasi'));
    }

    public function exportPDF()
    {
        $laporan = Perbaikan::with(['aduan', 'petugas'])->whereNotNull('tindakan')->get();
        $pdf = Pdf::loadView('admin.laporan.pdfPenanganan', compact('laporan'));
        return $pdf->download('laporan_status_penanganan.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanStatusExport, 'Laporan_Status_Penanganan.xlsx');
    }

    public function reportLokasi(Request $request)
    {
        $query = Aduan::select('id', 'jenis_aduan', 'keterangan', 'latitude', 'longitude', 'tingkat_keparahan', 'foto')
            ->whereNotNull(['latitude', 'longitude']); // Hanya ambil yang punya lokasi
        // Filter berdasarkan jenis kerusakan
        if ($request->has('jenis_kerusakan') && $request->jenis_kerusakan != '') {
            $query->where('tingkat_keparahan', $request->jenis_kerusakan);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Ambil data laporan setelah filter
        $laporan = $query->get();

        return view('admin.petaKerusakan.index', compact('laporan'));
    }

    public function downloadLaporanPDF(Request $request)
    {
        // Ambil data laporan yang sudah difilter
        $laporan = Aduan::select('id', 'jenis_aduan', 'keterangan', 'latitude', 'longitude', 'tingkat_keparahan', 'foto')
            ->whereNotNull(['latitude', 'longitude']) // Hanya ambil yang punya lokasi
            ->when($request->jenis_kerusakan, function ($query) use ($request) {
                return $query->where('jenis_aduan', $request->jenis_kerusakan);
            })
            ->when($request->tanggal_awal && $request->tanggal_akhir, function ($query) use ($request) {
                return $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
            })
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('admin.petaKerusakan.pdf', compact('laporan'));

        // Download PDF
        return $pdf->download('laporan_kerusakan.pdf');
    }

    public function pekerjal(Request $request)
    {
        // Mengambil filter kecamatan dari request
        $kecamatan = $request->input('kecamatan');

        // Mengambil data survei beserta relasi ke Aduan
        if ($kecamatan) {
            // Jika ada filter kecamatan, ambil data yang sesuai
            $surveis = Survei::with('aduan')
                ->whereHas('aduan', function ($query) use ($kecamatan) {
                    $query->where('kecamatan', 'like', "%$kecamatan%");
                })
                ->get();
        } else {
            // Jika tidak ada filter, ambil semua data
            $surveis = Survei::with('aduan')->get();
        }

        return view('admin.laporan.peringkatKerusakan', compact('surveis'));
    }
    // Metode untuk mengunduh laporan dalam format PDF
    public function downloadPDF(Request $request)
    {
        $surveis = Survei::with('aduan')
            ->when($request->kecamatan, function ($query) use ($request) {
                return $query->whereHas('aduan', function ($q) use ($request) {
                    $q->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
                });
            })
            ->get();

        $pdf = PDF::loadView('admin.laporan.peringkatKerusakanPdf', compact('surveis'));
        return $pdf->download('laporan_peringkat_kerusakan.pdf');
    }


    // Metode untuk mengunduh laporan dalam format Excel
    public function downloadExcel(Request $request)
    {
        $surveis = Survei::with('aduan')
            ->when($request->kecamatan, function ($query) use ($request) {
                return $query->whereHas('aduan', function ($q) use ($request) {
                    $q->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
                });
            })
            ->get();

        return Excel::download(new SurveiExport($surveis), 'laporan_peringkat_kerusakan.xlsx');
    }
}
