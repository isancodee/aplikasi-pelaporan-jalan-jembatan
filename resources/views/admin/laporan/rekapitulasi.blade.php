@extends('layouts.operator.admin')

@section('content')

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css">
    </head>
    <section class="py-5">
        <div class="container px-5 mb-5">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bolder mb-0">
                    <span class="text-gradient d-inline">Laporan Rekapitulasi Kerusakan Bulanan - {{ $tahun }}</span>
                </h1>
            </div>
            <div class="mb-2">
                <a href="{{ route('admin.laporan.rekapitulasi.pdf', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Pdf Report</a>

            </div>
            <div class="card p-4">
                <form action="{{ route('admin.laporan.rekapitulasi') }}" method="GET" class="mb-3 text-center">
                    <label for="tahun" class="fw-bold">Pilih Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select w-auto d-inline mx-2">
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>

                    <label for="bulan" class="fw-bold ms-3">Pilih Bulan:</label>
                    <select name="bulan" id="bulan" class="form-select w-auto d-inline mx-2">
                        <option value="">Semua Bulan</option>
                        @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $b, 1)) }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary ms-2">Filter</button>
                    <a href="{{ route('admin.laporan.rekapitulasi') }}" class="btn btn-danger ms-2">
                        reset
                    </a>


                </form>


                <!-- Card Grafik Laporan Bulanan -->
                <div class="card shadow rounded-4 border-0 mb-4">
                    <div class="card-body text-center">
                        <h2 class="fw-bolder">Jumlah Laporan Per Bulan</h2>
                        <div class="d-flex justify-content-center">
                            <canvas id="chartBulanan" style="max-width: 100%; height: auto;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card Grafik Laporan Jenis Aduan -->
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <h2 class="fw-bolder">Jumlah Laporan Per Jenis Aduan</h2>
                        <div class="d-flex justify-content-center">
                            <canvas id="chartJenis" style="max-width: 100%; height: auto;"></canvas>
                        </div>
                        <h4 class="mt-4">Persentase Laporan yang Ditangani</h4>
                        <p class="fw-bold">{{ number_format($persentaseSelesai, 2) }}% laporan telah selesai ditangani.</p>
                    </div>
                </div>

                <!-- Tabel Rekapitulasi Laporan -->
                <div class="card shadow rounded-4 border-0 mt-4">
                    <div class="card-body">
                        <h2 class="fw-bolder text-center">Rekapitulasi Laporan Per Bulan</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Total Laporan</th>
                                        <th>Laporan Selesai</th>
                                        <th>Laporan Belum Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapBulanan as $rekap)
                                        <tr>
                                            <td>{{ date('F', mktime(0, 0, 0, $rekap->bulan, 1)) }}</td>
                                            <td>{{ $rekap->total }}</td>
                                            <td>{{ $rekap->selesai ?? 0 }}</td>
                                            <td>{{ $rekap->total - ($rekap->selesai ?? 0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Peta Sebaran Lokasi Aduan -->
                <div class="card shadow rounded-4 border-0 mt-4">
                    <div class="card-body">
                        <h2 class="fw-bolder text-center">Peta Sebaran Lokasi Kerusakan</h2>

                        <!-- Keterangan Warna Marker -->
                        <div class="mb-3">
                            <span class="">🔵 Selesai |</span>
                            <span class="">🔴 Proses Perbaikan</span>
                        </div>

                        <div id="map" style="height: 400px;"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script>
        // Grafik Laporan Per Bulan
        var ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
        var chartBulanan = new Chart(ctxBulanan, {
            type: 'bar',
            data: {
                labels: @json($rekapBulanan->pluck('bulan')),
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: @json($rekapBulanan->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Laporan'
                        }
                    }
                }
            }
        });


        // Grafik Laporan Per Jenis Aduan
        var ctxJenis = document.getElementById('chartJenis').getContext('2d');
        var chartJenis = new Chart(ctxJenis, {
            type: 'pie',
            data: {
                labels: @json($rekapJenis->pluck('jenis_aduan')),
                datasets: [{
                    data: @json($rekapJenis->pluck('total')),
                    backgroundColor: ['red', 'blue', 'green', 'yellow', 'purple'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });


        // Inisialisasi Peta
        var map = L.map('map').setView([-2.5489, 118.0149], 5); // Default ke Indonesia

        // Tambahkan Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Custom Icon Marker Pakai Gambar Sendiri
        var blueIcon = L.icon({
            iconUrl: "{{ asset('operator/img/blue.png') }}",
            iconSize: [30, 40], // Sesuaikan ukuran gambar
            iconAnchor: [15, 40],
            popupAnchor: [0, -40],
        });

        var redIcon = L.icon({
            iconUrl: "{{ asset('operator/img/red.png') }}",
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -40],
        });

        // Data Marker dari Aduan
        var lokasiAduan = @json($lokasiAduan);

        console.log("Data Aduan:", lokasiAduan); // Cek apakah data ada

        lokasiAduan.forEach(function(aduan) {
            if (aduan.latitude && aduan.longitude) {
                var lat = parseFloat(aduan.latitude);
                var lng = parseFloat(aduan.longitude);

                if (isNaN(lat) || isNaN(lng)) {
                    console.log("Koordinat tidak valid untuk:", aduan);
                    return; // Lewati jika koordinat tidak valid
                }

                var markerIcon;
                var status = aduan.status ? aduan.status.toLowerCase() : "";

                if (status === "selesai") {
                    markerIcon = blueIcon;
                } else if (status === "diproses") {
                    markerIcon = redIcon;
                } else {
                    console.log("Status lain diabaikan:", aduan.status);
                    return; // Status lain tidak ditampilkan di peta
                }

                console.log("Menambahkan marker untuk:", aduan, "Koordinat:", lat, lng);

                L.marker([lat, lng], {
                        icon: markerIcon
                    })
                    .addTo(map)
                    .bindPopup('<b>' + aduan.jenis_aduan + '</b><br>Status: ' + aduan.status);
            } else {
                console.log("Aduan tanpa koordinat:", aduan);
            }
        });
    </script>
@endsection
