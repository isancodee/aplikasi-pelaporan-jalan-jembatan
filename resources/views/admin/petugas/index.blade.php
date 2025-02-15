@extends('layouts.operator.admin')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Petugas</h1>

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
                        <td>
                            <!-- Tombol Hapus dengan ikon -->
                            <form action="{{ route('petugas.destroy', $petugasItem->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash-alt"></i><!-- Ikon Sampah -->
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
