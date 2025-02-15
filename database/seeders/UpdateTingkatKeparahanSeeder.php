<?php
namespace Database\Seeders;

use App\Models\Aduan;
use Illuminate\Database\Seeder;

class UpdateTingkatKeparahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 1 data pengaduan untuk masing-masing tingkat keparahan
        $ringan = Aduan::first();  // Ambil data pertama untuk Ringan
        $sedang = Aduan::skip(1)->first();  // Ambil data kedua untuk Sedang
        $parah = Aduan::skip(2)->first();  // Ambil data ketiga untuk Parah

        // Tentukan tingkat keparahan
        if ($ringan) {
            $ringan->tingkat_keparahan = 'Ringan';
            $ringan->save();
        }

        if ($sedang) {
            $sedang->tingkat_keparahan = 'Sedang';
            $sedang->save();
        }

        if ($parah) {
            $parah->tingkat_keparahan = 'Parah';
            $parah->save();
        }

        echo "Tingkat keparahan berhasil diperbarui untuk 3 pengaduan!\n";
    }
}
