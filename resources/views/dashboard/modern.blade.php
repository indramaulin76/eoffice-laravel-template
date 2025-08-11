@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="mt-2 text-sm text-gray-600">Selamat datang di E-Office, {{ Auth::user()->nama }}</p>
</div>
@endsection

@section('main-content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Surat Masuk -->
    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Surat Masuk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\SuratMasuk::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Surat Keluar -->
    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-success-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Surat Keluar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\SuratKeluar::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Rapat -->
    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-warning-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Rapat</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Rapat::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Perjalanan Dinas -->
    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-danger-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Perjalanan Dinas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\PerjalananDinas::count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Documents -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Dokumen Terbaru</h3>
        </div>
        <div class="card-body p-0">
            <div class="divide-y divide-gray-200">
                @forelse(\App\Models\SuratMasuk::latest()->take(5)->get() as $surat)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $surat->perihal }}</p>
                            <p class="text-sm text-gray-500">{{ $surat->asal }}</p>
                            <p class="text-xs text-gray-400">{{ $surat->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge badge-primary">Surat Masuk</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada dokumen</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Upcoming Meetings -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Rapat Mendatang</h3>
        </div>
        <div class="card-body p-0">
            <div class="divide-y divide-gray-200">
                @forelse(\App\Models\Rapat::where('waktu_mulai', '>', now())->orderBy('waktu_mulai')->take(5)->get() as $rapat)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: {{ $rapat->warna_label }};">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8a2 2 0 002-2V7a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $rapat->judul }}</p>
                            <p class="text-sm text-gray-500">{{ $rapat->tempat }}</p>
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($rapat->waktu_mulai)->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge badge-warning">Upcoming</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8a2 2 0 002-2V7a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada rapat terjadwal</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @can('buat surat')
            <a href="{{ route('surat-masuk.create') }}" class="group flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors duration-150">
                <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center group-hover:bg-primary-700 transition-colors duration-150">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Buat Surat</span>
            </a>
            @endcan

            @can('buat rapat')
            <a href="{{ route('rapat.create') }}" class="group flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-success-50 transition-colors duration-150">
                <div class="w-10 h-10 bg-success-600 rounded-lg flex items-center justify-center group-hover:bg-success-700 transition-colors duration-150">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Jadwal Rapat</span>
            </a>
            @endcan

            @can('buat sppd')
            <a href="{{ route('sppd.create') }}" class="group flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-warning-50 transition-colors duration-150">
                <div class="w-10 h-10 bg-warning-600 rounded-lg flex items-center justify-center group-hover:bg-warning-700 transition-colors duration-150">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Buat SPPD</span>
            </a>
            @endcan

            <a href="{{ route('tugas.create') }}" class="group flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-danger-50 transition-colors duration-150">
                <div class="w-10 h-10 bg-danger-600 rounded-lg flex items-center justify-center group-hover:bg-danger-700 transition-colors duration-150">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Buat Tugas</span>
            </a>
        </div>
    </div>
</div>
@endsection
