<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peringkat Kerusakan Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table,
        .th,
        .td {
            border: 1px solid black;
        }

        .th,
        .td {
            padding: 8px;
            text-align: left;
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
    <div class="header">
        <h2>Laporan Peringkat Kerusakan Jalan</h2>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="th">No</th>
                <th class="th">Alamat</th>
                <th class="th">Kecamatan</th>
                <th class="th">Tindakan</th>
                <th class="th">Kondisi Jalan</th>
                <th class="th">Foto Survei</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surveis as $index => $survei)
                <tr>
                    <td class="td">{{ $index + 1 }}</td>
                    <td class="td">{{ $survei->aduan->alamat }}</td>
                    <td class="td">{{ $survei->aduan->kecamatan }}</td>
                    <td class="td">{{ $survei->tindakan }}</td>
                    <td class="td">{{ $survei->aduan->tingkat_keparahan }}</td>
                    <td class="td">
                        <img src="{{ storage_path('app/public/' . $survei->foto_survei) }}" width="100"
                            alt="Foto Survei">
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
