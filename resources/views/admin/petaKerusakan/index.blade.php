@extends('layouts.operator.admin')
@section('content')

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
            #map {
                height: 500px;
                width: 100%;
            }
        </style>
    </head>

    <body>
        <div class="card shadow rounded-4 border-0 mt-4">
            <div class="card-body">
                <h2 class="fw-bolder text-center">Peta Sebaran Lokasi Kerusakan</h2>

                <!-- Keterangan Warna Marker -->
                <div class="mb-3">
                    <span class="text-success">🟢 Ringan |</span>
                    <span class="text-warning">🟡 Sedang |</span>
                    <span class="text-danger">🔴 Parah</span>
                </div>

                <!-- Filter Form -->
                <form action="{{ route('report.lokasi') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="jenis_kerusakan" class="form-control">
                                <option value="">Semua Jenis Kerusakan</option>
                                <option value="Ringan" {{ request('jenis_kerusakan') == 'Ringan' ? 'selected' : '' }}>Ringan
                                </option>
                                <option value="Sedang" {{ request('jenis_kerusakan') == 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="Parah" {{ request('jenis_kerusakan') == 'Parah' ? 'selected' : '' }}>Parah
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="date" name="start_date" class="form-control" placeholder="Dari Tanggal"
                                value="{{ request('start_date') }}" />
                        </div>

                        <div class="col-md-4">
                            <input type="date" name="end_date" class="form-control" placeholder="Sampai Tanggal"
                                value="{{ request('end_date') }}" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary mt-3">Filter</button>
                    <a href="{{ route('report.lokasi') }}" class="btn btn-sm btn-secondary  float-end mt-3">Reset Filter</a>
                    <a href="{{ route('laporan.download_pdf') }}" class="btn btn-sm btn-danger mt-3">Download
                        PDF</a>

                </form>

                <div id="map" style="height: 400px;"></div>
            </div>
        </div>

        <script>
            var map = L.map('map').setView([-3.316694, 114.590111], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Data dari Laravel (Blade ke JS)
            var locations = @json($laporan);

            // Fungsi untuk menentukan warna marker
            function getMarkerColor(keparahan) {
                switch (keparahan) {
                    case 'Ringan':
                        return 'green';
                    case 'Sedang':
                        return 'yellow';
                    case 'Parah':
                        return 'red';
                    default:
                        return 'blue';
                }
            }

            // Tambahkan Marker dari Database
            locations.forEach(function(data) {
                var markerColor = getMarkerColor(data.tingkat_keparahan);

                var markerIcon = L.icon({
                    iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${markerColor}.png`,
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                L.marker([data.latitude, data.longitude], {
                        icon: markerIcon
                    }).addTo(map)
                    .bindPopup(
                        `<b>${data.jenis_aduan}</b><br>${data.keterangan}<br><b>Keparahan:</b> ${data.tingkat_keparahan}<br>
                        <b>Foto Perbaikan:</b><br><img src="${data.foto ? '/storage/' + data.foto : ''}" width="150" alt="Foto">`
                    );
            });
        </script>

    </body>
@endsection
