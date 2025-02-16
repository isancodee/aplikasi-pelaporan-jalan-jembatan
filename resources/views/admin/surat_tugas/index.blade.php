@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-4 card">
        <h2 class="text-center mt-4 mb-4">Daftar Surat Tugas</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Tugas</th>
                    <th>Petugas</th>
                    <th>Alamat Aduan</th>
                    <th>Status Aduan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratTugas as $index => $surat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tanggal_tugas }}</td>
                        <td>{{ $surat->petugas->name }}</td>
                        <td>{{ $surat->aduan->alamat }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary text-white">{{ $surat->aduan->status }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.surat_tugas.lihat', $surat->id) }}" class="btn btn-sm btn-danger"
                                target="_blank">
                                Cettak PDF
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.surat_tugas.hapus', $surat->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat tugas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-warning"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $suratTugas->links() }} <!-- Pagination -->
    </div>
@endsection
