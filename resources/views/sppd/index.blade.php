@extends('layouts.master')

@section('container')
    <div style="width: 85%" class="mx-4 my-2">
        <div class="container bg-white my-3 rounded p-3 pb-0 shadow">
            <div class="ms-3">
                {{ Breadcrumbs::render() }}
            </div>
            <div class="border-bottom border-black">
                <h1 class="ms-3">Surat Perintah Perjalanan Dinas</h1>
            </div>
            <br>
            @can('buat sppd')
                <div class="d-flex justify-content-end pb-3">
                    <a href="{{ route('sppd.create') }}" class="btn btn-outline-primary fs-5"><i class="fa-solid fa-plus"></i> Buat
                        SPPD Baru</a>
                </div>
            @endcan
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-mendatang-tab" data-bs-toggle="tab" data-bs-target="#nav-mendatang"
                    type="button" role="tab" aria-controls="nav-mendatang" aria-selected="true">Mendatang</button>
                <button class="nav-link " id="nav-berjalan-tab" data-bs-toggle="tab" data-bs-target="#nav-berjalan"
                    type="button" role="tab" aria-controls="nav-berjalan" aria-selected="false">Sedang
                    Berjalan</button>
                <button class="nav-link" id="nav-selesai-tab" data-bs-toggle="tab" data-bs-target="#nav-selesai"
                    type="button" role="tab" aria-controls="nav-selesai" aria-selected="false">Sudah
                    Selesai</button>
            </div>
        </nav>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="nav-mendatang" role="tabpanel" aria-labelledby="nav-mendatang-tab"
                tabindex="0">
                @foreach ($upcomingSppd as $s)
                    <a href="{{ route('sppd.show', ['sppd' => $s]) }}" class="text-decoration-none text-black">
                        <div class="container bg-white my-3 rounded p-3 shadow">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>
                                    <h4>{{ $s->keperluan_perjalanan }}</h4>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                        {{ $s->tanggalMulai() }} - {{ $s->tanggalSelesai() }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                                        {{ $s->alamat_perjalanan }}
                                    </div>
                                </div>
                                {{-- {{ $s->laporanPerjalananDinas}} --}}
                                @if ($s->laporanPerjalananDinas)
                                    <span
                                        class="badge rounded-pill {{ $s->laporanPerjalananDinas->status == 'Dalam Proses' ? 'text-bg-primary' : '' }} {{ $s->laporanPerjalananDinas->status == 'Disetujui' ? 'text-bg-success' : '' }} {{ $s->laporanPerjalananDinas->status == 'Ditolak' ? 'text-bg-danger' : '' }} py-2 px-4 fs-5 text-capitalize"
                                        style="width: fit-content;">
                                        {{ $s->laporanPerjalananDinas->status }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-bg-warning py-2 px-4 fs-5 text-capitalize"
                                        style="width: fit-content;">
                                        Laporan Belum Diunggah
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="tab-pane fade" id="nav-berjalan" role="tabpanel" aria-labelledby="nav-berjalan-tab" tabindex="0">
                @foreach ($onGoingSppd as $s)
                    <a href="{{ route('sppd.show', ['sppd' => $s]) }}" class="text-decoration-none text-black">
                        <div class="container bg-white my-3 rounded p-3 shadow">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>
                                    <h4>{{ $s->keperluan_perjalanan }}</h4>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                        {{ $s->tanggalMulai() }} - {{ $s->tanggalSelesai() }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                                        {{ $s->alamat_perjalanan }}
                                    </div>
                                </div>
                                {{-- {{ $s->laporanPerjalananDinas}} --}}
                                @if ($s->laporanPerjalananDinas)
                                    <span
                                        class="badge rounded-pill {{ $s->laporanPerjalananDinas->status == 'Dalam Proses' ? 'text-bg-primary' : '' }} {{ $s->laporanPerjalananDinas->status == 'Disetujui' ? 'text-bg-success' : '' }} {{ $s->laporanPerjalananDinas->status == 'Ditolak' ? 'text-bg-danger' : '' }} py-2 px-4 fs-5 text-capitalize"
                                        style="width: fit-content;">
                                        {{ $s->laporanPerjalananDinas->status }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-bg-warning py-2 px-4 fs-5 text-capitalize"
                                        style="width: fit-content;">
                                        Laporan Belum Diunggah
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="tab-pane fade" id="nav-selesai" role="tabpanel" aria-labelledby="nav-selesai-tab" tabindex="0">
                @foreach ($pastSppd as $s)
                    <a href="{{ route('sppd.show', ['sppd' => $s]) }}" class="text-decoration-none text-black">
                        <div class="container bg-white my-3 rounded p-3 shadow">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>
                                    <h4>{{ $s->keperluan_perjalanan }}</h4>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                        {{ $s->tanggalMulai() }} - {{ $s->tanggalSelesai() }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                                        {{ $s->alamat_perjalanan }}
                                    </div>
                                </div>
                                {{-- {{ $s->laporanPerjalananDinas}} --}}
                                @if ($s->laporanPerjalananDinas)
                                    <span
                                        class="badge rounded-pill {{ $s->laporanPerjalananDinas->status == 'Dalam Proses' ? 'text-bg-primary' : '' }} {{ $s->laporanPerjalananDinas->status == 'Disetujui' ? 'text-bg-success' : '' }} {{ $s->laporanPerjalananDinas->status == 'Ditolak' ? 'text-bg-danger' : '' }} py-2 px-4 fs-5 text-capitalize"
                                        style="width: fit-content;">
                                        {{ $s->laporanPerjalananDinas->status }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-bg-warning py-2 px-4 fs-5 text-capitalize"
                                        style="width: fit-content;">
                                        Laporan Belum Diunggah
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
