@extends('layouts.petugas.index')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Laporan Hasil Perbaikan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">Form Laporan Perbaikan</div>
            <div class="card-body">
                <form action="{{ route('petugas.perbaikan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Input Hidden untuk Aduan ID -->
                    <input type="hidden" name="aduan_id" value="{{ $aduan->id }}">

                    <div class="mb-3">
                        <label for="tindakan" class="form-label">Status Penanganan</label>
                        <select name="tindakan" id="tindakan" class="form-control" required>
                            <option value="belum ditangani" {{ old('tindakan') == 'belum ditangani' ? 'selected' : '' }}>
                                Belum Ditangani</option>
                            <option value="sedang ditangani" {{ old('tindakan') == 'sedang ditangani' ? 'selected' : '' }}>
                                Sedang Ditangani</option>
                            <option value="selesai" {{ old('tindakan') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dana_digunakan" class="form-label">dana_digunakan Perbaikan (Rp)</label>
                        <input type="number" name="dana_digunakan" id="dana_digunakan" class="form-control" required
                            value="{{ old('dana_digunakan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="foto_sebelum_perbaikan" class="form-label">Foto Sebelum Perbaikan</label>
                        <input type="file" name="foto_sebelum_perbaikan" id="foto_sebelum_perbaikan" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="foto_perbaikan" class="form-label">Foto Setelah Perbaikan</label>
                        <input type="file" name="foto_perbaikan" id="foto_perbaikan" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
@endsection
