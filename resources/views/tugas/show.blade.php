@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h1>{{ $tugas->judul }}</h1>
    <hr>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="">
        <h6>Pegawai</h6>
        <p>{{ $tugas->pegawai->nama }}</p>
        <h6>Uraian Tugas</h6>
        <p>{{ $tugas->uraian_tugas }}</p>
        <h6>Keterangan</h6>
        <p>{{ $tugas->keterangan }}</p>
        <h6>Waktu Pengumpulan</h6>
        <p>{{ $tugas->waktu_pengumpulan }}</p>
        <hr>
        <h5>Status Verifikasi Tugas</h5>
        <p
            class="badge rounded-pill 
    {{ $tugas->status == 'sedang diperiksa' ? 'text-bg-primary' : '' }}
    {{ $tugas->status == 'disetujui' ? 'text-bg-success' : '' }}
    {{ $tugas->status == 'ditolak' ? 'text-bg-danger' : '' }} fs-6">
            {{ $tugas->status }}</p>
        @if ($tugas->status == 'ditolak')
            <h6 class="m-0 p-0">Alasan penolakan : </h6>
            <p>{{ $tugas->alasanPenolakan()[0] }}</p>
        @endif
        <hr>
        <a href="{{ asset('storage/luaran_tugas/' . $tugas->file_luaran) }}" target="blank"
            class="d-inline-block btn btn-primary">Lihat Tugas</a>
    </div>
@endsection
