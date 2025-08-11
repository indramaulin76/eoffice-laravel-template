@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Manajemen Tugas</h1>
    <p class="mt-2 text-sm text-gray-600">Kelola tugas dan luaran yang diberikan kepada pegawai</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-warning-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tugas Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tugasPending ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dalam Progress</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tugasProgress ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-success-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tugasSelesai ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-danger-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Terlambat</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tugasTerlambat ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modern-table :title="'Data Tugas'" :searchable="true">
    <x-slot name="actions">
        @can('buat tugas')
        <a href="{{ route('tugas.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Tugas
        </a>
        @endcan
    </x-slot>

    <x-slot name="head">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Tugas</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ditugaskan Ke</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
    </x-slot>

    @forelse($tugas as $index => $task)
    <tr class="hover:bg-gray-50 transition-colors duration-150">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $index + 1 }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ $task->judul }}</div>
            <div class="text-sm text-gray-500">{{ Str::limit($task->deskripsi, 50) }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8">
                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            {{ substr($task->pegawai->nama ?? 'N/A', 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-sm font-medium text-gray-900">{{ $task->pegawai->nama ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">{{ $task->pegawai->jabatan->nama ?? '' }}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
            <div class="text-xs {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'text-red-500' : 'text-gray-400' }}">
                {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if($task->prioritas == 'urgent')
                <span class="badge badge-danger">Urgent</span>
            @elseif($task->prioritas == 'tinggi')
                <span class="badge badge-warning">Tinggi</span>
            @elseif($task->prioritas == 'normal')
                <span class="badge badge-primary">Normal</span>
            @else
                <span class="badge badge-success">Rendah</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if($task->status == 'pending')
                <span class="badge badge-warning">Pending</span>
            @elseif($task->status == 'progress')
                <span class="badge badge-primary">Progress</span>
            @elseif($task->status == 'completed')
                <span class="badge badge-success">Selesai</span>
            @else
                <span class="badge badge-danger">Terlambat</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                    <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $task->progress ?? 0 }}%"></div>
                </div>
                <span class="text-sm text-gray-600">{{ $task->progress ?? 0 }}%</span>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center space-x-2">
                <a href="{{ route('tugas.show', $task->id) }}" 
                   class="text-primary-600 hover:text-primary-900 transition-colors duration-150"
                   title="Lihat Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
                
                @can('edit tugas')
                <a href="{{ route('tugas.edit', $task->id) }}" 
                   class="text-warning-600 hover:text-warning-900 transition-colors duration-150"
                   title="Edit Tugas">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                @endcan
                
                @can('hapus tugas')
                <button type="button" 
                        onclick="confirmDelete('{{ $task->id }}')"
                        class="text-danger-600 hover:text-danger-900 transition-colors duration-150"
                        title="Hapus Tugas">
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
        <td colspan="8" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tugas</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan tugas pertama</p>
                @can('buat tugas')
                <a href="{{ route('tugas.create') }}" class="btn btn-primary">
                    Tambah Tugas
                </a>
                @endcan
            </div>
        </td>
    </tr>
    @endforelse

    @if(isset($tugas) && $tugas->hasPages())
    <x-slot name="pagination">
        {{ $tugas->links() }}
    </x-slot>
    @endif
</x-modern-table>

<!-- Delete Confirmation Modal -->
<x-modern-modal>
    <x-slot name="title">Konfirmasi Hapus</x-slot>
    <div id="delete-content">
        <p class="text-gray-600">Apakah Anda yakin ingin menghapus tugas ini? Tindakan ini tidak dapat dibatalkan.</p>
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
    document.getElementById('delete-form').action = '/tugas/' + id;
    window.dispatchEvent(new CustomEvent('open-modal'));
}
</script>
@endsection
