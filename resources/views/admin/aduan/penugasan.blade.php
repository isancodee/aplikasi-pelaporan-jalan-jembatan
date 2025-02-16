@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-4 card">
        <h2 class="text-center mb-4 mt-4">Daftar Aduan untuk Ditugaskan</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jenis Aduan</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Info</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aduans as $index => $aduan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $aduan->nama }}</td>
                        <td>{{ $aduan->alamat }}</td>
                        <td>{{ $aduan->jenis_aduan }}</td>
                        <td>{{ $aduan->latitude }}</td>
                        <td>{{ $aduan->longitude }}</td>
                        <td>
                            @if ($aduan->foto)
                                <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Aduan" width="100"
                                    height="auto">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary text-white">{{ $aduan->status }}</span>
                        </td>
                        <td>
                            @if ($aduan->status == 'Menunggu Tanggapan')
                                <a href="{{ route('admin.aduan.tugaskan', $aduan->id) }}" class="btn btn-primary btn-sm">
                                    Tugaskan Petugas
                                </a>
                            @else
                                <span class="badge bg-success text-white">Petugas Ditugaskan</span>
                            @endif

                            @if ($aduan->status == 'diproses')
                                @if ($aduan->suratTugas)
                                    <span class="badge bg-secondary text-white">Surat Tugas Sudah Dibuat</span>
                                @else
                                    <a href="{{ route('admin.surat_tugas.create', $aduan->id) }}"
                                        class="btn btn-sm btn-warning">
                                        Buat Surat Tugas
                                    </a>
                                @endif
                            @endif


                        </td>
                        <td>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('aduan.destroy', $aduan->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus aduan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $aduans->links() }} <!-- Pagination -->
    </div>
@endsection
