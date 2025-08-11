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
    <h1>Tambah Jadwal Rapat</h1>
    <hr>
    <form action="{{ route('rapat.store') }}" method="POST">
        @csrf
        <div class="d-flex justify-content-end gap-1">
            <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
            <button class="btn btn-outline-primary" style="width: 100px">Batal</button>
        </div>
        <div class="mb-3">
            <label for="judulInput" class="form-label">Judul Rapat</label>
            <input class="form-control @error('judul') is-invalid @enderror" type="text" name="judul" id="judulInput"
                value="{{ old('judul') }}">
            @error('judul')
                <label for="judulInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="mb-3">
            <label for="perihalInput" class="form-label" value="{{ old('perihal') }}">Perihal</label>
            <input class="form-control @error('perihal') is-invalid @enderror" type="text" name="perihal"
                id="perihalInput" value="{{ old('judul') }}">
            @error('perihal')
                <label for="perihalInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="tanggalInput" class="form-label ">Tanggal</label>
                <input class="form-control  @error('tanggal') is-invalid @enderror" type="date" name="tanggal"
                    id="tanggalInput" value="{{ old('tanggal') }}">
                @error('tanggal')
                    <label for="tanggalInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="tempatInput" class="form-label">Tempat</label>
                <select class="form-select @error('tempat') is-invalid @enderror" name="tempat" id="tempatInput">
                    <option value="">Pilih Tempat</option>
                    <option value="Tempat 1" @selected(old('tempat') == 'Tempat 1')>Tempat 1</option>
                    <option value="Tempat 2" @selected(old('tempat') == 'Tempat 2')>Tempat 2</option>
                    <option value="Tempat 3" @selected(old('tempat') == 'Tempat 3')>Tempat 3</option>
                    <option value="Tempat 4" @selected(old('tempat') == 'Tempat 4')>Tempat 4</option>
                    <option value="Tempat 5" @selected(old('tempat') == 'Tempat 5')>Tempat 5</option>
                </select>
                @error('tempat')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="waktuMulaiInput" class="form-label ">Waktu Mulai</label>
                <input class="form-control @error('waktuMulai') is-invalid @enderror" type="time" name="waktuMulai"
                    id="waktuMulaiInput" value="{{ old('waktuMulai') }}">
                @error('waktuMulai')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="pimpinanInput" class="form-label">Pimpinan Rapat</label>
                <select class="form-select @error('pemimpinRapat') is-invalid @enderror" name="pemimpinRapat"
                    id="pimpinanInput">
                    <option value="">Pilih Pimpinan</option>
                    @foreach ($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}" @selected(old('pemimpinRapat') == $pegawai->id)>{{ $pegawai->nama }}</option>
                    @endforeach
                </select>
                @error('pemimpinRapat')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="waktuSelesaiInput" class="form-label ">Waktu Selesai</label>
                <input class="form-control @error('waktuSelesai') is-invalid @enderror" type="time" name="waktuSelesai"
                    id="waktuSelesaiInput" value="{{ old('waktuSelesai') }}">
                @error('waktuSelesai')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="color-selection" class="mb-3">Pilih Warna Label Rapat</label>
                <div class="mb-3" id="color-selection">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="warnaLabel" id="editColorRed" value="#d50000">
                        <label class="form-check-label" for="colorRed">
                            <span class="color-sample" style="background-color: #d50000;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="warnaLabel" id="editColorBlue"
                            value="#039ae5">
                        <label class="form-check-label" for="colorBlue">
                            <span class="color-sample" style="background-color: #039ae5;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="warnaLabel" id="editColorGreen"
                            value="#33b679">
                        <label class="form-check-label" for="colorGreen">
                            <span class="color-sample" style="background-color: #33b679;"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <label for="pesertaTable" class="form-label fs-4">Pilih Peserta Rapat</label>
        <div class="">
            <label for="selectAll" class="form-label">Pilih Semua</label>
            <input type="checkbox" id="selectAll">
            <input type="hidden" id="semuaPesertaInput" >
        </div>
        @error('pesertaRapat')
            <label for="selectAll" class="form-label" style="color: red">{{ $message }}</label>
        @enderror
        <table id="pesertaTable" class="display">
            <thead>
                <tr>
                    <th>Pilih Semua</th>
                    <th>Nama Pegawai</th>
                    <th>NIP</th>
                    <th>Unit Kerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $p)
                    <tr>
                        <td><input type="checkbox" class="pesertaCheckbox" name="pesertaRapat[]"
                                value="{{ $p->id }}"></td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->unitKerja->nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#pesertaTable').DataTable();

        });
        
        $('#selectAll').on('click', function() {
            var semuaPeserta = @json($pegawais->map(function($pegawai) {
                return $pegawai->id;
            }));
            
            console.log(semuaPeserta);
            
            $('.pesertaCheckbox').prop('disabled', this.checked);
            if (this.checked) {
                $('.pesertaHidden').remove();
                semuaPeserta.forEach(peserta => {
                    $('#semuaPesertaInput').after(`<input type="hidden" class="pesertaHidden" name="pesertaRapat[]" value="${peserta}">`);
                });
            }
            else {
                $('.pesertaHidden').remove();
            }
        });

        // Update status "Select All" saat checkbox individual berubah
        $('.pesertaCheckbox').on('click', function() {
            if ($('.pesertaCheckbox:checked').length == $('.pesertaCheckbox').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });
    </script>
@endsection
