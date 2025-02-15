<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Personal - Start Bootstrap Theme</title>
    @include('layouts.pengguna.link')
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        @include('layouts.pengguna.headerUser')
        <!-- Header-->
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        <header class="py-5">
            <div class="container px-5 pb-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-xxl-5">
                        <!-- Header text content-->
                        <div class="text-center text-xxl-start">
                            <div class="badge bg-gradient-primary-to-secondary text-white mb-4">
                                <div class="text-uppercase">Pengaduan &middot; Jalan &middot; Jembatan</div>
                            </div>
                            <div class="fs-3 fw-light text-muted">Kami siap mendengarkan pengaduan anda</div>
                            <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">Silahkan lakukan
                                    pengaduan</span></h1>
                            <div
                                class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                                <a class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder"
                                    href="{{ route('aduan.index') }}">Mulai Pengaduan</a>
                                {{-- <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder"
                                    href="projects.html">Projects</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7">
                        <!-- Header profile picture-->
                        <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                            <img class="profile-img img-thumbnail" src="{{ asset('pengguna/assets/img/hero.webp') }}"
                                alt="..." style="width: 700px; height: 500px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </header>
       
    </main>
    <!-- Footer-->
    <footer class="bg-white py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0">Copyright &copy; Your Website 2023</div>
                </div>
                <div class="col-auto">
                    <a class="small" href="#!">Privacy</a>
                    <span class="mx-1">&middot;</span>
                    <a class="small" href="#!">Terms</a>
                    <span class="mx-1">&middot;</span>
                    <a class="small" href="#!">Contact</a>
                </div>
            </div>
        </div>
    </footer>
    @include('layouts.pengguna.script')
</body>

</html>
