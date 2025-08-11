@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-primary-600 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('surat-masuk.index') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2">Surat Masuk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 md:ml-2">{{ isset($surat) ? 'Edit' : 'Tambah' }}</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ isset($surat) ? 'Edit Surat Masuk' : 'Tambah Surat Masuk' }}</h1>
    <p class="mt-2 text-sm text-gray-600">{{ isset($surat) ? 'Perbarui data surat masuk' : 'Tambahkan surat masuk baru ke sistem' }}</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<x-modern-form 
    :title="isset($surat) ? 'Form Edit Surat Masuk' : 'Form Tambah Surat Masuk'"
    :subtitle="'Isi semua field yang diperlukan dengan benar'"
    action="{{ isset($surat) ? route('surat-masuk.update', $surat->id) : route('surat-masuk.store') }}"
    method="POST"
    enctype="multipart/form-data">
    
    @if(isset($surat))
        @method('PUT')
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nomor Surat -->
        <div class="form-group">
            <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor Surat <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nomor_surat" 
                   id="nomor_surat" 
                   value="{{ old('nomor_surat', $surat->nomor_surat ?? '') }}" 
                   placeholder="Masukkan nomor surat"
                   class="form-input" 
                   required>
            @error('nomor_surat')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Surat -->
        <div class="form-group">
            <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Surat <span class="text-red-500">*</span>
            </label>
            <input type="date" 
                   name="tanggal_surat" 
                   id="tanggal_surat" 
                   value="{{ old('tanggal_surat', isset($surat) ? $surat->tanggal_surat : '') }}" 
                   class="form-input" 
                   required>
            @error('tanggal_surat')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Asal Surat -->
        <div class="form-group">
            <label for="asal" class="block text-sm font-medium text-gray-700 mb-2">
                Asal Surat <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="asal" 
                   id="asal" 
                   value="{{ old('asal', $surat->asal ?? '') }}" 
                   placeholder="Masukkan asal surat"
                   class="form-input" 
                   required>
            @error('asal')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Diterima -->
        <div class="form-group">
            <label for="tanggal_diterima" class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Diterima <span class="text-red-500">*</span>
            </label>
            <input type="date" 
                   name="tanggal_diterima" 
                   id="tanggal_diterima" 
                   value="{{ old('tanggal_diterima', isset($surat) ? $surat->tanggal_diterima : date('Y-m-d')) }}" 
                   class="form-input" 
                   required>
            @error('tanggal_diterima')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Perihal -->
    <div class="form-group">
        <label for="perihal" class="block text-sm font-medium text-gray-700 mb-2">
            Perihal <span class="text-red-500">*</span>
        </label>
        <textarea name="perihal" 
                  id="perihal" 
                  rows="3" 
                  placeholder="Masukkan perihal surat"
                  class="form-textarea" 
                  required>{{ old('perihal', $surat->perihal ?? '') }}</textarea>
        @error('perihal')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Isi Ringkas -->
    <div class="form-group">
        <label for="isi_ringkas" class="block text-sm font-medium text-gray-700 mb-2">
            Isi Ringkas
        </label>
        <textarea name="isi_ringkas" 
                  id="isi_ringkas" 
                  rows="4" 
                  placeholder="Masukkan isi ringkas surat"
                  class="form-textarea">{{ old('isi_ringkas', $surat->isi_ringkas ?? '') }}</textarea>
        @error('isi_ringkas')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Status -->
        <div class="form-group">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                Status <span class="text-red-500">*</span>
            </label>
            <select name="status" id="status" class="form-select" required>
                <option value="">Pilih Status</option>
                <option value="pending" {{ old('status', $surat->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processed" {{ old('status', $surat->status ?? '') == 'processed' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ old('status', $surat->status ?? '') == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Prioritas -->
        <div class="form-group">
            <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-2">
                Prioritas
            </label>
            <select name="prioritas" id="prioritas" class="form-select">
                <option value="">Pilih Prioritas</option>
                <option value="rendah" {{ old('prioritas', $surat->prioritas ?? '') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                <option value="normal" {{ old('prioritas', $surat->prioritas ?? '') == 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="tinggi" {{ old('prioritas', $surat->prioritas ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="urgent" {{ old('prioritas', $surat->prioritas ?? '') == 'urgent' ? 'selected' : '' }}>Urgent</option>
            </select>
            @error('prioritas')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- File Lampiran -->
    <div class="form-group">
        <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
            File Lampiran
        </label>
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition-colors duration-150">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="lampiran" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                        <span>Upload file</span>
                        <input id="lampiran" name="lampiran" type="file" class="sr-only" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </label>
                    <p class="pl-1">atau drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG hingga 10MB</p>
            </div>
        </div>
        @if(isset($surat) && $surat->lampiran)
            <div class="mt-2 text-sm text-gray-600">
                File saat ini: <a href="{{ asset('storage/' . $surat->lampiran) }}" target="_blank" class="text-primary-600 hover:text-primary-500">{{ basename($surat->lampiran) }}</a>
            </div>
        @endif
        @error('lampiran')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <x-slot name="actions">
        <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Batal
        </a>
        <button type="submit" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ isset($surat) ? 'Update' : 'Simpan' }}
        </button>
    </x-slot>
</x-modern-form>

<script>
// File upload preview
document.getElementById('lampiran').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Show file preview or name
            console.log('File selected:', file.name);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
