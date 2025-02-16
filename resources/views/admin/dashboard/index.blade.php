@extends('layouts.operator.admin')

@section('content')
    <div class="container-fluid">
        <div class="card p-4">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Total aduan -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Aduan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAduan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aduan Baru -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Aduan baru</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $aduanBaru }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aduan Diproses -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Aduan Diproses
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $aduanDiproses }}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-spinner fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aduan Selesai -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Aduan Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $aduanSelesai }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Aduan Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jenis Aduan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aduanTerbaru as $index => $aduan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $aduan->nama }}</td>
                                            <td>{{ $aduan->email }}</td>
                                            <td>{{ $aduan->jenis_aduan }}</td>
                                            <td>
                                                <span
                                                    class="badge text-white 
                                @if ($aduan->status == 'Menunggu Tanggapan') bg-primary
                                @elseif ($aduan->status == 'diproses') bg-warning
                                @elseif ($aduan->status == 'disetujui') bg-info
                                @elseif ($aduan->status == 'selesai') bg-success @endif">
                                                    {{ ucfirst($aduan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('aduan.show', $aduan->id) }}"
                                                    class="btn btn-sm btn-info">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Statistik Aduan</h6>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="chart-pie d-flex justify-content-center">
                                <canvas id="aduanChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Menunggu
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-warning"></i> Selesai
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Diproses
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Baru
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('aduanChart').getContext('2d');
        var aduanChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['', '', '', ''], // Labels dikosongkan agar tidak muncul di chart
                datasets: [{
                    data: [{{ $aduanBaru }}, {{ $aduanDiproses }}, {{ $aduanDisetujui }},
                        {{ $aduanSelesai }}
                    ],
                    backgroundColor: ['#007bff', '#ffc107', '#17a2b8', '#28a745'],
                    borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend agar tidak ada teks label
                    },
                    tooltip: {
                        enabled: true, // Aktifkan tooltip
                        callbacks: {
                            label: function(tooltipItem) {
                                var dataIndex = tooltipItem.dataIndex;
                                var value = tooltipItem.dataset.data[dataIndex]; // Ambil nilai dari data
                                return 'Jumlah Aduan: ' + value; // Format tooltip
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
