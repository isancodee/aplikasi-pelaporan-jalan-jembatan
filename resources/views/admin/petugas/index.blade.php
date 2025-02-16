@extends('layouts.operator.admin')

@section('content')
    <div class="container card mt-4">
        <h1 class="mb-4 mt-4">Daftar Petugas</h1>

        <div class="">
            <!-- Tombol Tambah Petugas -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPetugasModal">
                <i class="fas fa-plus"></i> Tambah Petugas
            </button>
        </div>

        <!-- Tabel Petugas -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petugas as $petugasItem)
                    <tr>
                        <td>{{ $petugasItem->name }}</td>
                        <td>{{ $petugasItem->email }}</td>
                        <td class="text-center">
                            <!-- Tombol Hapus -->
                            <form action="{{ route('petugas.destroy', $petugasItem->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Petugas -->
    <div class="modal fade" id="tambahPetugasModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('petugas.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <input type="hidden" name="role" value="petugas"> <!-- Default role petugas -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
