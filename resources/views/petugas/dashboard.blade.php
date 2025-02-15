@include('layouts.petugas.index')

<div class="container mt-4">
    <h2 class="text-center">Dashboard Petugas</h2>

    <div class="card">
        <div class="card-header">Daftar Aduan yang Ditugaskan</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelapor</th>
                        <th>Alamat</th>
                        <th>Jenis Aduan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aduans as $index => $aduan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $aduan->nama }}</td>
                            <td>{{ $aduan->alamat }}</td>
                            <td>{{ $aduan->jenis_aduan }}</td>
                            <td>
                                <span
                                    class="badge 
                                @if ($aduan->status == 'diproses') bg-warning
                                @elseif($aduan->status == 'disetujui') bg-info
                                @elseif($aduan->status == 'selesai') bg-success @endif">
                                    {{ ucfirst($aduan->status) }}
                                </span>
                            </td>

                            <td>
                                @if ($aduan->survei)
                                    {{-- <span class="badge bg-success">Hasil Survei Sudah Dikirim</span> --}}
                                    @if ($aduan->status == 'disetujui' && !$aduan->perbaikan)
                                        <a href="{{ route('petugas.perbaikan.create', $aduan->id) }}"
                                            class="btn btn-sm btn-success">
                                            Laporkan Hasil Perbaikan
                                        </a>
                                    @elseif ($aduan->perbaikan)
                                        <span class="badge bg-primary">Laporan Perbaikan Sudah Dikirim</span>
                                    @endif
                                @else
                                    <a href="{{ route('petugas.survei.create', $aduan->id) }}"
                                        class="btn btn-sm btn-primary">
                                        Input Hasil Survei
                                    </a>
                                @endif
                            </td>



                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $aduans->links() }}
        </div>
    </div>
</div>
