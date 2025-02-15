@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-4 card">
        <h2 class="text-center mb-4">Daftar Aduan Masyarakat</h2>
        <div class="">
            <a href="{{ route('aduan.pdf') }}" class="btn btn-primary mb-2"> <i class="fas fa-file-pdf"></i> Print PDF</a>
        </div>


        </a>
        <!-- Tabel Aduan (Responsif) -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Jenis Aduan</th>
                        <th>Keterangan</th>
                        <th>Latitude</th>
                        <th>Longtitude</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aduans as $index => $aduan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $aduan->nama }}</td>
                            <td>{{ $aduan->alamat }}</td>
                            <td>{{ $aduan->kecamatan }}</td>
                            <td>{{ $aduan->jenis_aduan }}</td>
                            <td>{{ $aduan->keterangan }}</td>
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
                                <span
                                    class="badge text-white 
                                    @if ($aduan->status == 'selesai') bg-success
                                    @elseif ($aduan->status == 'diproses') bg-warning
                                    @elseif ($aduan->status == 'disetujui') bg-primary
                                    @elseif ($aduan->status == 'Menunggu Tanggapan') bg-info @endif">
                                    {{ ucfirst($aduan->status) }}
                                </span>
                            </td>
                            <td>
                                <!-- Tombol Hapus dengan Icon -->
                                <form action="{{ route('aduan.destroy', $aduan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus aduan ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $aduans->links() }}
        </div>
    </div>
@endsection
