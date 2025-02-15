@extends('layouts.operator.admin')

@section('content')
    <div class="container">
        <h2 class="text-center">Buat Surat Tugas</h2>

        <form action="{{ route('admin.surat_tugas.store', $aduan->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat') }}" required>

            </div>

            <div class="mb-3">
                <label for="tanggal_tugas" class="form-label">Tanggal Tugas</label>
                <input type="date" name="tanggal_tugas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="petugas_id" class="form-label">Pilih Petugas</label>
                <select name="petugas_id" class="form-control" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($petugas as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="deskripsi_tugas" class="form-label">Deskripsi Tugas (Opsional)</label>
                <textarea name="deskripsi_tugas" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Surat Tugas</button>
        </form>
    </div>
@endsection
