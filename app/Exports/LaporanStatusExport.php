<?php

namespace App\Exports;

use App\Models\Perbaikan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanStatusExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Perbaikan::with(['aduan', 'petugas'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Kerusakan',
            'Tindakan',
            'Tanggal Penanganan',
            'Petugas',
            'Biaya',
            'Foto Sebelum',
            'Foto Sesudah'
        ];
    }

    public function map($item): array
    {
        return [
            $item->id, // No
            $item->aduan->jenis_aduan ?? '-', // Jenis Kerusakan
            $item->tindakan ?? '-', // Tindakan
            $item->created_at ? $item->created_at->format('d M Y') : '-', // Tanggal Penanganan
            $item->petugas->name ?? '-', // Petugas
            'Rp ' . number_format($item->dana_digunakan, 0, ',', '.'), // Biaya
            $item->foto_sebelum_perbaikan ? Storage::url($item->foto_sebelum_perbaikan) : 'Tidak ada', // Foto Sebelum (Link)
            $item->foto_perbaikan ? Storage::url($item->foto_perbaikan) : 'Belum ada', // Foto Sesudah (Link)
        ];
    }
}
