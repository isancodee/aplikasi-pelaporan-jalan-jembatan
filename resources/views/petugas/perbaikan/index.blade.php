@extends('layouts.petugas.index')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Daftar Perbaikan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">List Laporan Perbaikan</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tindakan</th>
                            <th>Foto Perbaikan</th>
                            <th>Dana Digunakan</th>
                            <th>Tanggal Perbaikan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perbaikans as $key => $perbaikan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $perbaikan->tindakan }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" alt="Foto Perbaikan"
                                        width="100">
                                </td>
                                <td>Rp {{ number_format($perbaikan->dana_digunakan, 0, ',', '.') }}</td>
                                <td>{{ $perbaikan->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('petugas.perbaikan.show', $perbaikan->id) }}"
                                        class="btn btn-sm btn-info">Lihat Detail</a>
                                    <a href="{{ route('petugas.perbaikan.edit', $perbaikan->id) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit Laporan Perbaikan
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
