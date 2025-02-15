<?php

namespace App\Exports;

use App\Models\Survei;
use Maatwebsite\Excel\Concerns\FromCollection;

class SurveiExport implements FromCollection
{
    protected $surveis;

    public function __construct($surveis)
    {
        $this->surveis = $surveis;
    }

    public function collection()
    {
        return $this->surveis;
    }

    public function headings(): array
    {
        return [
            'No',
            'Alamat',
            'Kecamatan',
            'Tindakan',
            'Kondisi Jalan',
            'Foto Survei',
        ];
    }

    public function map($survei): array
    {
        return [
            $survei->aduan->id, // Menambahkan ID jika perlu
            $survei->aduan->alamat,
            $survei->aduan->kecamatan,
            $survei->tindakan,
            $survei->aduan->tingkat_keparahan,
            asset('storage/' . $survei->foto_survei),
        ];
    }
}
