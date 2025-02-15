@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Laporan Perbaikan Jalan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">Daftar Laporan Perbaikan</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Petugas</th>
                                <th>Aduan</th>
                                <th>Kecamatan</th>
                                <th>Tindakan Perbaikan</th>
                                <th>Dana Digunakan</th>
                                <th>Foto Perbaikan</th>
                                <th>Tanggal Perbaikan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanPerbaikan as $index => $perbaikan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $perbaikan->petugas->name ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $perbaikan->aduan->keterangan ?? '-' }}</td>
                                    <td>{{ $perbaikan->aduan->kecamatan ?? '-' }}</td>
                                    <td>{{ $perbaikan->tindakan }}</td>
                                    <td>Rp {{ number_format($perbaikan->dana_digunakan, 0, ',', '.') }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" width="100">
                                    </td>
                                    <td>{{ $perbaikan->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($perbaikan->aduan->status !== 'Selesai')
                                            <!-- Tombol untuk menandai aduan selesai -->
                                            <form action="{{ route('admin.aduan.selesai', $perbaikan->aduan->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Tandai
                                                    Selesai</button>
                                            </form>
                                        @else
                                            <!-- Jika status sudah selesai, tampilkan badge -->
                                            <span class="badge bg-success">Selesai</span>
                                        @endif

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.laporan.perbaikan.destroy', $perbaikan->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan perbaikan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mt-1">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
