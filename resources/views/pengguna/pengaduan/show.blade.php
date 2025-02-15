@include('layouts.operator.admin')
@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Detail Pengaduan</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $aduan->jenis_aduan }}</h5>
                <p class="card-text"><strong>Nama:</strong> {{ $aduan->nama }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $aduan->email }}</p>
                <p class="card-text"><strong>No. Telepon:</strong> {{ $aduan->no_telp }}</p>
                <p class="card-text"><strong>Keterangan:</strong> {{ $aduan->keterangan }}</p>
                <p class="card-text"><strong>Alamat:</strong> {{ $aduan->alamat }}</p>
                <p class="card-text"><strong>Status:</strong> <span
                        class="badge bg-primary">{{ ucfirst($aduan->status) }}</span></p>
                <img src="{{ asset('storage/' . $aduan->foto) }}" class="img-fluid" alt="Foto Aduan">
            </div>
        </div>

        <a href="{{ route('aduanTampil.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
@include('layouts.operator.script')
