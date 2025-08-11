@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Perjalanan Dinas (SPPD)</h1>
    <p class="mt-2 text-sm text-gray-600">Kelola surat perintah perjalanan dinas</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<x-modern-table :title="'Data Perjalanan Dinas'" :searchable="true">
    <x-slot name="actions">
        @can('buat sppd')
        <a href="{{ route('sppd.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah SPPD
        </a>
        @endcan
    </x-slot>

    <x-slot name="head">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor SPPD</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
    </x-slot>

    @forelse($perjalananDinas as $index => $sppd)
    <tr class="hover:bg-gray-50 transition-colors duration-150">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $index + 1 }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ $sppd->nomor_sppd }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8">
                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            {{ substr($sppd->pegawai->nama ?? 'N/A', 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-sm font-medium text-gray-900">{{ $sppd->pegawai->nama ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">{{ $sppd->pegawai->jabatan->nama ?? '' }}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ $sppd->tujuan }}</div>
            <div class="text-sm text-gray-500">{{ $sppd->maksud_tujuan }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <div>{{ \Carbon\Carbon::parse($sppd->tanggal_berangkat)->format('d M Y') }}</div>
            <div class="text-xs text-gray-400">
                s/d {{ \Carbon\Carbon::parse($sppd->tanggal_kembali)->format('d M Y') }}
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @php
                $now = now();
                $berangkat = \Carbon\Carbon::parse($sppd->tanggal_berangkat);
                $kembali = \Carbon\Carbon::parse($sppd->tanggal_kembali);
            @endphp
            
            @if($now < $berangkat)
                <span class="badge badge-warning">Belum Berangkat</span>
            @elseif($now >= $berangkat && $now <= $kembali)
                <span class="badge badge-primary">Dalam Perjalanan</span>
            @else
                <span class="badge badge-success">Selesai</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center space-x-2">
                <a href="{{ route('sppd.show', $sppd->id) }}" 
                   class="text-primary-600 hover:text-primary-900 transition-colors duration-150"
                   title="Lihat Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
                
                @can('edit sppd')
                <a href="{{ route('sppd.edit', $sppd->id) }}" 
                   class="text-warning-600 hover:text-warning-900 transition-colors duration-150"
                   title="Edit SPPD">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                @endcan
                
                <a href="{{ route('sppd.print', $sppd->id) }}" 
                   class="text-success-600 hover:text-success-900 transition-colors duration-150"
                   title="Print SPPD" target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                </a>
                
                @can('hapus sppd')
                <button type="button" 
                        onclick="confirmDelete('{{ $sppd->id }}')"
                        class="text-danger-600 hover:text-danger-900 transition-colors duration-150"
                        title="Hapus SPPD">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada perjalanan dinas</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan SPPD pertama</p>
                @can('buat sppd')
                <a href="{{ route('sppd.create') }}" class="btn btn-primary">
                    Tambah SPPD
                </a>
                @endcan
            </div>
        </td>
    </tr>
    @endforelse

    @if(isset($perjalananDinas) && $perjalananDinas->hasPages())
    <x-slot name="pagination">
        {{ $perjalananDinas->links() }}
    </x-slot>
    @endif
</x-modern-table>

<!-- Delete Confirmation Modal -->
<x-modern-modal>
    <x-slot name="title">Konfirmasi Hapus</x-slot>
    <div id="delete-content">
        <p class="text-gray-600">Apakah Anda yakin ingin menghapus SPPD ini? Tindakan ini tidak dapat dibatalkan.</p>
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
function confirmDelete(id) {
    document.getElementById('delete-form').action = '/sppd/' + id;
    window.dispatchEvent(new CustomEvent('open-modal'));
}
</script>
@endsection
