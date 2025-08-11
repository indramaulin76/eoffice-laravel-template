@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h1>Buat SPPD Baru</h1>
    <hr>
    @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
        @endif
    <form action="{{ route('sppd.store') }}" method="POST" class="input-container ">
        @csrf
        <div class="d-flex justify-content-end gap-1">
            <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
            <button class="btn btn-outline-primary" style="width: 100px">Batal</button>
        </div>
        <div class="row gy-3 mb-5">
            <div class="col-6">
                <label for="pemberiPerintahInput" class="form-label d-block">Pemberi Perintah</label>
                <select name="pemberi_perintah_id" id="pemberiPerintahInput" class="select2 w-100 @error('pemberi_perintah_id') is-invalid @enderror" style="width: 100%">
                    <option value="">Pilih Pemberi Perintah</option>
                    @foreach ($supervisors as $user)
                        <option value="{{ $user->id }}" @selected(old('pemberi_perintah_id') == $user->id)>{{ $user->nama }}</option>
                    @endforeach
                </select>
                @error('pemberi_perintah_id')
                    <label for="pemberiPerintahInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="pelaksanaInput" class="form-label d-block">Pelaksana</label>
                <select name="pelaksana_id" id="pelaksanaInput" class="select2 @error('pelaksana_id') is-invalid @enderror" style="width: 100%">
                    <option value="">Pilih Pelaksana</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('pelaksana_id') == $user->id)>{{ $user->nama }}</option>
                    @endforeach
                </select>
                @error('pelaksana_id')
                    <label for="pelaksanaInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="jabatanPemberiPerintahInput" class="form-label">Jabatan Pemberi Perintah</label>
                <input type="text" name="jabatan_pemberi_perintah" id="jabatanPemberiPerintahInput" class="form-control @error('jabatan_pemberi_perintah_id') is-invalid @enderror"
                    placeholder="Diisi otomatis" value="{{ old('jabatan_pemberi_perintah') }}" readonly>
                <input type="hidden" name="jabatan_pemberi_perintah_id" id="jabatanPemberiPerintahID" value="{{ old('jabatan_pemberi_perintah_id') }}">
                @error('jabatan_pemberi_perintah_id')
                    <label for="jabatanPemberiPerintahInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="jabatanPelaksanaInput" class="form-label">Jabatan Pelaksana</label>
                <input type="text" name="jabatan_pelaksana" id="jabatanPelaksanaInput" class="form-control @error('jabatan_pelaksana_id') is-invalid @enderror"
                    placeholder="Diisi otomatis" value="{{ old('jabatan_pelaksana') }}" readonly>
                <input type="hidden" name="jabatan_pelaksana_id" id="jabatanPelaksanaID" value="{{ old('jabatan_pelaksana_id') }}">
                @error('jabatan_pelaksana_id')
                    <label for="jabatanPelaksanaInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row gy-3 mb-3">
            <div class="col-6">
                <label for="tanggalSuratInput" class="form-label">Tanggal Surat</label>
                <input type="date" name="tanggal_surat" id="tanggalSuratInput" class="form-control @error('tanggal_surat') is-invalid @enderror"
                    value="{{ now()->format('Y-m-d') }}">
                @error('tanggal_surat')
                    <label for="tanggalSuratInput" class="invalid-feedback">{{ $message }}</label>                    
                @enderror
            </div>
            <div class="col-6">
                <label for="tanggalMulaiInput" class="form-label ">Tanggal Mulai Dinas</label>
                <input type="date" name="tanggal_mulai" id="tanggalMulaiInput" class="form-control @error('tanggal_mulai') is-invalid @enderror " value="{{ old('tanggal_mulai') }}">
                @error('tanggal_mulai')
                    <label for="tanggalMulaiInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-6">
                <label for="tujuanPerjalananInput" class="form-label ">Keperluan Perjalanan</label>
                <input type="text" name="keperluan_perjalanan" id="tujuanPerjalananInput" class="form-control @error('keperluan_perjalanan') is-invalid @enderror"
                    placeholder="Masukkan keperluan perjalanan dinas" value="{{ old('keperluan_perjalanan') }}">
                @error('keperluan_perjalanan')
                    <label for="tujuanPerjalananInput" class="invalid-feedback">{{ $message }}</label>                    
                @enderror
            </div>
            <div class="col-6">
                <label for="tanggalSelesaiInput" class="form-label ">Tanggal Selesai Dinas</label>
                <input type="date" name="tanggal_selesai" id="tanggalSelesaiInput" class="form-control @error('tanggal_selesai') is-invalid @enderror " value="{{ old('tanggal_selesai') }}">
                @error('tanggal_selesai')
                    <label for="tanggalSelesaiInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="alamatPerjalananInput" class="form-label ">Tujuan Perjalanan</label>
                <textarea type="text" name="alamat_perjalanan" id="alamatPerjalananInput" class="form-control @error('alamat_perjalanan') is-invalid @enderror"
                    placeholder="Masukkan alamat tujuan perjalanan dinas">{{ old('alamat_perjalanan') }}</textarea>
                @error('alamat_perjalanan')
                    <label for="alamatPerjalananInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="anggaranInput" class="form-label ">Anggaran</label>
                <input type="number" name="anggaran" id="anggaranInput" class="form-control @error('anggaran') is-invalid @enderror" value="{{ old('anggaran') }}">
                @error('anggaran')
                    <label for="anggaranInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="keteranganInput" class="form-label">Keterangan</label>
                <textarea type="text" name="keterangan" id="keteranganInput" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <label for="keteranganInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // render select2 inputs
            $('.select2').select2({});



        });
        // get jabatan pemberi perintah
        var users = @json($users);
        var supervisors = @json($supervisors);
        console.log(users);
        $('#pemberiPerintahInput').on('change', function() {
            let selectedPemberiPerintah = supervisors.find(supervisor => supervisor.id == $(this).val());
            console.log(selectedPemberiPerintah);
            $('#jabatanPemberiPerintahInput').val(selectedPemberiPerintah.jabatan.nama);
            $('#jabatanPemberiPerintahID').val(selectedPemberiPerintah.jabatan.id);
        })

        $('#pelaksanaInput').on('change', function() {
            let selectedPelaksana = users.find(user => user.id == $(this).val());
            console.log(selectedPelaksana);
            $('#jabatanPelaksanaInput').val(selectedPelaksana.jabatan.nama);
            $('#jabatanPelaksanaID').val(selectedPelaksana.jabatan.id);
        })
    </script>
@endsection
