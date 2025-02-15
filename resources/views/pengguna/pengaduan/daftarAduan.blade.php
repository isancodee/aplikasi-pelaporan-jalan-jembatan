@include('layouts.pengguna.link')

@include('layouts.pengguna.headerUser')

<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Aduan Masyarakat</h2>



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
@include('layouts.pengguna.script')
