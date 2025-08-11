@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Manajemen Rapat</h1>
    <p class="mt-2 text-sm text-gray-600">Kelola jadwal rapat dan kehadiran peserta</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<!-- Calendar View Toggle -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div class="flex space-x-1 bg-gray-100 rounded-lg p-1">
            <button onclick="toggleView('list')" 
                    id="list-btn"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-colors duration-150 bg-white text-gray-900 shadow-sm">
                List View
            </button>
            <button onclick="toggleView('calendar')" 
                    id="calendar-btn"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-colors duration-150 text-gray-500 hover:text-gray-900">
                Calendar View
            </button>
        </div>
        @can('buat rapat')
        <a href="{{ route('rapat.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Rapat
        </a>
        @endcan
    </div>
</div>

<!-- List View -->
<div id="list-view">
    <x-modern-table :title="'Data Rapat'" :searchable="true">
        <x-slot name="head">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Rapat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemimpin Rapat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </x-slot>

        @forelse($rapats as $index => $rapat)
        <tr class="hover:bg-gray-50 transition-colors duration-150">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $index + 1 }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $rapat->warna_label ?? '#6B7280' }}"></div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $rapat->judul }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($rapat->perihal, 30) }}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <div>{{ \Carbon\Carbon::parse($rapat->waktu_mulai)->format('d M Y') }}</div>
                <div class="text-xs text-gray-400">
                    {{ \Carbon\Carbon::parse($rapat->waktu_mulai)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($rapat->waktu_selesai)->format('H:i') }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ $rapat->tempat }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $rapat->pemimpinRapat->nama ?? 'Tidak diketahui' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @php
                    $now = now();
                    $start = \Carbon\Carbon::parse($rapat->waktu_mulai);
                    $end = \Carbon\Carbon::parse($rapat->waktu_selesai);
                @endphp
                
                @if($now < $start)
                    <span class="badge badge-warning">Akan Datang</span>
                @elseif($now >= $start && $now <= $end)
                    <span class="badge badge-success">Berlangsung</span>
                @else
                    <span class="badge badge-primary">Selesai</span>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('rapat.show', $rapat->id) }}" 
                       class="text-primary-600 hover:text-primary-900 transition-colors duration-150"
                       title="Lihat Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    
                    @can('edit rapat')
                    <a href="{{ route('rapat.edit', $rapat->id) }}" 
                       class="text-warning-600 hover:text-warning-900 transition-colors duration-150"
                       title="Edit Rapat">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    @endcan
                    
                    @can('hapus rapat')
                    <button type="button" 
                            onclick="confirmDelete('{{ $rapat->id }}')"
                            class="text-danger-600 hover:text-danger-900 transition-colors duration-150"
                            title="Hapus Rapat">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    @endcan
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8a2 2 0 002-2V7a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada rapat terjadwal</h3>
                    <p class="text-gray-500 mb-4">Mulai dengan menambahkan rapat pertama</p>
                    @can('buat rapat')
                    <a href="{{ route('rapat.create') }}" class="btn btn-primary">
                        Tambah Rapat
                    </a>
                    @endcan
                </div>
            </td>
        </tr>
        @endforelse

        @if(isset($rapats) && $rapats->hasPages())
        <x-slot name="pagination">
            {{ $rapats->links() }}
        </x-slot>
        @endif
    </x-modern-table>
</div>

<!-- Calendar View -->
<div id="calendar-view" class="hidden">
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">Kalender Rapat</h3>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<x-modern-modal>
    <x-slot name="title">Konfirmasi Hapus</x-slot>
    <div id="delete-content">
        <p class="text-gray-600">Apakah Anda yakin ingin menghapus rapat ini? Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <x-slot name="footer">
        <button type="button" @click="open = false" class="btn btn-secondary mr-2">Batal</button>
        <form id="delete-form" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </x-slot>
</x-modern-modal>

<script>
function toggleView(view) {
    const listView = document.getElementById('list-view');
    const calendarView = document.getElementById('calendar-view');
    const listBtn = document.getElementById('list-btn');
    const calendarBtn = document.getElementById('calendar-btn');
    
    if (view === 'list') {
        listView.classList.remove('hidden');
        calendarView.classList.add('hidden');
        listBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
        listBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
        calendarBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
        calendarBtn.classList.add('text-gray-500', 'hover:text-gray-900');
    } else {
        listView.classList.add('hidden');
        calendarView.classList.remove('hidden');
        calendarBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
        calendarBtn.classList.remove('text-gray-500', 'hover:text-gray-900');
        listBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
        listBtn.classList.add('text-gray-500', 'hover:text-gray-900');
        
        // Initialize calendar if needed
        if (typeof initCalendar === 'function') {
            initCalendar();
        }
    }
}

function confirmDelete(id) {
    document.getElementById('delete-form').action = '/rapat/' + id;
    window.dispatchEvent(new CustomEvent('open-modal'));
}
</script>
@endsection
