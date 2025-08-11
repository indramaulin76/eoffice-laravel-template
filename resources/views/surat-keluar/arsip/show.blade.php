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

        <div class="mb-3">
            <h6>File Surat</h6>
            <a href="{{ Storage::url($surat->file_surat) }}" target="blank"
                class="d-inline-block btn btn-primary mb-3">Lihat
                File Surat</a>

            <h6>Arsip Surat</h6>
            @if ($surat->file_arsip)
                <p><a href="{{ Storage::url('arsip-surat-keluar' . '/' . $surat->file_arsip) }}" target="blank"
                        class="d-inline-block btn btn-success">Lihat File Arsip</a></p>
            @else
                <p>Arsip Tidak Ditemukan</p>
            @endif

            @can('buat arsip surat')
                <form action="{{ route('surat-keluar.arsip.update', ['surat' => $surat]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <h6>Buat/Perbarui arsip surat</h6>
                        <label for="formFile" class="form-label">Upload File surat yang sudah ditandatangani dan diberi cap
                            (dalam format .pdf, Maks. 5MB)</label>
                        <input class="form-control @error('file_arsip') is-invalid @enderror mb-3" name="file_arsip"
                            type="file" id="formFile">
                        @error('file_arsip')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                        @enderror
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#confirmModal">Buat / Perbarui</button>
                        <div class="modal fade" tabindex="-1" id="confirmModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Buat / Perbarui Arsip Surat?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin membuat / memperbarui arsip surat? Arsip surat yang sudah ada akan
                                            terhapus jika anda membuat arsip surat yang baru.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                        <button type="submit" class="btn btn-primary">Ya</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endcan

        </div>
    </div>
@endsection
