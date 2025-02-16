<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @include('layouts.operator.link')
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PENJALU <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Manajemen aduan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manajemen aduan:</h6>
                        <a class="collapse-item" href="{{ route('admin.aduan') }}">Data Aduan</a>
                        <a class="collapse-item" href="{{ route('admin.aduan.penugasan') }}">Daftar aduan ditugaskan</a>
                        <a class="collapse-item" href="{{ route('admin.laporan.perbaikan') }}">Laporan Perbaikan</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw  fa-file-contract"></i>
                    <span>Survei Petugas</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Survei Petugas:</h6>

                        <a class="collapse-item" href="{{ route('admin.survei.index') }}">Aprove Survei</a>
                        <a class="collapse-item" href="{{ route('petugas') }}">Petugas Survei</a>
                        <a class="collapse-item" href="{{ route('admin.surat_tugas.index') }}">Surat Tugas</a>

                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('report.lokasi') }}">
                    <i class="fas fa-fw  fa-map"></i>
                    <span>Peta Kerusakan</span>
                </a>

            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan & Statistik</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="{{ route('aduanMasyarakat') }}">Aduan Masyarakat</a>
                        <a class="collapse-item" href="{{ route('admin.laporan.status_penanganan') }}">Laporan
                            Penanganan</a>
                        <a class="collapse-item" href="{{ route('admin.laporan.rekapitulasi') }}">Rekapitulasi
                            laporan</a>
                        <a class="collapse-item" href="{{ route('pekerjal') }}">Peringkat Kerusakan Jalan</a>

                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                                </span>
                                <i class="fas fa-user-circle fa-lg text-gray-600"></i>
                                <!-- Ganti gambar dengan ikon -->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-envelope  fa-sm fa-fw mr-2 text-gray-400"></i>
                                    email : {{ Auth::check() ? Auth::user()->email : 'Guest' }}
                                </a>

                                <div class="dropdown-divider"></div>
                                <!-- Form logout -->
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


                </nav>
                <!-- End of Topbar -->
                @yield('content')
            </div>
        </div>

    </div>



    @include('layouts.operator.script')
</body>

</html>
