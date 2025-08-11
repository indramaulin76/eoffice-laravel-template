<!-- Modal Create Start -->
<div class="modal fade" id="createRapatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Agenda Rapat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Rapat</label>
                    <input type="text" class="form-control" id="judul">
                    <span id="judulError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="perihal" class="form-label">Perihal</label>
                    <input type="text" class="form-control" id="perihal">
                    <span id="perihalError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="tempat" class="form-label">Tempat</label>
                    <select class="form-control form-select" id="tempat">
                        <option value="">Pilih Tempat Rapat</option>
                        <option value="Tempat1">Tempat 1</option>
                        <option value="Tempat2">Tempat 2</option>
                        <option value="Tempat3">Tempat 3</option>
                        <option value="Tempat4">Tempat 4</option>
                    </select>
                    <span id="tempatError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="pemimpin" class="form-label">Pemimpin Rapat</label>
                    <select class="form-control form-select" id="pemimpin">
                        <option value="">Pilih Pegawai</option>
                        @foreach ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                        @endforeach
                    </select>
                    <span id="pemimpinError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="peserta" class="form-label">Peserta Rapat</label>
                    <div class="">
                        <select class="form-control form-select" id="peserta" name="peserta_rapat[]"
                            multiple="multiple" style="width: 100%">
                            <option value="">Pilih Semua Peserta Rapat</option>
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span id="pesertaError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="start-time" class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control" id="start-time">
                    <span id="startTimeError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="end-time" class="form-label">Waktu Selesai</label>
                    <input type="time" class="form-control" id="end-time">
                    <span id="endTimeError" class="text-danger"></span>
                </div>
                <label for="color-selection">Pilih Warna Label Rapat</label>
                <div class="mb-3" id="color-selection">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="colorOptions" id="colorRed"
                            value="#d50000">
                        <label class="form-check-label" for="colorRed">
                            <span class="color-sample" style="background-color: #d50000;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="colorOptions" id="colorBlue"
                            value="#039ae5">
                        <label class="form-check-label" for="colorBlue">
                            <span class="color-sample" style="background-color: #039ae5;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="colorOptions" id="colorGreen"
                            value="#33b679">
                        <label class="form-check-label" for="colorGreen">
                            <span class="color-sample" style="background-color: #33b679;"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#peserta').select2({
            placeholder: "Pilih Semua Peserta Rapat",
            dropdownParent: $('#createRapatModal')
        });
    });
</script>
<!-- Modal Create End -->
