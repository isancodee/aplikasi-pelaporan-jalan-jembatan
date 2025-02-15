<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aduan Masyarakat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .header img {
            float: left;
            width: 100px;
            height: 140px;
        }

        .header h2 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            color: black;
            font-weight: bold;
        }



        .signature {
            text-align: right;
            margin-top: 30px;
        }

        .signature p {
            margin: 5px 0;
        }

        .signature .line {
            margin-top: 50px;
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
    <h2>Laporan Aduan Masyarakat</h2>
    <p>Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Jenis Aduan</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aduans as $index => $aduan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $aduan->nama }}</td>
                    <td>{{ $aduan->alamat }}</td>
                    <td>{{ $aduan->kecamatan }}</td>
                    <td>{{ $aduan->jenis_aduan }}</td>
                    <td>{{ $aduan->keterangan }}</td>
                    <td>
                        <span
                            class="badge 
                            @if ($aduan->status == 'selesai') bg-success
                            @elseif ($aduan->status == 'diproses') bg-warning
                            @elseif ($aduan->status == 'disetujui') bg-primary
                            @elseif ($aduan->status == 'Menunggu Tanggapan') bg-info @endif">
                            {{ ucfirst($aduan->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        <p>Petugas</p>
        <div class="line">
            <p>Nama Petugas</p>
        </div>

    </div>
</body>

</html>
