@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h1>{{ $sppd->keperluan_perjalanan }}</h1>
    <hr>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="">
        <h6>Nomor SPPD</h6>
        <p>{{ $sppd->nomor_surat }}</p>
        <h6>Pemberi Perintah</h6>
        <p>{{ $sppd->pemberiPerintah->nama }} | {{ $sppd->pemberiPerintah->jabatan->nama }}</p>
        <h6>Alamat Tujuan Perjalanan</h6>
        <p>{{ $sppd->alamat_perjalanan }}</p>
        <h6>Tanggal Mulai</h6>
        <p>{{ $sppd->tanggalMulai() }}</p>
        <h6>Tanggal Selesai</h6>
        <p>{{ $sppd->tanggalSelesai() }}</p>
        <h6>Anggaran</h6>
        <p>{{ $sppd->anggaran() }}</p>
        <hr>

        @if (!$sppd->laporanPerjalananDinas)
            <h2>Unggah Laporan Perjalanan Dinas</h2>
            {{-- <p>{{ $sppd->laporanPerjalananDinas->status }}</p> --}}
            <form action="{{ route('laporan-dinas.store') }}" enctype="multipart/form-data" class="row gy-3" method="POST">
                @csrf
                <div class="">
                    <label for="formFile" class="form-label">Silahkan unggah file laporan dinas dalam format .pdf dengan
                        ukuran maksimal 5MB</label>
                    <input
                        class="form-control @error('file_laporan')
                        is-invalid
                    @enderror"
                        name="file_laporan" type="file" id="formFile">
                    @error('file_laporan')
                        <label for="formFile" class="invalid-feedback">{{ $message }}</label>
                    @enderror
                </div>
                <div class="">
                    <label for="keteranganInput" class="form-label">Keterangan</label>
                    <textarea type="text" name="keterangan" id="alamatPerjalananInput"
                        class="form-control @error('keterangan') is-invalid @enderror" placeholder="Silahkan isi keterangan bila perlu">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <label for="keteranganInput" class="invalid-feedback">{{ $message }}</label>
                    @enderror
                </div>
                <div class="">
                    <input type="hidden" name="perjalanan_dinas_id" value="{{ $sppd->id }}">
                    <input type="hidden" name="nomor_sppd" value="{{ $sppd->nomor_surat }}">
                    <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
                </div>
            </form>
        @else
            <h5>Status Verifikasi Laporan Dinas</h5>
            <p
                class="badge rounded-pill 
    {{ $sppd->laporanPerjalananDinas->status == 'Dalam Proses' ? 'text-bg-primary' : '' }}
    {{ $sppd->laporanPerjalananDinas->status == 'Disetujui' ? 'text-bg-success' : '' }}
    {{ $sppd->laporanPerjalananDinas->status == 'Ditolak' ? 'text-bg-danger' : '' }} fs-6">
                {{ $sppd->laporanPerjalananDinas->status }}</p>
            @if ($sppd->laporanPerjalananDinas->status == 'Ditolak')
                <h6 class="m-0 p-0">Alasan penolakan : </h6>
                <p>{{ $sppd->laporanPerjalananDinas->alasanPenolakan()[0] }}</p>
            @endif
            <hr>
            <a href="{{ Storage::url($sppd->laporanPerjalananDinas->file_laporan) }}" target="blank"
                class="d-inline-block btn btn-primary">Lihat Laporan Dinas</a>
        @endif
    </div>
@endsection
