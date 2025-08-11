@extends('layouts.main')

@section('container')
    <div class="ms-3">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="border-bottom border-black">
        <h1 class="ms-3">Arsip Surat Masuk Baru</h1>
    </div>
    <br>
    <form action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data" method="POST" class="input-container ">
        @csrf
        <div class="d-flex justify-content-end gap-1">
            <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
            <button class="btn btn-outline-primary" style="width: 100px">Batal</button>
        </div>
        <div class="row gy-3 mb-3">
            <div class="col-6">
                <label for="perihalSuratInput" class="form-label">Perihal Surat</label>
                <input type="text" name="perihal" id="perihalSuratInput"
                    class="form-control @error('perihal') is-invalid @enderror" placeholder="Masukkan perihal/tajuk surat"
                    value="{{ old('perihal') }}">
                @error('perihal')
                    <label for="perihalSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="nomorSuratInput" class="form-label">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="nomorSuratInput"
                    class="form-control @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat"
                    value="{{ old('nomor_surat') }}">
                @error('nomor_surat')
                    <label for="nomorSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row gy-3 mb-3">
            <div class="col-6">
                <label for="tanggalSuratInput" class="form-label">Tanggal Surat Diterima</label>
                <input type="date" name="tanggal_surat" id="tanggalSuratInput"
                    class="form-control @error('tanggal_surat') is-invalid @enderror"
                    value="{{ old('tanggal_surat') }}">
                @error('tanggal_surat')
                    <label for="tanggalSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row gy-3 mb-3">
            <div class="col-6">
                <label for="asalSuratInput" class="form-label ">Asal Surat</label>
                <input type="text" name="asal" id="asalSuratInput"
                    class="form-control @error('asal') is-invalid @enderror"
                    placeholder="Masukkan nama instansi/orang pengirim surat" value="{{ old('asal') }}">
                @error('asal')
                    <label for="asalSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="tujuanSuratInput" class="form-label ">Tujuan Surat</label>
                <input type="text" name="tujuan" id="tujuanSuratInput"
                    class="form-control @error('tujuan') is-invalid @enderror"
                    placeholder="Masukkan pejabat/bagian penerima surat" value="{{ old('tujuan') }}">
                @error('tujuan')
                    <label for="tujuanSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="">
                <label for="formFile" class="form-label">Silahkan unggah file hasil pindaian surat dalam format .pdf dengan
                    ukuran maksimal 5MB</label>
                <input
                    class="form-control @error('file_surat')
                        is-invalid
                    @enderror"
                    name="file_surat" type="file" id="formFile" value="{{ old('file_surat') }}">
                @error('file_surat')
                    <label for="formFile" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </form>
@endsection
