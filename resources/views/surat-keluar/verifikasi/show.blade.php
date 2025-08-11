@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Verifikasi Surat Keluar</h1>
    <p class="mt-2 text-sm text-gray-600">Detail surat untuk verifikasi</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('surat-keluar.verifikasi.index') }}" 
           class="inline-flex items-center text-primary-600 hover:text-primary-900 transition-colors duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Verifikasi
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">{{ $surat->perihal }}</h2>
            <div class="mt-2">
                @if($surat->status == 'Dalam Proses')
                    <span class="badge badge-warning">Menunggu Verifikasi</span>
                @elseif($surat->status == 'Disetujui')
                    <span class="badge badge-success">Disetujui</span>
                @elseif($surat->status == 'Ditolak')
                    <span class="badge badge-danger">Ditolak</span>
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

            <!-- File and Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen Surat</h3>
                
                <div class="flex flex-wrap gap-4 items-center">
                    <a href="{{ Storage::url($surat->file_surat) }}" 
                       target="_blank"
                       class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat File Surat
                    </a>

                    @if($surat->status == 'Dalam Proses')
                        <button type="button" 
                                class="btn btn-success"
                                onclick="showApproveModal()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Setujui Surat
                        </button>

                        <button type="button" 
                                class="btn btn-danger"
                                onclick="showRejectModal()">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak Surat
                        </button>
                    @endif
                </div>

                @if($surat->status == 'Ditolak')
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-md">
                        <h4 class="text-sm font-medium text-red-800 mb-2">Alasan Penolakan:</h4>
                        <p class="text-red-700">{{ $surat->alasanPenolakan() }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<x-modern-modal id="approve-modal">
    <x-slot name="title">Setujui Surat</x-slot>
    <div>
        <p class="text-gray-600">Anda yakin ingin menyetujui surat ini? Surat yang sudah disetujui tidak dapat diubah lagi.</p>
    </div>
    <x-slot name="footer">
        <button type="button" onclick="closeModal('approve-modal')" class="btn btn-secondary mr-2">Batal</button>
        <form id="approve-form" method="POST" action="{{ route('surat-keluar.verifikasi.terima', ['surat' => $surat->nomor_surat]) }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">Setujui</button>
        </form>
    </x-slot>
</x-modern-modal>

<!-- Reject Modal -->
<x-modern-modal id="reject-modal">
    <x-slot name="title">Tolak Surat</x-slot>
    <form id="reject-form" method="POST" action="{{ route('surat-keluar.verifikasi.tolak', ['surat' => $surat->nomor_surat]) }}">
        @csrf
        <div class="mb-4">
            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
            <textarea name="catatan" 
                      id="catatan" 
                      rows="4" 
                      required
                      class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                      placeholder="Mohon jelaskan alasan penolakan surat"></textarea>
            @error('catatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" onclick="closeModal('reject-modal')" class="btn btn-secondary mr-2">Batal</button>
        <button type="submit" form="reject-form" class="btn btn-danger">Tolak Surat</button>
    </x-slot>
</x-modern-modal>

<script>
function showApproveModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: { modalId: 'approve-modal' } }));
}

function showRejectModal() {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: { modalId: 'reject-modal' } }));
}

function closeModal(modalId) {
    window.dispatchEvent(new CustomEvent('close-modal', { detail: { modalId: modalId } }));
}
</script>
@endsection
