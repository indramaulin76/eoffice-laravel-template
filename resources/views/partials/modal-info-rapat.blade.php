{{-- Modal Info Start --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-start gap-3 mb-2" style="color: #747474;">
                    <i class="mt-1 fa-regular fa-calendar-days" style="color: #d9d9d9"></i>
                    <span class="ms-3" id="hariTanggal"></span>
                </div>
                <div class="d-flex align-items-start gap-3 mb-2" style="color: #747474;">
                    <i class="mt-1 fa-solid fa-location-dot" style="color: #d9d9d9"></i>
                    <span class="ms-3" id="tempat"></span>
                </div>
                <div class="d-flex align-items-start gap-3 mb-2" style="color: #747474;">
                    <i class="mt-1 fa-solid fa-list" style="color: #d9d9d9"></i>
                    <span class="ms-3" id="perihal"></span>
                </div>
                <div class="d-flex align-items-start gap-3 mb-2" style="color: #747474;">
                    <i class="mt-1 fa-solid fa-user" style="color: #d9d9d9"></i>
                    <ul id="peserta"></ul>
                </div>
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
{{-- Modal Info End --}}
