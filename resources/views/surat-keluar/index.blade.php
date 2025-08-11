@extends('layouts.main')

@section('container')
    <div class="ms-3">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="border-bottom border-black">
        <h1 class="ms-3">Surat Keluar</h1>
    </div>
    <br>
    @can('buat surat')
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-outline-primary fs-5 ms-3 mb-3"><i
                class="fa-solid fa-plus"></i> Buat Baru</a>
    @endcan

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
    <table class="" id="suratKeluarTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Hal</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Tanggal Diarsipkan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $('document').ready(function() {

            var table = $('#suratKeluarTable').DataTable();
            var suratKeluar = @json($suratKeluar);

            console.log(suratKeluar);
            var suratKeluarBaseRoute = "{{ route('surat-keluar.show', ['surat' => '__ID__']) }}";
            var initialStatus = 'dalamProses';
            loadData(initialStatus);


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
                var filteredData = suratKeluar.filter(function(surat) {
                    if (status === 'dalamProses') {
                        return surat.status === 'Dalam Proses';
                    } else {
                        return surat.status === 'Disetujui' || surat.status === 'Ditolak';
                    }
                });
                console.log(filteredData);

                // Kosongkan tbody
                $('#suratKeluarTable tbody').empty();

                // Populate tbody dengan data yang sudah difilter
                filteredData.forEach(function(surat, index) {
                    var suratKeluarRoute = suratKeluarBaseRoute.replace('__ID__', surat.id);
                    $('#suratKeluarTable tbody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${surat.perihal}</td>
                            <td>${surat.asal}</td>
                            <td>${surat.tujuan}</td>
                            <td>${formatDate(new Date(surat.tanggal_dikirim))}</td>
                            <td>${surat.status}</td>
                            <td><a href="${suratKeluarRoute}">Lihat</a></td>
                        </tr>
                    `);
                });

                // Re-initialize DataTable
                table = $('#suratKeluarTable').DataTable();
            }

            // Fungsi untuk format tanggal ke format "Kamis, 3 Oktober 2024"
            function formatDate(date) {
                const options = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };

                return new Intl.DateTimeFormat('id-ID', options).format(date);
            }
        })
    </script>
@endsection
