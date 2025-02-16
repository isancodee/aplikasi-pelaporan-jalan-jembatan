@extends('layouts.petugas.index')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Daftar Surat Tugas</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Tugas</th>
                    <th>Petugas</th>
                    <th>Alamat Aduan</th>

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
                            <a href="{{ route('admin.surat_tugas.lihat', $surat->id) }}" class="btn btn-sm btn-danger"
                                target="_blank">
                                Cettak PDF
                            </a>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $suratTugas->links() }} <!-- Pagination -->
    </div>
@endsection
