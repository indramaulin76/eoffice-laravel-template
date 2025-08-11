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
            <a href="{{ Storage::url($surat->file_surat) }}" target="blank" class="d-inline-block btn btn-primary">Lihat
                File Surat</a>

            @if ($surat->status == 'Dalam Proses')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTerima">
                    Setujui Draf Surat
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak">
                    Tolak Draf Surat
                </button>

                {{-- Modal Terima --}}
                <div class="modal fade" id="modalTerima" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Terima Draf Surat?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Anda yakin ingin menerima Draf Surat ini? Draf Surat yang sudah diterima tidak dapat diubah
                                lagi.
                            </div>
                            <div class="modal-footer">
                                <form
                                    action="{{ route('surat-keluar.verifikasi.terima', ['surat' => $surat->nomor_surat]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Ya</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Tolak --}}
                <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tolak Laporan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('surat-keluar.verifikasi.tolak', ['surat' => $surat->nomor_surat]) }}"
                                method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="catatan" class="form-label">Alasan Penolakan</label>
                                        <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" rows="3"
                                            placeholder="Mohon jelaskan alasan penolakan laporan" required></textarea>
                                        @error('catatan')
                                            <label for="catatan" class="invalid-feedback">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Tolak Laporan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
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
