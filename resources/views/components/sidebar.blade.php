<nav class="d-flex flex-column justify-content-between min-vh-100 h-100 shadow"
    style="width: 20%; position: sticky; top: 0;">
    {{-- top part start --}}
    <div>
        <div class="my-1 mx-1">
            <a href="{{ route('dashboard') }}" class="w-100 text-decoration-none">
                <div class="w-100 h-100 sidebar-button ps-3 py-3 d-flex align-items-center gap-2"
                    style="{{ Route::is('dashboard') ? 'background-color: #144272; color: white;' : 'background-color: white; color: black' }}">
                    <i style="width: 20px" class="fa-solid fa-house me-1"></i>
                    Dashboard
                </div>
            </a>
            {{-- accordion start --}}
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item border-top">
                    <h2 class="accordion-header">
                        <button
                            class="accordion-button {{ Route::is('rapat.index') | Route::is('rapat.create') | Route::is('rapat.presensi') ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                            aria-expanded="false" aria-controls="flush-collapseOne">
                            <i style="width: 20px" class="fa-solid fa-user-pen me-2"></i>
                            Rapat
                        </button>
                    </h2>
                    <a href="{{ route('rapat.index') }}" class="text-decoration-none text-black">
                        <div id="flush-collapseOne"
                            class="accordion-collapse collapse {{ Route::is('rapat.index') | Route::is('rapat.create') | Route::is('rapat.edit') ? 'show' : '' }}"
                            data-bs-parent="#accordionFlushExample" style="background-color: #BBD5EF">
                            <div class="accordion-body" style="color: #144272">
                                Agenda Rapat
                            </div>
                        </div>
                    </a>
                    @can('buat rapat')
                        <a href="{{ route('rapat.create') }}" class="text-decoration-none text-black">
                            <div id="flush-collapseOne"
                                class="accordion-collapse collapse {{ Route::is('rapat.index') | Route::is('rapat.create') | Route::is('rapat.edit') ? 'show' : '' }}"
                                data-bs-parent="#accordionFlushExample" style="background-color: #EEEFF0">
                                <div class="accordion-body" style="color: #144272">
                                    Buat Rapat
                                </div>
                            </div>
                        </a>
                    @endcan
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            <i style="width: 20px" class="fa-solid fa-bookmark me-2"></i>
                            Perjalanan Dinas
                        </button>
                    </h2>
                    <a href="{{ route('sppd.index') }}" class="text-decoration-none text-black">
                        <div id="flush-collapseTwo" class="accordion-collapse collapse border-bottom border-black"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                SPPD
                            </div>
                        </div>
                    </a>
                    @can('revisi')
                        <a href="{{ route('laporan-dinas.index') }}" class="text-decoration-none text-black">
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Verifikasi Laporan
                                </div>
                            </div>
                        </a>
                    @endcan
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            <i style="width: 20px" class="fa-solid   fa-circle-question me-2"></i>
                            Bukti Tugas
                        </button>
                    </h2>
                    <a href="{{ route('tugas.index') }}" class="text-decoration-none text-black">
                        <div id="flush-collapseThree" class="accordion-collapse collapse border-bottom border-black"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Riwayat
                            </div>
                        </div>
                    </a>
                    @can('revisi')
                        <a href="{{ route('tugas.verifikasi.index') }}" class="text-decoration-none text-black">
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Verifikasi
                                </div>
                            </div>
                        </a>
                    @endcan
                </div>
                @auth
                    <a href="{{ route('surat-masuk.index') }}" class="w-100 text-decoration-none">
                        <div class="w-100 h-100 sidebar-button ps-3 py-3 d-flex align-items-center gap-2"
                            style="{{ Route::is('surat-masuk.index') ? 'background-color: #144272; color: white;' : 'background-color: white; color: black' }}">
                            <i style="width: 20px" class="fa-solid fa-inbox me-1"></i>
                            Surat Masuk
                        </div>
                    </a>
                @endauth
                @auth
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFour" aria-expanded="false"
                                aria-controls="flush-collapseFour">
                                <i style="width: 20px" class="fa-solid fa-envelope me-2"></i>
                                Surat Keluar
                            </button>
                        </h2>
                        <a href="{{ route('surat-keluar.index') }}" class="text-decoration-none text-black">
                            <div id="flush-collapseFour" class="accordion-collapse collapse border-bottom border-black"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Daftar Surat
                                </div>
                            </div>
                        </a>
                        @can('revisi')
                            <a href="{{ route('surat-keluar.verifikasi.index') }}" class="text-decoration-none text-black">
                                <div id="flush-collapseFour" class="accordion-collapse collapse border-bottom border-black"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Verifikasi Surat
                                    </div>
                                </div>
                            </a>
                        @endcan
                        <a href="{{ route('surat-keluar.arsip.index') }}" class="text-decoration-none text-black">
                            <div id="flush-collapseFour" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Arsip Surat
                                </div>
                            </div>
                        </a>
                    </div>
                @endauth

            </div>
            {{-- accordion end --}}
        </div>
    </div>
    {{-- top part end --}}

</nav>
