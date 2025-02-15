@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Daftar Hasil Survei</h2>

        <div class="card">
            <div class="card-header">Hasil Survei</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelapor</th>
                            <th>Kecamatan</th>
                            <th>Kondisi Jalan</th>
                            <th>Petugas</th>
                            <th>Tindakan</th>
                            <th>Rencana Biaya</th>
                            <th>Foto Survei</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveis as $index => $survei)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $survei->aduan->nama }}</td>
                                <td>{{ $survei->aduan->kecamatan }}</td>
                                <td>{{ $survei->aduan->tingkat_keparahan }}</td>
                                <td>{{ $survei->petugas->name }}</td>
                                <td>{{ $survei->tindakan }}</td>
                                <td>Rp {{ number_format($survei->rencana_biaya, 0, ',', '.') }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $survei->foto_survei) }}" width="100" alt="Foto Survei">
                                </td>
                                <td>
                                    @if ($survei->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @elseif ($survei->status == 'disetujui')
                                        <span class="badge bg-success text-white">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger text-white">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($survei->status == 'menunggu')
                                        <form action="{{ route('admin.survei.approve', $survei->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.survei.reject', $survei->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('survei.destroy', $survei->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data survei ini?');">
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
@endsection
