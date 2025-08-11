@extends('layouts.master')

@section('container')
    <div style="width: 85%;" class="mx-4 my-2">
        <div class="container bg-white my-3 rounded p-3 pb-0 shadow">
            <div class="ms-3">
                {{ Breadcrumbs::render() }}
            </div>
            <div class="border-bottom border-black">
                <h1 class="ms-3">Agenda Rapat</h1>
            </div>
            <br>

        </div>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Silakan klik untuk melihat detail rapat
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade " id="nav-berjalan" role="tabpanel" aria-labelledby="nav-berjalan-tab"
                tabindex="0">
                @foreach ($onGoingRapats as $rapat)
                    <a href="{{ route('rapat.show', ['rapat' => $rapat->id]) }}" class="text-decoration-none text-black">
                        <div class="container bg-white my-3 rounded p-3 shadow">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>
                                    <h4>{{ $rapat->judul }}</h4>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                        {{ $rapat->tanggal() }} | {{ $rapat->waktuMulai() }} - {{ $rapat->waktuSelesai() }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                                        {{ $rapat->tempat }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-user-tie" style="color: #d9d9d9"></i>
                                        {{ $rapat->pemimpinRapat()->nama }}
                                    </div>
                                </div>
                                <span
                                    class="badge rounded-pill 
    {{ $rapat->attendanceOfLoggedInUser() == 'hadir' ? 'text-bg-success' : '' }}
    {{ $rapat->attendanceOfLoggedInUser() == 'izin' ? 'text-bg-warning' : '' }}
    {{ $rapat->attendanceOfLoggedInUser() == 'notset' ? 'text-bg-danger' : '' }} 
    py-2 px-4 fs-5 text-capitalize"
                                    style="width: 112px">
                                    {{ $rapat->attendanceOfLoggedInUser() }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-mendatang" role="tabpanel" aria-labelledby="nav-mendatang-tab"
                tabindex="0">
                @foreach ($upcomingRapats as $rapat)
                    <a href="{{ route('rapat.show', ['rapat' => $rapat->id]) }}" class="text-decoration-none text-black">
                        <div class="container bg-white my-3 rounded p-3 shadow">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>
                                    <h4>{{ $rapat->judul }}</h4>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                        {{ $rapat->tanggal() }} | {{ $rapat->waktuMulai() }} - {{ $rapat->waktuSelesai() }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                                        {{ $rapat->tempat }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-user-tie" style="color: #d9d9d9"></i>
                                        {{ $rapat->pemimpinRapat()->nama }}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="tab-pane fade" id="nav-selesai" role="tabpanel" aria-labelledby="nav-selesai-tab" tabindex="0">
                @foreach ($pastRapats as $rapat)
                    <a href="{{ route('rapat.show', ['rapat' => $rapat->id]) }}" class="text-decoration-none text-black">
                        <div class="container bg-white my-3 rounded p-3 shadow">
                            <div class="d-flex justify-content-between align-items-center px-3">
                                <div>
                                    <h4>{{ $rapat->judul }}</h4>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                        {{ $rapat->tanggal() }} | {{ $rapat->waktuMulai() }} -
                                        {{ $rapat->waktuSelesai() }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                                        {{ $rapat->tempat }}
                                    </div>
                                    <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                        <i class="fa-solid fa-user-tie" style="color: #d9d9d9"></i>
                                        {{ $rapat->pemimpinRapat()->nama }}
                                    </div>
                                </div>
                                <span
                                    class="badge rounded-pill 
    {{ $rapat->attendanceOfLoggedInUser() == 'hadir' ? 'text-bg-success' : '' }}
    {{ $rapat->attendanceOfLoggedInUser() == 'izin' ? 'text-bg-warning' : '' }}
    {{ $rapat->attendanceOfLoggedInUser() == 'notset' ? 'text-bg-danger' : '' }} 
    py-2 px-4 fs-5 text-capitalize"
                                    style="width: 112px">
                                    {{ $rapat->attendanceOfLoggedInUser() }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
