<!-- Logo -->
<div class="flex items-center flex-shrink-0 px-4">
    <img class="h-8 w-auto" src="{{ asset('assets/undip-logo-cropped.svg') }}" alt="E-Office">
    <span class="ml-2 text-xl font-bold text-gray-900">E-Office</span>
</div>

<!-- Navigation -->
<div class="mt-5 flex-grow flex flex-col">
    <nav class="flex-1 px-2 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4" />
            </svg>
            Dashboard
        </a>

        <!-- Surat Section -->
        <div x-data="{ open: {{ request()->is('surat*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" 
                    class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Manajemen Surat
                <svg class="ml-auto h-4 w-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <div x-show="open" class="space-y-1 pl-6">
                <a href="{{ route('surat-masuk.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('surat-masuk.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('surat-masuk.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Surat Masuk
                </a>
                
                <a href="{{ route('surat-keluar.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('surat-keluar.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('surat-keluar.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Surat Keluar
                </a>
                
                @can('revisi')
                <a href="{{ route('surat-keluar.verifikasi.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('surat-keluar.verifikasi.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('surat-keluar.verifikasi.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Verifikasi Surat
                </a>
                @endcan
                
                @can('lihat surat')
                <a href="{{ route('surat-keluar.arsip.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('surat-keluar.arsip.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('surat-keluar.arsip.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Arsip Surat
                </a>
                @endcan
            </div>
        </div>

        <!-- Rapat -->
        <a href="{{ route('rapat.index') }}" 
           class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('rapat.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('rapat.*') ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Rapat
        </a>

        <!-- Perjalanan Dinas -->
        <div x-data="{ open: {{ request()->is('perjalanan-dinas*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" 
                    class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Perjalanan Dinas
                <svg class="ml-auto h-4 w-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <div x-show="open" class="space-y-1 pl-6">
                <a href="{{ route('sppd.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('sppd.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('sppd.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    SPPD
                </a>
                
                <a href="{{ route('laporan-dinas.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('laporan-dinas.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('laporan-dinas.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Laporan Dinas
                </a>
            </div>
        </div>

        <!-- Tugas -->
        <div x-data="{ open: {{ request()->is('tugas*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" 
                    class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Manajemen Tugas
                <svg class="ml-auto h-4 w-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <div x-show="open" class="space-y-1 pl-6">
                <a href="{{ route('tugas.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('tugas.index') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('tugas.index') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Daftar Tugas
                </a>
                
                @can('revisi')
                <a href="{{ route('tugas.verifikasi.index') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('tugas.verifikasi.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="mr-3 h-2 w-2 rounded-full {{ request()->routeIs('tugas.verifikasi.*') ? 'bg-primary-500' : 'bg-gray-300' }}"></span>
                    Verifikasi Tugas
                </a>
                @endcan
            </div>
        </div>
    </nav>
</div>

<!-- User info at bottom -->
<div class="flex-shrink-0 flex border-t border-gray-200 p-4">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                <span class="text-sm font-medium text-white">{{ substr(Auth::user()->nama, 0, 1) }}</span>
            </div>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->nama }}</p>
            <p class="text-xs text-gray-500">{{ Auth::user()->jabatan->nama ?? 'Staff' }}</p>
        </div>
    </div>
</div>
