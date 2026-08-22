<div class="modal-header bg-danger text-white">
    <h5 class="modal-title text-white" id="modalLabel"><i class="fas fa-notes-medical me-2"></i>Setup Form Pemeriksaan MCU</h5>
    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form id="formSaveMouForms">
    @csrf
    <input type="hidden" name="company_mou_code" value="{{ $companyMouCode }}">

    <div class="modal-body p-4">
        <p class="text-muted fs--1">Pilih jenis formulir pemeriksaan MCU yang akan dikonfigurasikan untuk MOU ini:</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle fs--1">
                <thead class="bg-200">
                    <tr>
                        <th class="text-center" style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="checkAllForms">
                        </th>
                        <th>Kode Form</th>
                        <th>Nama Form Pemeriksaan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($forms as $form)
                    <tr>
                        <td class="text-center">
                            <input class="form-check-input form-checkbox" type="checkbox" name="form_codes[]" value="{{ $form->form_code }}" {{ in_array($form->form_code, $selectedForms) ? 'checked' : '' }}>
                        </td>
                        <td><span class="badge bg-secondary font-monospace">{{ $form->form_code }}</span></td>
                        <td class="fw-bold text-dark">{{ $form->form_name }}</td>
                        <td>{{ $form->description ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Belum ada master form MCU yang aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer bg-light">
        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-danger btn-sm px-4 fw-bold" type="submit" id="btnSaveForms">
            <i class="fas fa-save me-1"></i> Simpan Konfigurasi
        </button>
    </div>
</form>

<script>
    // Fitur Check/Uncheck All
    document.getElementById('checkAllForms')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.form-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Handle AJAX Submit Form
    document.getElementById('formSaveMouForms').addEventListener('submit', function(e) {
        e.preventDefault();

        const btnSave = document.getElementById('btnSaveForms');
        btnSave.disabled = true;
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const formData = new FormData(this);

        fetch("{{ route('mou_company_save_form_pemeriksaan') }}", {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                    btnSave.disabled = false;
                    btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Konfigurasi';
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Terjadi kesalahan pada sistem.', 'error');
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Konfigurasi';
            });
    });
</script>
