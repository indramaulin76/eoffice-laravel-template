@extends('layouts.dashboard')

@section('header')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Arsip Surat Keluar</h1>
    <p class="mt-2 text-sm text-gray-600">Kelola arsip surat keluar dengan sistem digital</p>
</div>
@endsection

@section('main-content')
<x-modern-alert />

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Tab Navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 px-6 pt-4" aria-label="Tabs">
            <button id="sudah-diarsip-tab" 
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm active"
                    onclick="switchTab('sudah-diarsip')">
                Sudah Diarsip
            </button>
            <button id="belum-diarsip-tab" 
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                    onclick="switchTab('belum-diarsip')">
                Belum Diarsip
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="p-6">
        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" 
                       placeholder="Cari surat..." 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 text-sm"
                       id="search-input">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="arsip-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="table-body">
                    <!-- Data will be loaded here via JavaScript -->
                </tbody>
            </table>

            <!-- Empty state -->
            <div id="empty-state" class="hidden text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h8a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada surat</h3>
                <p class="text-gray-500">Belum ada surat dalam kategori ini</p>
            </div>
        </div>
    </div>
</div>

<style>
.tab-button.active {
    border-color: #3B82F6;
    color: #3B82F6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const suratKeluar = @json($suratKeluar);
    const baseRoute = "{{ route('surat-keluar.arsip.show', ['surat' => '__ID__']) }}";
    let currentTab = 'sudah-diarsip';

    function switchTab(tab) {
        currentTab = tab;
        
        // Update tab appearance
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(tab + '-tab').classList.add('active');
        
        // Load data
        loadData(tab);
    }

    function loadData(status) {
        const tableBody = document.getElementById('table-body');
        const emptyState = document.getElementById('empty-state');
        
        // Filter data based on status
        let filteredData = suratKeluar.filter(function(surat) {
            if (status === 'sudah-diarsip') {
                return surat.file_arsip !== null;
            } else {
                return surat.file_arsip == null;
            }
        });

        // Clear table body
        tableBody.innerHTML = '';

        if (filteredData.length === 0) {
            emptyState.classList.remove('hidden');
            document.getElementById('arsip-table').classList.add('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        document.getElementById('arsip-table').classList.remove('hidden');

        // Populate table
        filteredData.forEach(function(surat, index) {
            const route = baseRoute.replace('__ID__', surat.id);
            const date = new Date(surat.tanggal_dikirim);
            const formattedDate = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            let statusBadge = '';
            if (surat.status === 'Disetujui') {
                statusBadge = '<span class="badge badge-success">Disetujui</span>';
            } else if (surat.status === 'Dalam Proses') {
                statusBadge = '<span class="badge badge-warning">Dalam Proses</span>';
            } else if (surat.status === 'Ditolak') {
                statusBadge = '<span class="badge badge-danger">Ditolak</span>';
            } else {
                statusBadge = `<span class="badge badge-primary">${surat.status}</span>`;
            }

            const row = `
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${surat.nomor_surat}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs truncate">${surat.perihal}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${surat.tujuan}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${statusBadge}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="${route}" 
                           class="text-primary-600 hover:text-primary-900 transition-colors duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    // Search functionality
    document.getElementById('search-input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Make switchTab global
    window.switchTab = switchTab;

    // Initial load
    loadData('sudah-diarsip');
});
</script>
@endsection
