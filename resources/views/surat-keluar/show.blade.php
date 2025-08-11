@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h1>{{ $surat->perihal }}</h1>
    <hr>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="">
        <h6>Nomor Surat</h6>
        <p>{{ $surat->nomor_surat }}</p>
        <h6>Penulis/Pengonsep</h6>
        <p>{{ $surat->penulis->nama }} | {{ $surat->penulis->jabatan->nama }}</p>
        <h6>Asal Surat</h6>
        <p>{{ $surat->asal }}</p>
        <h6>Tujuan Surat</h6>
        <p>{{ $surat->tujuan }}</p>
        <h6>Alamat Tujuan Surat</h6>
        <p>{{ $surat->alamat_surat }}</p>
        <h6>Tanggal Surat</h6>
        <p>{{ $surat->tanggalDibuat() }}</p>
        <h6>Penandatangan Surat</h6>
        <p>{{ $surat->penandatangan->nama }} | {{ $surat->penandatangan->jabatan->nama }}</p>
        <hr>

        <h5>Verifikasi Surat Keluar</h5>
        <div class="mb-3">
            <a href="{{ asset('storage/surat_keluar/' . $surat->file_surat) }}" target="blank" class="d-inline-block btn btn-primary">Lihat
                File Surat</a>

            <h6 class="mt-3">Status Verifikasi Surat Keluar</h6>
            <p
                class="badge rounded-pill 
    {{ $surat->status == 'Dalam Proses' ? 'text-bg-primary' : '' }}
    {{ $surat->status == 'Disetujui' ? 'text-bg-success' : '' }}
    {{ $surat->status == 'Ditolak' ? 'text-bg-danger' : '' }} fs-6">
                {{ $surat->status }}</p>
            @if ($surat->status == 'Ditolak')
                <h6 class="m-0 p-0">Alasan penolakan : </h6>
                <p>{{ $surat->alasanPenolakan() }}</p>

            @endif

        </div>
    </div>
@endsection
