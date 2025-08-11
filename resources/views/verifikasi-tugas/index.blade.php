@extends('layouts.main')

@section('container')
    <div class="ms-3">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="border-bottom border-black">
        <h1 class="ms-3">Verifikasi Luaran Tugas</h1>
    </div>
    <br>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <ul class="nav nav-tabs pt-0">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#" id="dalamProses">Menunggu Verifikasi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="selesai">Selesai Diverifikasi</a>
        </li>

    </ul>
    <table class="" id="luaranTugasTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Pegawai</th>
                <th>Uraian Tugas</th>
                <th>Judul</th>
                <th>Keterangan</th>
                <th>Waktu Pengumpulan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- tabel akan diisi dengan script js di bawah --}}
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Data yang sudah dipassing dari Laravel ke Blade
            var luaranTugas = @json($luaranTugas);
            var luaranTugasBaseRoute = "{{ route('tugas.verifikasi.show', ['tugas' => '__ID__']) }}";
            var initialStatus = 'dalamProses';

            // Inisialisasi DataTable
            var table = $('#luaranTugasTable').DataTable();
            loadData(initialStatus);

            // Load initial data (menunggu)
            // loadData('menunggu');

            // Event handler untuk tab klik
            $('.nav-link').on('click', function(e) {
                e.preventDefault();
                console.log('Tab clicked');
                $('.nav-link').removeClass('active');
                $(this).addClass('active');

                var status = e.target.id; // Ambil status dari id tab
                console.log(status);
                loadData(status);
            });

            function loadData(status) {
                // Destroy existing DataTable sebelum update data
                table.destroy();

                // Filter data berdasarkan status yang dipilih
                var filteredData = luaranTugas.filter(function(tugas) {
                    if (status === 'dalamProses') {
                        return tugas.status === 'sedang diperiksa';
                    } else {
                        return tugas.status === 'disetujui' || tugas
                            .status === 'ditolak';
                    }
                });

                // Kosongkan tbody
                $('#luaranTugasTable tbody').empty();

                // Populate tbody dengan data yang sudah difilter
                filteredData.forEach(function(tugas, index) {
                    var luaranTugasRoute = luaranTugasBaseRoute.replace('__ID__', tugas.id);
                    $('#luaranTugasTable tbody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${tugas.pegawai.nama}</td>
                            <td>${tugas.uraian_tugas}</td>
                            <td>${tugas.judul}</td>
                            <td>${tugas.keterangan}</td>
                            <td>${formatDate(new Date(tugas.created_at))}</td>
                            <td class="text-capitalize">${tugas.status}</td>
                            <td><a href="${luaranTugasRoute}">Lihat</a></td>
                        </tr>
                    `);
                });

                // Re-initialize DataTable
                table = $('#luaranTugasTable').DataTable();
            }

            // Fungsi untuk format tanggal ke format "Kamis, 3 Oktober 2024"
            function formatDate(date) {
                const options = {
                    weekday : 'long',
                    day : 'numeric',
                    month : 'long',
                    year : 'numeric'
                };

                return new Intl.DateTimeFormat('id-ID', options).format(date);
            }
        });
    </script>
@endsection
