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
    <h1>Detail Rapat</h1>
    <hr>
    <form action="{{ route('rapat.update', ['rapat' => $rapat]) }}" method="POST">
        @csrf
        @method('PATCH')
        @can('buat rapat')
            <div class="d-flex justify-content-between gap-1 align-items-center mb-2">
                <div class="form-check form-switch d-flex align-items-center gap-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="editRapatToggle"
                        style="height: 1.5rem; width: 3.2rem;">
                    <label class="form-check-label" for="editRapatToggle">Edit Rapat</label>
                </div>
                <div class="d-flex justify-content-end gap-1" id="editButtons" style="visibility: hidden;">
                    <button class="btn btn-primary header1" style="width: 100px" type="submit">Simpan</button>
                </div>
            </div>
        @endcan
        <div class="mb-3">
            <label for="judulInput" class="form-label">Judul</label>
            <input disabled class="form-control @error('judul') is-invalid @enderror" type="text" name="judul"
                id="judulInput" value="{{ $rapat->judul }}">
            @error('judul')
                <label for="judulInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="mb-3">
            <label for="perihalInput" class="form-label" value="{{ old('perihal') }}">Perihal</label>
            <input disabled class="form-control @error('perihal') is-invalid @enderror" type="text" name="perihal"
                id="perihalInput" value="{{ $rapat->perihal }}">
            @error('perihal')
                <label for="perihalInput" class="invalid-feedback">{{ $message }}</label>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="tanggalInput" class="form-label ">Tanggal</label>
                <input disabled class="form-control  @error('tanggal') is-invalid @enderror" type="date" name="tanggal"
                    id="tanggalInput" value="{{ $rapat->tanggal() }}">
                @error('tanggal')
                    <label for="tanggalInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="tempatInput" class="form-label">Tempat</label>
                <input disabled class="form-control @error('tempat') is-invalid @enderror" type="text" name="tempat"
                    id="tempatInput" value="{{ $rapat->tempat }}">
                @error('tempat')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="waktuMulaiInput" class="form-label ">Waktu Mulai</label>
                <input disabled class="form-control @error('waktuMulai') is-invalid @enderror" type="time"
                    name="waktuMulai" id="waktuMulaiInput" value="{{ $rapat->waktuMulai() }}">
                @error('waktuMulai')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="pimpinanInput" class="form-label">Pimpinan Rapat</label>
                <select disabled class="form-select @error('pemimpinRapat') is-invalid @enderror" name="pemimpinRapat"
                    id="pimpinanInput">
                    <option value="">Pilih Pimpinan</option>
                    @foreach ($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}" @selected($rapat->pemimpin_rapat_id == $pegawai->id)>{{ $pegawai->nama }}</option>
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
                <input disabled class="form-control @error('waktuSelesai') is-invalid @enderror" type="time"
                    name="waktuSelesai" id="waktuSelesaiInput" value="{{ $rapat->waktuSelesai() }}">
                @error('waktuSelesai')
                    <label for="tempatInput" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="col">
                <label for="color-selection" class="mb-3">Pilih Warna Label Rapat</label>
                <div class="mb-3" id="color-selection">
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" type="radio" name="warnaLabel" id="editColorRed"
                            value="#d50000" @checked($rapat->warna_label == '#d50000')>
                        <label class="form-check-label" for="editColorRed">
                            <span class="color-sample" style="background-color: #d50000;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" type="radio" name="warnaLabel" id="editColorBlue"
                            value="#039ae5" @checked($rapat->warna_label == '#039ae5')>
                        <label class="form-check-label" for="editColorBlue">
                            <span class="color-sample" style="background-color: #039ae5;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input disabled class="form-check-input" type="radio" name="warnaLabel" id="editColorGreen"
                            value="#33b679" @checked($rapat->warna_label == '#33b679')>
                        <label class="form-check-label" for="editColorGreen">
                            <span class="color-sample" style="background-color: #33b679;"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @can('buat rapat')
            <label for="pesertaTable" class="form-label fs-4">Pilih Peserta Rapat</label>
            <div class="">
                <label for="selectAll" class="form-label">Pilih Semua</label>
                <input disabled type="checkbox" id="selectAll">
                <input disabled type="hidden" id="semuaPesertaInput">
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
                    @foreach ($pegawais as $pegawai)
                        <tr>
                            <td><input disabled type="checkbox" class="pesertaCheckbox" name="pesertaRapat[]"
                                    value="{{ $pegawai->id }}" @checked($pesertas->contains('pegawai_id', $pegawai->id))></td>
                            <td>{{ $pegawai->nama }}</td>
                            <td>{{ $pegawai->nip }}</td>
                            <td>{{ $pegawai->unitKerja->nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <label for="pesertaTable" class="form-label fs-4">Daftar Peserta Rapat</label>
            <table id="pesertaTable" class="display">
                <thead>
                    <tr>
                        <th>Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Unit Kerja</th>
                        @if ($rapat->pemimpin_rapat_id == auth()->user()->id)
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesertas as $peserta)
                        <tr>
                            <td>{{ $peserta->pegawai->nama }}</td>
                            <td>{{ $peserta->pegawai->nip }}</td>
                            <td>{{ $peserta->pegawai->unitKerja->nama }}</td>
                            @if ($rapat->pemimpin_rapat_id == auth()->user()->id)
                                <td class="d-flex justify-content-center">
                                    <select id="selectAttendanceStatus"
                                        class="form-select badge rounded-pill py-2 px-4 fs-6 text-capitalize"
                                        style="width: 112px" aria-label="Default select example"
                                        data-status="{{ $peserta->status }}" data-peserta-id="{{ $peserta->pegawai->id }}"
                                        data-rapat-id="{{ $rapat->id }}">
                                        <option class="text-bg-danger" value="notset"
                                            {{ $peserta->status == 'notset' ? 'selected' : '' }}>Notset
                                        </option>
                                        <option class="text-bg-success" value="hadir"
                                            {{ $peserta->status == 'hadir' ? 'selected' : '' }}>Hadir
                                        </option>
                                        <option class="text-bg-warning" value="izin"
                                            {{ $peserta->status == 'izin' ? 'selected' : '' }}>Izin
                                        </option>
                                    </select>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endcan
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // rapat attendance start
            // Function to change the background color based on the selected value
            function updateSelectBackground(selectElement) {
                var status = $(selectElement).val();
                $(selectElement).removeClass(
                    "text-bg-success text-bg-warning text-bg-danger"
                ); // Remove all classes

                if (status === "hadir") {
                    $(selectElement).addClass("text-bg-success");
                } else if (status === "izin") {
                    $(selectElement).addClass("text-bg-warning text-white");
                } else if (status === "notset") {
                    $(selectElement).addClass("text-bg-danger");
                }
            }

            // Apply the background color when the page loads based on initial value
            $("select").each(function() {
                updateSelectBackground(this);
            });

            // Change the background color when the user changes the select option
            $("select").change(function() {
                var status = $(this).val();
                var pesertaId = $(this).data('peserta-id'); // Ambil peserta_id dari data attribute
                var rapatId = $(this).data('rapat-id'); // Ambil rapat_id

                // AJAX request
                $.ajax({
                    url: '/rapat/' + rapatId + '/presensi/peserta/' + pesertaId,
                    type: 'PATCH',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}' // Kirim CSRF token
                    },
                    success: function(response) {
                        // Handle success response
                        if (response.success) {
                            alert(response.message); // Ganti dengan notifikasi yang lebih baik
                        }
                    },
                    error: function(xhr) {
                        // Handle error response
                        alert('Terjadi kesalahan saat mengupdate status kehadiran.');
                    }
                });

                updateSelectBackground(this);
            });
            // rapat attendance end

            $('#pesertaTable').DataTable();

            // Toggle edit mode, enable/disable inputs and show/hide buttons
            $('#editRapatToggle').on('click', function() {
                $('#editButtons').css('visibility', this.checked ? 'visible' : 'hidden');

                // select all inputs that are disabled, except the switch input and enable them
                this.checked ? $('input:disabled, select:disabled').not('#editRapatToggle').prop('disabled',
                    false) : $('input,select').not('#editRapatToggle').prop('disabled', true);
            });
        });

        $('#selectAll').on('click', function() {
            var semuaPeserta = @json(
                $pegawais->map(function ($pegawai) {
                    return $pegawai->id;
                }));

            console.log(semuaPeserta);

            $('.pesertaCheckbox').prop('disabled', this.checked);
            if (this.checked) {
                $('.pesertaHidden').remove();
                semuaPeserta.forEach(peserta => {
                    $('#semuaPesertaInput').after(
                        `<input type="hidden" class="pesertaHidden" name="pesertaRapat[]" value="${peserta}">`
                    );
                });
            } else {
                $('.pesertaHidden').remove();
                console.log($('.pesertaHidden'));
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
