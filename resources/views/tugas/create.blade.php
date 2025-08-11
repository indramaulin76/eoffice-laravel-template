@extends('layouts.main')

@section('container')
    <style>
        .color-sample {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 5px;
            vertical-align: middle;
            border: 1px solid #ccc;
            border-radius: 50%;
        }
    </style>
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h1>Unggah Bukti Tugas</h1>
    <hr>
    <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="judulInput" class="form-label">Judul tugas</label>
            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judulInput"
                value="{{ old('judul') }}">
            @error('judul')
                <label for="judulInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="mb-3">
            {{-- uraian is actually detailAbk --}}
            <label for="perihalInput" class="form-label" value="{{ old('perihal') }}">Uraian Tugas</label>
            <select class="form-select @error('uraian') is-invalid @enderror" name="uraian" id="uraianInput">
                <option value="">Pilih uraian</option>
                @foreach ($detailAbk as $uraian)
                    <option value="{{ $uraian['nama_tugas'] }}" data-bobot="{{ $uraian['bobot'] }}" data-target="{{ $uraian['target'] }}">
                        {{ $uraian['nama_tugas'] }}</option>
                @endforeach
            </select>
            <input type="hidden" name="bobot" id="bobotInput">
            <input type="hidden" name="target" id="targetInput">
            @error('uraian')
                <label for="uraianInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="mb-3">
            <label for="keteranganInput" class="form-label">Keterangan</label>
            <input class="form-control @error('keterangan') is-invalid @enderror" type="text" name="keterangan"
                id="keteranganInput" value="{{ old('keterangan') }}">
            @error('keterangan')
                <label for="keteranganInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="mb-3">
            <label for="fileInput" class="form-label">Upload File</label>
            <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="fileInput">
            @error('file')
                <label for="fileInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="d-flex justify-content-end gap-1">
            <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
            <button class="btn btn-outline-primary" style="width: 100px">Batal</button>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#uraianInput').on('change', function() {
                // Ambil option yang dipilih
                var selectedOption = $(this).find('option:selected');
                console.log(selectedOption);

                // Ambil value dari data-bobot
                var bobot = selectedOption.data('bobot');
                console.log(bobot);

                // Update hidden input
                $('#bobotInput').val(bobot);

                // Ambil value dari data-target
                var target = selectedOption.data('target');
                console.log(target);

                // Update hidden input
                $('#targetInput').val(target);
            });
        });
    </script>
@endsection
