@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-4 card">
        <h2 class="text-center">Laporan Peringkat Kerusakan Jalan</h2>

        <div class="card">
            <div class="card-header">
                Peringkat Kerusakan Jalan
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('pekerjal') }}">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" name="kecamatan" class="form-control"
                                placeholder="Cari Kecamatan/Kelurahan" value="{{ request('kecamatan') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('pekerjal') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <!-- Tombol Unduh Laporan -->
                <div class="mb-3">
                    <a href="{{ route('laporan.pdf') }}" class="btn btn-danger">Unduh PDF</a>
                    {{-- <a href="{{ route('laporan.excel') }}" class="btn btn-success">Unduh Excel</a> --}}
                </div>

                <!-- Tabel Laporan -->
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Tindakan</th>
                            <th>Kondisi Jalan</th>
                            <th>Foto Survei</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveis as $index => $survei)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $survei->aduan->alamat }}</td>
                                <td>{{ $survei->aduan->kecamatan }}</td>
                                <td>{{ $survei->tindakan }}</td>
                                <td>{{ $survei->aduan->tingkat_keparahan }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $survei->foto_survei) }}" width="100"
                                        alt="Foto Survei">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
