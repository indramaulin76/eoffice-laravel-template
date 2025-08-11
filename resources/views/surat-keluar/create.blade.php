@extends('layouts.main')

@section('container')
    <div class="ms-3">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="border-bottom border-black">
        <h1 class="ms-3">Buat Surat Keluar Baru</h1>
    </div>
    <br>
    <form action="{{ route('surat-keluar.store') }}" enctype="multipart/form-data" method="POST" class="input-container ">
        @csrf
        <div class="d-flex justify-content-end gap-1">
            <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
            <button class="btn btn-outline-primary" style="width: 100px">Batal</button>
        </div>
        <div class="row gy-3 mb-3">
            <div class="col-6">
                <label for="tanggalSuratInput" class="form-label">Tanggal Surat Dikirim</label>
                <input type="date" name="tanggal_surat" id="tanggalSuratInput"
                    class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat') }}">
                @error('tanggal_surat')
                    <label for="tanggalSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="perihalSuratInput" class="form-label">Perihal Surat</label>
                <input type="text" name="perihal" id="perihalSuratInput"
                    class="form-control @error('perihal') is-invalid @enderror" placeholder="Masukkan perihal/tajuk surat"
                    value="{{ old('perihal') }}">
                @error('perihal')
                    <label for="perihalSuratInput" class="invalid-feedback">{{ $message }}</label>
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
        </div>
        <div class="row gy-3 mb-3">
            <div class="col-6">
                <label for="alamatSuratInput" class="form-label ">Alamat Surat</label>
                <input type="text" name="alamat" id="alamatSuratInput"
                    class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat tujuan surat "
                    value="{{ old('alamat') }}">
                @error('alamat')
                    <label for="alamatSuratInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="penandatanganInput" class="form-label d-block">Penandatangan Surat</label>
                <select name="penandatangan_id" id="penandatanganInput" class="select2 w-100 m-0 p-0 @error('penandatangan_id') is-invalid @enderror" style="width: 100%; height: 100%;">
                    <option value="">Pilih Penandatangan Surat</option>
                    @foreach ($penandatangan as $penandatangan)
                        @if ($penandatangan->id == auth()->id())
                            @continue
                        @endif
                        <option value="{{ $penandatangan->id }}" @selected(old('penandatangan_id') == $penandatangan->id)>{{ $penandatangan->nama }}</option>
                    @endforeach
                </select>
                @error('penandatangan_id')
                    <label for="penandatanganInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row gy-3 mb-3">
        </div>
        <textarea class="my-3" name="body" id="isiSurat" cols="30" rows="10">
            {{ old('body') ?? '' }}
        </textarea>
        @error('body')
            <label for="isiSurat" class="invalid-feedback">{{ $message }}</label>            
        @enderror
        <div class="my-3">
            <label for="formFile" class="form-label">atau unggah file hasil pindaian surat dalam format .pdf dengan
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
    </form>
@endsection

@section('scripts')
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        $('#document').ready(function() {
            $('#penandatanganInput').select2({
                placeholder: "Pilih Penandatangan Surat",
            });
            // Initialize CKEditor
            ClassicEditor
                .create(document.querySelector('#isiSurat'), {
                    placeholder: 'Silahkan Ketik isi surat di sini'
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endsection
