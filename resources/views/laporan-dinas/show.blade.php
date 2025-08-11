@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h1>{{ $perjalananDinas->keperluan_perjalanan }}</h1>
    <hr>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="">
        <h6>Nomor SPPD</h6>
        <p>{{ $perjalananDinas->nomor_surat }}</p>
        <h6>Pemberi Perintah</h6>
        <p>{{ $perjalananDinas->pemberiPerintah->nama }} | {{ $perjalananDinas->pemberiPerintah->jabatan->nama }}</p>
        <h6>Alamat Tujuan Perjalanan</h6>
        <p>{{ $perjalananDinas->alamat_perjalanan }}</p>
        <h6>Tanggal Mulai</h6>
        <p>{{ $perjalananDinas->tanggalMulai() }}</p>
        <h6>Tanggal Selesai</h6>
        <p>{{ $perjalananDinas->tanggalSelesai() }}</p>
        <h6>Anggaran</h6>
        <p>{{ $perjalananDinas->anggaran() }}</p>
        <hr>

        @if (!$perjalananDinas->laporanPerjalananDinas)
            <h5>Belum Ada Laporan Dinas</h5>
        @else
            <h5>Verifikasi Laporan Dinas</h5>
            <div class="mb-3">
                <a href="{{ Storage::url($perjalananDinas->laporanPerjalananDinas->file_laporan) }}" target="blank"
                    class="d-inline-block btn btn-primary">Lihat Laporan Dinas</a>

                @if ($perjalananDinas->laporanPerjalananDinas->status == 'Dalam Proses')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTerima">
                        Terima Laporan
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak">
                        Tolak Laporan
                    </button>

                    {{-- Modal Terima --}}
                    <div class="modal fade" id="modalTerima" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Terima Laporan?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Anda yakin ingin menerima laporan ini? Laporan yang sudah diterima tidak dapat diubah
                                    lagi.
                                </div>
                                <div class="modal-footer">
                                    <form
                                        action="{{ route('laporan-dinas.verifikasi.terima', ['laporan' => $perjalananDinas->laporanPerjalananDinas]) }}"
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
                                <form
                                    action="{{ route('laporan-dinas.verifikasi.tolak', ['laporan' => $perjalananDinas->laporanPerjalananDinas]) }}"
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
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Tolak Laporan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                     <h6 class="mt-3">Status Verifikasi Laporan Dinas</h6>
                <p
                    class="badge rounded-pill 
    {{ $perjalananDinas->laporanPerjalananDinas->status == 'Dalam Proses' ? 'text-bg-primary' : '' }}
    {{ $perjalananDinas->laporanPerjalananDinas->status == 'Disetujui' ? 'text-bg-success' : '' }}
    {{ $perjalananDinas->laporanPerjalananDinas->status == 'Ditolak' ? 'text-bg-danger' : '' }} fs-6">
                    {{ $perjalananDinas->laporanPerjalananDinas->status }}</p>
                @endif
                @if ($perjalananDinas->laporanPerjalananDinas->status == 'Ditolak')
                    <h6 class="m-0 p-0">Alasan penolakan : </h6>
                    <p>{{ $perjalananDinas->laporanPerjalananDinas->alasanPenolakan()[0] }}</p>
                    
                @endif

            </div>               
        @endif
    </div>
@endsection
