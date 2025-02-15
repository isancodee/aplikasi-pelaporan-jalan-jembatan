<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Status Penanganan Kerusakan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th,
        td {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 20px;
        }

        .header img {
            float: left;
            max-width: 70px;
            height: auto;
            margin-bottom: 20px;
        }

        .header h2,
        .header h3 {
            margin: 10px 0;
        }

        .header p {
            margin: 10px 0;
        }

        /* Media print */
        @media print {
            body {
                font-size: 12px;
            }

            table {
                width: 100%;
                page-break-after: auto;
                page-break-before: auto;
            }

            .header img {
                max-width: 50px;
            }

            .header {
                border-bottom: 1px solid black;
                padding-bottom: 15px;
            }

            th,
            td {
                padding: 4px;
            }

            td img {
                max-width: 100%;
                height: auto;
            }

            /* Tanda tangan di pojok kanan bawah halaman */
            .signature {
                position: absolute;
                bottom: 30px;
                /* Menjaga posisi 30px dari bawah */
                right: 30px;
                /* Menjaga posisi 30px dari kanan */
                text-align: center;
                font-size: 12px;
            }

            .signature-line {
                border-top: 1px solid black;
                width: 200px;
                margin-top: 10px;
            }

            /* Memastikan tanda tangan berada di halaman baru jika tabel sangat panjang */
            .page-break {
                page-break-before: always;
            }
        }

        td img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        @if (file_exists(public_path('operator/img/bjm.png')))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('operator/img/bjm.png'))) }}"
                alt="Logo Pemerintah Kota Banjarmasin">
        @else
            <p>File tidak ditemukan</p>
        @endif

        <h3>PEMERINTAH KOTA BANJARMASIN</h3>
        <h2>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</h2>
        <p>Jalan Brigjend H. Hasan Basri No. 82 Banjarmasin Kode Pos 70124 <br>
            Telepon(0511)3300197 Faks. (0511)3300094 <br>
            Laman: pupr.banjarmasinkota.go.id Pos-el: pupr@mail.banjarmasinkota.go.id
        </p>
    </div>

    <h2>Laporan Status Penanganan Kerusakan</h2>

    <!-- Tabel -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Kerusakan</th>
                <th>Tindakan</th>
                <th>Tanggal Penanganan</th>
                <th>Petugas</th>
                <th>Biaya</th>
                <th>Foto Sebelum</th>
                <th>Foto Sesudah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->aduan->jenis_aduan ?? '-' }}</td>
                    <td>{{ $item->tindakan ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d M Y') ?? '-' }}</td>
                    <td>{{ $item->petugas->name ?? '-' }}</td>
                    <td>Rp {{ number_format($item->dana_digunakan, 0, ',', '.') }}</td>

                    <!-- Foto Sebelum Perbaikan -->
                    <td>
                        @if ($item->foto_sebelum_perbaikan)
                            <img src="{{ public_path('storage/' . $item->foto_sebelum_perbaikan) }}" width="100"
                                alt="Foto Sebelum">
                        @else
                            Tidak ada
                        @endif
                    </td>

                    <!-- Foto Sesudah Perbaikan -->
                    <td>
                        @if ($item->foto_perbaikan)
                            <img src="{{ public_path('storage/' . $item->foto_perbaikan) }}" width="100"
                                alt="Foto Sesudah">
                        @else
                            Belum ada
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Area Tanda Tangan -->
    <div class="signature">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        <div class="signature-line"></div>
        <p>Nama Petugas</p>
    </div>

    <!-- Jika tabel sangat panjang, buat pemisah halaman baru -->
    <div class="page-break"></div>
</body>

</html>
