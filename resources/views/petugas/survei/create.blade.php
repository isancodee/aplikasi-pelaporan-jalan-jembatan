@extends('layouts.petugas.index')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Input Hasil Survei</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">Form Hasil Survei</div>
            <div class="card-body">
                <form action="{{ route('petugas.survei.store', $aduan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="aduan_id" value="{{ $aduan->id }}">

                    @if (!Auth::check())
                        <div class="mb-3">
                            <label for="petugas_id" class="form-label">Pilih Petugas</label>
                            <select name="petugas_id" class="form-control" required>
                                <option value="">-- Pilih Petugas --</option>
                                @foreach ($petugas as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="tindakan" class="form-label">Tindakan yang Disarankan</label>
                        <textarea name="tindakan" id="tindakan" class="form-control" required>{{ old('tindakan') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="rencana_biaya" class="form-label">Rencana Biaya (Rp)</label>
                        <input type="number" name="rencana_biaya" id="rencana_biaya" class="form-control" required
                            value="{{ old('rencana_biaya') }}">
                    </div>

                    <div class="mb-3">
                        <label for="foto_survei" class="form-label">Foto Survei</label>
                        <input type="file" name="foto_survei" id="foto_survei" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Hasil Survei</button>
                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
