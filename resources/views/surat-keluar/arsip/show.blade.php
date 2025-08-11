@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Arsip Surat Keluar</h1>
    <p class="mt-2 text-sm text-gray-600">Detail arsip surat keluar</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('surat-keluar.arsip.index') }}" 
           class="inline-flex items-center text-primary-600 hover:text-primary-900 transition-colors duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Arsip
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">{{ $surat->perihal }}</h2>
            <div class="mt-2">
                @if($surat->status === 'Disetujui')
                    <span class="badge badge-success">Disetujui</span>
                @elseif($surat->status === 'Dalam Proses')
                    <span class="badge badge-warning">Dalam Proses</span>
                @elseif($surat->status === 'Ditolak')
                    <span class="badge badge-danger">Ditolak</span>
                @else
                    <span class="badge badge-primary">{{ $surat->status }}</span>
                @endif
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Nomor Surat</h3>
                        <p class="text-gray-900">{{ $surat->nomor_surat }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Penulis/Pengonsep</h3>
                        <p class="text-gray-900">{{ $surat->penulis->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $surat->penulis->jabatan->nama }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Asal Surat</h3>
                        <p class="text-gray-900">{{ $surat->asal }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Tujuan Surat</h3>
                        <p class="text-gray-900">{{ $surat->tujuan }}</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Alamat Tujuan</h3>
                        <p class="text-gray-900">{{ $surat->alamat_surat }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Surat</h3>
                        <p class="text-gray-900">{{ $surat->tanggalDibuat() }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Penandatangan</h3>
                        <p class="text-gray-900">{{ $surat->penandatangan->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $surat->penandatangan->jabatan->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- Files Section -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Dokumen Surat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Original File -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">File Surat Asli</h4>
                        <a href="{{ Storage::url($surat->file_surat) }}" 
                           target="_blank"
                           class="btn btn-primary w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat File Surat
                        </a>
                    </div>

                    <!-- Archive File -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">File Arsip</h4>
                        @if($surat->file_arsip)
                            <a href="{{ Storage::url('arsip-surat-keluar/' . $surat->file_arsip) }}" 
                               target="_blank"
                               class="btn btn-success w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Lihat File Arsip
                            </a>
                        @else
                            <div class="text-center py-4">
                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">Arsip tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Upload Archive Section -->
                @auth
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Kelola Arsip Surat</h3>
                    
                    <form action="{{ route('surat-keluar.arsip.update', ['surat' => $surat]) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="archive-form">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-4">
                            <div>
                                <label for="file_arsip" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload File Arsip
                                </label>
                                <p class="text-sm text-gray-500 mb-3">
                                    File surat yang sudah ditandatangani dan diberi cap (PDF, maksimal 5MB)
                                </p>
                                <input type="file" 
                                       name="file_arsip" 
                                       id="file_arsip"
                                       accept=".pdf"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 border border-gray-300 rounded-md"
                                       required>
                                @error('file_arsip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex gap-3">
                                <button type="button" 
                                        onclick="showUploadModal()"
                                        class="btn btn-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    {{ $surat->file_arsip ? 'Perbarui Arsip' : 'Buat Arsip' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Upload Confirmation Modal -->
<x-modern-modal id="upload-modal">
    <x-slot name="title">{{ $surat->file_arsip ? 'Perbarui' : 'Buat' }} Arsip Surat</x-slot>
    <div>
        <p class="text-gray-600">
            @if($surat->file_arsip)
                Anda yakin ingin memperbarui arsip surat? Arsip surat yang sudah ada akan terhapus dan diganti dengan file baru.
            @else
                Anda yakin ingin membuat arsip surat ini?
            @endif
        </p>
    </div>
    <x-slot name="footer">
        <button type="button" onclick="closeModal('upload-modal')" class="btn btn-secondary mr-2">Batal</button>
        <button type="submit" form="archive-form" class="btn btn-primary">
            {{ $surat->file_arsip ? 'Perbarui' : 'Buat' }} Arsip
        </button>
    </x-slot>
</x-modern-modal>

<script>
function showUploadModal() {
    const fileInput = document.getElementById('file_arsip');
    if (!fileInput.files[0]) {
        alert('Silakan pilih file terlebih dahulu');
        return;
    }
    window.dispatchEvent(new CustomEvent('open-modal', { detail: { modalId: 'upload-modal' } }));
}

function closeModal(modalId) {
    window.dispatchEvent(new CustomEvent('close-modal', { detail: { modalId: modalId } }));
}
</script>
@endsection
