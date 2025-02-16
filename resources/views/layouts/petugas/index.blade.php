<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

@include('layouts.operator.link')
<style>
    .navbar-nav .nav-link:hover {
        background-color: white;
        color: black !important;
        border-radius: 5px;
        transition: 0.3s;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>

            <!-- Tombol Menu (Mobile) -->
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('petugas.perbaikan.index') }}">Daftar
                            Perbaikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('suratPetugas') }}">Surat Tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('petugas.dashboard') }}">Survei Petugas</a>
                    </li>
                </ul>
            </div>

            <!-- Dropdown User di Samping Kanan -->
            <div class="ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-white">
                                {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                            </span>
                            <i class="fas fa-user-circle fa-lg text-white"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>
                                Email: {{ Auth::check() ? Auth::user()->email : 'Guest' }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
