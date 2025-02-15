@extends('layouts.petugas.index')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Detail Perbaikan</h2>

        <div class="card">
            <div class="card-header">Informasi Perbaikan</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Tindakan</th>
                        <td>{{ $perbaikan->tindakan }}</td>
                    </tr>
                    <tr>
                        <th>Foto Perbaikan</th>
                        <td>
                            <img src="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" alt="Foto Perbaikan"
                                width="300">
                        </td>
                    </tr>
                    <tr>
                        <th>Dana yang Digunakan</th>
                        <td>Rp {{ number_format($perbaikan->dana_digunakan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Perbaikan</th>
                        <td>{{ $perbaikan->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
                <a href="{{ route('petugas.perbaikan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
