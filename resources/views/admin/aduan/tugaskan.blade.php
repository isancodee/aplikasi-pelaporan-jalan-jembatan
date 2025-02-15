@extends('layouts.operator.admin')

@section('content')
    <div class="container">
        <h2 class="text-center">Tugaskan Petugas</h2>
        <form action="{{ route('admin.aduan.tugaskan.store', $aduan->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="petugas" class="form-label">Pilih Petugas</label>
                <select name="petugas_id" id="petugas" class="form-control" required>
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($petugas as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tugaskan</button>
            <a href="{{ route('admin.aduan.penugasan') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
