<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
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
    <h2>Surat Tugas</h2>
    <p>Nomor: {{ $surat->nomor_surat }}</p>
    <br>
    <p><strong>Tanggal Tugas:</strong> {{ $surat->tanggal_tugas }}</p>
    <p><strong>Nama Petugas:</strong> {{ $surat->petugas->name }}</p>
    <p><strong>Alamat Aduan:</strong> {{ $surat->aduan->alamat }}</p>

    <p>Dengan ini menugaskan petugas di atas untuk melakukan survei terhadap aduan yang telah diajukan.</p>

    <p>Demikian surat tugas ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <br><br>
    <p><strong>Tertanda,</strong></p>
    <p><em>(Admin)</em></p>
</body>

</html>
