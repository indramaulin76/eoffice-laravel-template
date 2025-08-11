@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Surat Keluar</h1>
    <p class="mt-2 text-sm text-gray-600">Kelola surat keluar dengan sistem digital</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<x-modern-table :title="'Data Surat Keluar'" :searchable="true">
    <x-slot name="actions">
        @auth
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Surat Keluar
        </a>
        @endauth
    </x-slot>

    <x-slot name="head">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Surat</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
    </x-slot>

    @forelse($suratKeluars as $index => $surat)
    <tr class="hover:bg-gray-50 transition-colors duration-150">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $index + 1 }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ $surat->nomor_surat }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ $surat->tujuan }}</div>
        </td>
        <td class="px-6 py-4">
            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $surat->perihal }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if($surat->status == 'draft')
                <span class="badge badge-warning">Draft</span>
            @elseif($surat->status == 'sent')
                <span class="badge badge-success">Terkirim</span>
            @elseif($surat->status == 'approved')
                <span class="badge badge-primary">Disetujui</span>
            @else
                <span class="badge badge-primary">{{ ucfirst($surat->status) }}</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center space-x-2">
                <a href="{{ route('surat-keluar.show', $surat->id) }}" 
                   class="text-primary-600 hover:text-primary-900 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
                
                @auth
                <a href="{{ route('surat-keluar.edit', $surat->id) }}" 
                   class="text-warning-600 hover:text-warning-900 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                @endauth
                
                @auth
                <button type="button" 
                        onclick="confirmDelete('{{ $surat->id }}')"
                        class="text-danger-600 hover:text-danger-900 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                @endauth
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada surat keluar</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan surat keluar pertama</p>
                @auth
                <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">
                    Tambah Surat Keluar
                </a>
                @endauth
            </div>
        </td>
    </tr>
    @endforelse

    @if(isset($suratKeluars) && $suratKeluars->hasPages())
    <x-slot name="pagination">
        {{ $suratKeluars->links() }}
    </x-slot>
    @endif
</x-modern-table>

<!-- Delete Confirmation Modal -->
<x-modern-modal>
    <x-slot name="title">Konfirmasi Hapus</x-slot>
    <div id="delete-content">
        <p class="text-gray-600">Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat dibatalkan.</p>
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
    document.getElementById('delete-form').action = '/surat-keluar/' + id;
    window.dispatchEvent(new CustomEvent('open-modal'));
}
</script>
@endsection
