{{-- Modal Edit Start --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Agenda Rapat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editJudul" class="form-label">Judul Rapat</label>
                    <input type="text" class="form-control" id="editJudul">
                    <span id="editJudulError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="editPerihal" class="form-label">Perihal</label>
                    <input type="text" class="form-control" id="editPerihal">
                    <span id="editPerihalError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="editTempat" class="form-label">Tempat</label>
                    <select class="form-control form-select" id="editTempat">
                        <option value="">Pilih Tempat Rapat</option>
                        <option value="Tempat1">Tempat 1</option>
                        <option value="Tempat2">Tempat 2</option>
                        <option value="Tempat3">Tempat 3</option>
                        <option value="Tempat4">Tempat 4</option>
                    </select>
                    <span id="editTempatError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="editPemimpin" class="form-label">Pemimpin Rapat</label>
                    <select class="form-control form-select" id="editPemimpin">
                        <option value="">Pilih Pegawai</option>
                        <option value="1">Pegawai 1</option>
                        <option value="2">Pegawai 2</option>
                        <option value="3">Pegawai 3</option>
                        <option value="4">Pegawai 4</option>
                    </select>
                    <span id="editPemimpinError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="editPeserta" class="form-label">Peserta Rapat</label>
                    <div class="">
                        <select class="form-control form-select" id="editPeserta" name="peserta_rapat[]"
                            multiple="multiple" style="width: 100%">
                            <option value="">Pilih Semua Peserta Rapat</option>
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span id="editPesertaError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="start-time" class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control" id="editStartTime">
                    <span id="editStartTimeError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="end-time" class="form-label">Waktu Selesai</label>
                    <input type="time" class="form-control" id="editEndTime">
                    <span id="editEndTimeError" class="text-danger"></span>
                </div>
                <label for="color-selection">Pilih Warna Label Rapat</label>
                <div class="mb-3" id="color-selection">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="editColorOptions" id="editColorRed"
                            value="#d50000">
                        <label class="form-check-label" for="colorRed">
                            <span class="color-sample" style="background-color: #d50000;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="editColorOptions" id="editColorBlue"
                            value="#039ae5">
                        <label class="form-check-label" for="colorBlue">
                            <span class="color-sample" style="background-color: #039ae5;"></span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="editColorOptions" id="editColorGreen"
                            value="#33b679">
                        <label class="form-check-label" for="colorGreen">
                            <span class="color-sample" style="background-color: #33b679;"></span>
                        </label>
                    </div>
                </div>
                <button type="button" class="btn btn-danger" id="eventDeleteBtn">Hapus Rapat</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="updateBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editPeserta').select2({
            placeholder: "Pilih Semua Peserta Rapat",
            dropdownParent: $('#editModal')
        });
    });
</script>
{{-- Modal Edit End --}}
