@extends('layouts.master')

@section('container')
    <div style="width: 85%;" class="mx-4 my-2">
        <div class="container bg-white my-3 rounded p-3 pb-0 shadow">
            <div class="ms-3">
                {{ Breadcrumbs::render() }}
            </div>
            <div class="border-bottom border-black d-flex justify-content-between">
                <h1 class="ms-3">Riwayat Tugas</h1>
                {{-- button success 'Unggah Tugas Baru' --}}
                <a href="{{ route('tugas.create') }}" class="btn btn-success ms-3 mb-3">+ Unggah Tugas Baru</a>
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
            Silakan klik untuk melihat detail tugas
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @foreach ($daftarTugas as $tugas)
            <a href="{{ route('tugas.show', ['tugas' => $tugas->id]) }}" class="text-decoration-none text-black">
                <div class="container bg-white my-3 rounded p-3 shadow">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <div>
                            <h4>{{ $tugas->judul }}</h4>
                            <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                {{ $tugas->keterangan }}
                            </div>
                            <div class="d-flex align-items-center gap-3" style="color: #747474;">
                                <i class="fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                                {{ $tugas->waktu_pengumpulan }}
                            </div>
                        </div>
                        <span
                            class="badge rounded-pill 
    {{ $tugas->status == 'disetujui' ? 'text-bg-success' : '' }}
    {{ $tugas->status == 'sedang diperiksa' ? 'text-bg-warning' : '' }}
    {{ $tugas->status == 'ditolak' ? 'text-bg-danger' : '' }} 
    py-2 text-capitalize"
                            style="width: 112px">
                            {{ $tugas->status }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
