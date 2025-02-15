<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan Jalan Rusak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARi9w6T5Fk7zMWt9pUJnlBXTW4DjlRe50&callback=initMap" async
        defer></script>
    <style>
        #map {
            height: 300px;
            width: 100%;
        }
    </style>
    <script>
        function initMap() {
            var defaultLocation = {
                lat: -6.2088,
                lng: 106.8456
            }; // Default ke Jakarta
            var map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 13
            });
            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                updateCoordinates(event.latLng.lat(), event.latLng.lng());
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                updateCoordinates(event.latLng.lat(), event.latLng.lng());
            });
        }

        function updateCoordinates(lat, lng) {
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
            document.getElementById("latDisplay").value = lat;
            document.getElementById("lngDisplay").value = lng;
        }
    </script>
</head>

<body>
    @include('layouts.pengguna.headerUser')

    <section class="py-5">
        <div class="container px-5">
            <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">Form Pengaduan</h1>
                    <p class="lead fw-normal text-muted">Laporkan disini!</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <form id="contactForm" action="{{ route('aduan.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="nama" type="text"
                                    placeholder="Masukkan nama Anda" required>
                                <label for="name">Nama</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email"
                                    placeholder="name@example.com" required>
                                <label for="email">Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" name="no_telp" type="tel"
                                    placeholder="Nomor Telepon" required>
                                <label for="phone">No Telepon</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="date" name="tgl_aduan" type="date" required>
                                <label for="date">Tanggal Aduan</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-control" name="jenis_aduan" required>
                                    <option value="Jalan Berlubang">Jalan Berlubang</option>
                                    <option value="Jalan Retak">Jalan Retak</option>
                                    <option value="Bahu Jalan Tinggi">Bahu Jalan Tinggi</option>
                                    <option value="Jembatan Rusak">Jembatan Rusak</option>
                                </select>
                                <label for="jenis_aduan">Jenis Aduan</label>
                            </div>

                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan aduan"
                                    style="height: 10rem" required></textarea>
                                <label for="keterangan">Keterangan</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="alamat" required>
                                <label for="alamat">Alamat Aduan</label>
                            </div>

                            <!-- Menambahkan input untuk kecamatan -->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="kecamatan" name="kecamatan" type="text"
                                    placeholder="Masukkan kecamatan" required>
                                <label for="kecamatan">Kecamatan</label>
                            </div>
                            

                            <div class="mb-3">
                                <label class="form-label">Titik Lokasi (Google Maps)</label>
                                <div id="map"></div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" id="latDisplay" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" id="lngDisplay" class="form-control" readonly>
                                    </div>
                                </div>
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">
                            </div>

                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" name="foto" accept="image/*" required>
                                <label for="foto">Upload Foto</label>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Kirim
                                    Aduan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('layouts.pengguna.script')
</body>

</html>
