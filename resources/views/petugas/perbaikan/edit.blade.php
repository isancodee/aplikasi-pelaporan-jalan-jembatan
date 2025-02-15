@extends('layouts.petugas.index')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Edit Laporan Perbaikan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">Form Edit Laporan Perbaikan</div>
            <div class="card-body">
                <form action="{{ route('petugas.perbaikan.update', $perbaikan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="tindakan" class="form-label">Tindakan Perbaikan</label>
                        <textarea name="tindakan" id="tindakan" class="form-control" required>{{ old('tindakan', $perbaikan->tindakan) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto_perbaikan" class="form-label">Foto Hasil Perbaikan</label>
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small><br>
                        <img src="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" width="200" class="mt-2"><br>
                        <input type="file" name="foto_perbaikan" id="foto_perbaikan" class="form-control mt-2">
                    </div>

                    <div class="mb-3">
                        <label for="dana_digunakan" class="form-label">Dana yang Digunakan (Rp)</label>
                        <input type="number" name="dana_digunakan" id="dana_digunakan" class="form-control" required
                            value="{{ old('dana_digunakan', $perbaikan->dana_digunakan) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Laporan</button>
                    <a href="{{ route('petugas.perbaikan.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
@endsection
