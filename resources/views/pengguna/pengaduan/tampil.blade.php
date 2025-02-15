@include('layouts.link')
@include('layouts.headerUser')

<div class="container">
    <h2 class="text-center mb-4">Daftar Pengaduan</h2>

    {{-- Form Pencarian & Filter --}}
    <form method="GET" action="{{ route('aduanTampil.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama atau Jenis Aduan"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="baru" {{ request('status') == 'Menunggu Tanggapan' ? 'selected' : '' }}>Menunggu
                        Tanggapan</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui
                    </option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

    {{-- Tabel Pengaduan --}}
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Jenis Aduan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($aduans as $index => $aduan)
                <tr>
                    <td>{{ $aduans->firstItem() + $index }}</td>
                    <td>{{ $aduan->nama }}</td>
                    <td>{{ $aduan->email }}</td>
                    <td>{{ $aduan->no_telp }}</td>
                    <td>{{ $aduan->jenis_aduan }}</td>
                    <td>
                        <span
                            class="badge 
                        @if ($aduan->status == 'Menunggu Tanggapan') bg-primary
                        @elseif($aduan->status == 'diproses') bg-warning
                        @elseif($aduan->status == 'disetujui') bg-info
                        @elseif($aduan->status == 'selesai') bg-success @endif">
                            {{ ucfirst($aduan->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('aduan.show', $aduan->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $aduans->appends(request()->query())->links() }}
    </div>
</div>

@include('layouts.script')
