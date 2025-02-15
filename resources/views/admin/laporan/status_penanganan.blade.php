@extends('layouts.operator.admin')

@section('content')
    <section class="py-5 card">
        <div class="container px-5">
            <h1 class="text-center">Laporan Status Penanganan Kerusakan</h1>

            <!-- Filter Form -->
            <form action="{{ route('admin.laporan.status_penanganan') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label>Tindakan</label>
                        <select name="tindakan" class="form-select">
                            <option value="">Semua</option>
                            <option value="Belum Ditangani"
                                {{ request('tindakan') == 'Belum Ditangani' ? 'selected' : '' }}>Belum Ditangani
                            </option>
                            <option value="Sedang Ditangani"
                                {{ request('tindakan') == 'Sedang Ditangani' ? 'selected' : '' }}>Sedang Ditangani
                            </option>
                            <option value="Selesai" {{ request('tindakan') == 'Selesai' ? 'selected' : '' }}>Selesai
                                Ditangani
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>
                    {{-- <div class="col-md-3">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi"
                            value="{{ request('lokasi') }}">
                    </div> --}}
                </div>
                <button type="submit" class="btn btn-primary mt-3">Filter</button>
                <a href="{{ route('admin.laporan.status_penanganan') }}" class="btn btn-warning mt-3">Reset</a>

                <!-- Export Buttons -->
                <div class="text-end mt-3">
                    <a href="{{ route('admin.laporan.status_penanganan.export_pdf') }}" class="btn btn-danger">Download
                        PDF</a>
                    <a href="{{ route('admin.laporan.status_penanganan.export_excel') }}" class="btn btn-success">Download
                        Excel</a>
                </div>
            </form>

            <!-- Tabel Laporan -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Jenis Kerusakan</th>
                            <th>Tindakan</th>
                            <th>Tanggal Penanganan</th>
                            <th>Petugas</th>
                            <th>Biaya</th>
                            <th>Foto Sebelum</th>
                            <th>Foto Sesudah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->aduan->jenis_aduan ?? '-' }}</td>
                                <td>{{ $item->tindakan ?? '-' }}</td>
                                <td>{{ $item->created_at->format('d M Y') ?? '-' }}
                                </td>
                                <td>{{ $item->petugas->name ?? '-' }}</td>
                                <td>Rp {{ number_format($item->dana_digunakan, 0, ',', '.') }}</td>
                                <!-- Perbaikan menampilkan nama petugas -->
                                <td>
                                    @if ($item->foto_sebelum_perbaikan)
                                        <img src="{{ asset('storage/' . $item->foto_sebelum_perbaikan) }}" width="100"
                                            alt="Foto Sebelum">
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                                <td>
                                    @if ($item->foto_perbaikan)
                                        <img src="{{ asset('storage/' . $item->foto_perbaikan) }}" width="100"
                                            alt="Foto Sesudah">
                                    @else
                                        Belum ada
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>


        </div>
    </section>
@endsection
