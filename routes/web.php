<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaContoller;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuratTugasController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// PENGGUNA
Route::get('pengguna/daftarAduan', [PenggunaContoller::class, 'index'])->name('penggunaDaftarAduan');

Route::get('/aduan', [AduanController::class, 'index'])->name('aduan.index');
Route::get('/aduanTampil', [AduanController::class, 'tampil'])->name('aduanTampil.index');
Route::get('/aduan/{id}', [AduanController::class, 'show'])->name('aduan.show');
Route::get('/aduan/create', [AduanController::class, 'create'])->name('aduan.create');
Route::post('/aduan', [AduanController::class, 'store'])->name('aduan.store');



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AduanController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/aduan', [AduanController::class, 'daftarAduan'])->name('admin.aduan');
    Route::get('/admin/aduanMasyarakat', [AduanController::class, 'aduanMasyarakat'])->name('aduanMasyarakat');
    Route::post('/aduan/{id}/tanggapan', [AduanController::class, 'beriTanggapan'])->name('aduan.tanggapan');
    Route::get('/admin/laporan-perbaikan', [PerbaikanController::class, 'laporanPerbaikan'])->name('admin.laporan.perbaikan');
    Route::post('/admin/aduan/{id}/selesai', [PerbaikanController::class, 'ubahStatusAduan'])->name('admin.aduan.selesai');
    Route::delete('aduan/{id}', [AduanController::class, 'destroy'])->name('aduan.destroy');
    Route::delete('/laporan-perbaikan/{id}', [PerbaikanController::class, 'destroy'])->name('admin.laporan.perbaikan.destroy');

    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
    Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');

    Route::post('/admin/aduan/{id}/tugaskan', [AduanController::class, 'tugaskanPetugas'])->name('admin.aduan.tugaskan.store');
    Route::get('/admin/aduan/penugasan', [AduanController::class, 'listPenugasan'])->name('admin.aduan.penugasan');
    Route::get('/admin/aduan/{id}/tugaskan', [AduanController::class, 'pilihPetugas'])->name('admin.aduan.tugaskan');

    Route::post('/admin/aduan/{id}/update-status', [AduanController::class, 'updateStatus'])->name('admin.aduan.updateStatus');

    // SURATT TUGAS
    Route::get('/admin/surat-tugas', [SuratTugasController::class, 'index'])->name('admin.surat_tugas.index');
    Route::get('/admin/surat-tugas/{aduan_id}/create', [SuratTugasController::class, 'create'])->name('admin.surat_tugas.create');
    Route::post('/admin/surat-tugas/{aduan_id}', [SuratTugasController::class, 'store'])->name('admin.surat_tugas.store');
    Route::get('/admin/surat-tugas/{id}/lihat', [SuratTugasController::class, 'lihatPDF'])->name('admin.surat_tugas.lihat');
    Route::delete('/admin/surat_tugas/{id}', [SuratTugasController::class, 'destroy'])->name('admin.surat_tugas.hapus');

    // APROVE HASIL SURVEI
    Route::get('/admin/survei', [SurveiController::class, 'index'])->name('admin.survei.index');
    Route::post('/admin/survei/{id}/approve', [SurveiController::class, 'approve'])->name('admin.survei.approve');
    Route::post('/admin/survei/{id}/reject', [SurveiController::class, 'reject'])->name('admin.survei.reject');
    Route::delete('/admin/survei/{id}', [SurveiController::class, 'destroy'])->name('survei.destroy');

    // REKAPITUSI KERUSAKAN BULANAN
    Route::get('/admin/laporan/rekapitulasi', [LaporanController::class, 'laporanRekapitulasi'])->name('admin.laporan.rekapitulasi');
    Route::get('/laporan-rekapitulasi/pdf', [LaporanController::class, 'exportRekapitulasiPDF'])->name('admin.laporan.rekapitulasi.pdf');
    // LAPORAN PENANGANAN
    Route::get('/admin/laporan/status-penanganan', [LaporanController::class, 'laporanStatus'])->name('admin.laporan.status_penanganan');
    Route::get('/admin/laporan/status-penanganan/export-pdf', [LaporanController::class, 'exportPDF'])->name('admin.laporan.status_penanganan.export_pdf');
    Route::get('/admin/laporan/status-penanganan/export-excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.status_penanganan.export_excel');
    // PETA KERUSAKAN
    Route::get('/report-lokasi', [LaporanController::class, 'reportLokasi'])->name('report.lokasi');
    Route::get('/laporan/download-pdf', [LaporanController::class, 'downloadLaporanPDF'])->name('laporan.download_pdf');

    Route::prefix('admin')->group(function () {
        Route::get('/aduan/pdf', [AduanController::class, 'generatePDF'])->name('aduan.pdf');
    });
    Route::get('admin/laporan/pekerjal', [LaporanController::class, 'pekerjal'])->name('pekerjal');
    Route::get('/laporan/pdf', [LaporanController::class, 'downloadPDF'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'downloadExcel'])->name('laporan.excel');
});




// PETUGAS
// UPLOAD HASIL SURVEI OLEH PETUGAS
Route::middleware(['auth', 'petugas'])->group(function () {
    Route::get('/petugas/aduan/{id}/survei', [SurveiController::class, 'create'])->name('petugas.survei.create');
    Route::post('/petugas/aduan/{id}/survei', [SurveiController::class, 'store'])->name('petugas.survei.store');
    Route::get('/petugas/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/petugas/survei/{id}', [PetugasController::class, 'formSurvei'])->name('petugas.survei.form');
    Route::post('/petugas/survei/{id}/simpan', [PetugasController::class, 'simpanSurvei'])->name('petugas.survei.simpan');

    // SURAT TUGAS
    Route::get('/petugas/surat-tugas', [SuratTugasController::class, 'suratPetugas'])->name('suratPetugas');

    // PERBAIKAN OLEH PETUGAS
    Route::get('petugas/perbaikan', [PerbaikanController::class, 'index'])->name('petugas.perbaikan.index');
    Route::get('petugas/perbaikan/{id}', [PerbaikanController::class, 'show'])->name('petugas.perbaikan.show');
    Route::get('petugas/perbaikan/{id}/edit', [PerbaikanController::class, 'edit'])->name('petugas.perbaikan.edit');
    Route::put('petugas/perbaikan/{id}/update', [PerbaikanController::class, 'update'])->name('petugas.perbaikan.update');
    Route::get('petugas/aduan/{id}/perbaikan', [PerbaikanController::class, 'create'])->name('petugas.perbaikan.create');
    Route::post('petugas/perbaikan/store', [PerbaikanController::class, 'store'])->name('petugas.perbaikan.store');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
