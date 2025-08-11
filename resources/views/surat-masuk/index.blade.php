@extends('layouts.main')

@section('container')
    <div class="ms-3">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="border-bottom border-black">
        <h1 class="ms-3">Arsip Surat Masuk</h1>
    </div>
    <br>
    @can('buat surat')
        <a href="{{ route('surat-masuk.create') }}" class="btn btn-outline-primary fs-5"><i class="fa-solid fa-plus"></i> Buat
            Arsip Baru</a>
    @endcan

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="" id="suratMasukTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Hal</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Tanggal Diarsipkan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suratMasuk as $surat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>{{ $surat->asal }}</td>
                    <td>{{ $surat->tujuan }}</td>
                    <td>{{ $surat->tanggalDiterima() }}</td>
                    <td><a href="{{ asset('storage/surat_masuk/' . $surat->file_surat) }}" target="_blank">Lihat</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $('document').ready(function() {
            var table = $('#suratMasukTable').DataTable();
        })
    </script>
@endsection
