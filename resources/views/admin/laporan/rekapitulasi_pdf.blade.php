<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
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
    <div class="title">Laporan Rekapitulasi Kerusakan - {{ $tahun }}</div>

    <h3>Rekapitulasi Per Bulan</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Laporan</th>
                <th>Laporan Selesai</th>
                <th>Laporan Belum Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapBulanan as $rekap)
                <tr>
                    <td>{{ date('F', mktime(0, 0, 0, $rekap->bulan, 1)) }}</td>
                    <td>{{ $rekap->total }}</td>
                    <td>{{ $rekap->selesai ?? 0 }}</td>
                    <td>{{ $rekap->total - ($rekap->selesai ?? 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Rekapitulasi Per Jenis Kerusakan</h3>
    <table>
        <thead>
            <tr>
                <th>Jenis Kerusakan</th>
                <th>Total Laporan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapJenis as $rekap)
                <tr>
                    <td>{{ $rekap->jenis_aduan }}</td>
                    <td>{{ $rekap->total }}</td>
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
</body>

</html>
