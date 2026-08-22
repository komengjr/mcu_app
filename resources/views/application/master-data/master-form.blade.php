@extends('layouts.template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Master Form Pemeriksaan MCU</h3>
    <button class="btn btn-primary" onclick="openModalForm()">
        <i class="bi bi-plus-lg"></i> + Tambah Form Baru
    </button>
</div>

<!-- Alert Notifikasi SPA -->
<div id="alertContainer"></div>

<!-- Tabel Daftar Form Header -->
<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 80px;">Urutan</th>
                        <th scope="col">Kode Form</th>
                        <th scope="col">Nama Form</th>
                        <th scope="col">Jumlah Item</th>
                        <th scope="col" style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableFormsBody">
                    <!-- Loaded via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Section Detail Item Pertanyaan (Muncul saat diklik) -->
<div class="card shadow-sm d-none" id="cardItems">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fs-2 fw-bold text-white" id="selectedFormTitle">Item Pertanyaan Form</h5>
        <button class="btn btn-sm btn-success" onclick="openModalItem()">
            + Tambah Item Pertanyaan
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 80px;">Urutan</th>
                        <th scope="col">Pertanyaan / Label</th>
                        <th scope="col">Tipe Input</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Opsi (Select)</th>
                        <th scope="col" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableItemsBody">
                    <!-- Loaded via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- ================= MODAL FORM (BOOTSTRAP 5) ================= -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formMaster" class="w-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalFormTitle">Form MCU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_mcu_form" id="id_mcu_form">
                    <div class="mb-3">
                        <label for="form_code" class="form-label font-weight-bold">Kode Form (Unik)</label>
                        <input type="text" name="form_code" id="form_code" class="form-control" placeholder="Contoh: FORM_PHYSICAL" required>
                    </div>
                    <div class="mb-3">
                        <label for="form_name" class="form-label font-weight-bold">Nama Form</label>
                        <input type="text" name="form_name" id="form_name" class="form-control" placeholder="Contoh: Form Pemeriksaan Fisik" required>
                    </div>
                    <div class="mb-3">
                        <label for="form_sort_order" class="form-label font-weight-bold">Urutan Tampil</label>
                        <input type="number" name="sort_order" id="form_sort_order" class="form-control" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL ITEM (BOOTSTRAP 5) ================= -->
<div class="modal fade" id="modalItem" tabindex="-1" aria-labelledby="modalItemTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formItem" class="w-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalItemTitle">Item Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_mcu_form_item" id="id_mcu_form_item">
                    <input type="hidden" name="id_mcu_form" id="item_id_mcu_form">

                    <div class="mb-3">
                        <label for="item_label" class="form-label font-weight-bold">Pertanyaan / Label Item</label>
                        <input type="text" name="item_label" id="item_label" class="form-control" placeholder="Contoh: Sering Sakit Kepala?" required>
                    </div>
                    <div class="mb-3">
                        <label for="field_type" class="form-label font-weight-bold">Tipe Input</label>
                        <select name="field_type" id="field_type" class="form-select" onchange="toggleSelectOptions()" required>
                            <option value="yes_no">Yes / No (Radio)</option>
                            <option value="text">Teks Singkat</option>
                            <option value="number">Angka</option>
                            <option value="select">Dropdown (Select)</option>
                            <option value="textarea">Teks Panjang (Textarea)</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="optionsContainer">
                        <label for="options_input" class="form-label font-weight-bold">Opsi Dropdown (Pisahkan koma):</label>
                        <input type="text" id="options_input" class="form-control" placeholder="Contoh: Normal, Abnormal, Ringan">
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label font-weight-bold">Satuan (Opsional)</label>
                        <input type="text" name="unit" id="unit" class="form-control" placeholder="e.g. mmHg / kg / cm">
                    </div>
                    <div class="mb-3">
                        <label for="item_sort_order" class="form-label font-weight-bold">Urutan Tampil</label>
                        <input type="number" name="sort_order" id="item_sort_order" class="form-control" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Item</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';
    let currentActiveFormId = null;

    // Inisialisasi Instance Bootstrap 5 Modal (Tanpa jQuery)
    let modalFormInstance = null;
    let modalItemInstance = null;

    document.addEventListener('DOMContentLoaded', () => {
        modalFormInstance = new bootstrap.Modal(document.getElementById('modalForm'));
        modalItemInstance = new bootstrap.Modal(document.getElementById('modalItem'));
        loadForms();
    });

    function showAlert(msg, type = 'success') {
        document.getElementById('alertContainer').innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }

    // --- 1. PROSES FORM MASTER ---
    function loadForms() {
        fetch('{{ route("master-mcu.get-forms") }}')
            .then(res => res.json())
            .then(res => {
                let html = '';
                res.data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.sort_order}</td>
                            <td><code class="fw-bold">${item.form_code}</code></td>
                            <td><span class="fw-bold text-dark">${item.form_name}</span></td>
                            <td><span class="badge bg-info text-dark">${item.items_count} Item</span></td>
                            <td>
                                <button class="btn btn-sm btn-info text-white me-1" onclick="loadItems(${item.id_mcu_form}, '${item.form_name}')">Kelola Item</button>
                                <button class="btn btn-sm btn-warning me-1" onclick='openModalForm(${JSON.stringify(item)})'>Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteForm(${item.id_mcu_form})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
                document.getElementById('tableFormsBody').innerHTML = html || '<tr><td colspan="5" class="text-center py-3 text-muted">Data Master Form Kosong</td></tr>';
            });
    }

    function openModalForm(data = null) {
        document.getElementById('formMaster').reset();
        document.getElementById('id_mcu_form').value = data ? data.id_mcu_form : '';
        document.getElementById('form_code').value = data ? data.form_code : '';
        document.getElementById('form_name').value = data ? data.form_name : '';
        document.getElementById('form_sort_order').value = data ? data.sort_order : '1';
        document.getElementById('modalFormTitle').innerText = data ? 'Edit Form MCU' : 'Tambah Form MCU Baru';

        modalFormInstance.show();
    }

    document.getElementById('formMaster').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("master-mcu.save-form") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                modalFormInstance.hide();
                showAlert(res.message);
                loadForms();
            });
    });

    function deleteForm(id) {
        if (!confirm('Hapus Form ini beserta seluruh item di dalamnya?')) return;
        fetch(`{{ url('application/api/forms') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(res => {
                showAlert(res.message);
                loadForms();
                if (currentActiveFormId === id) {
                    document.getElementById('cardItems').classList.add('d-none');
                }
            });
    }

    // --- 2. PROSES ITEM PERTANYAAN ---
    function loadItems(formId, formName) {
        currentActiveFormId = formId;
        document.getElementById('selectedFormTitle').innerText = `Item Pertanyaan: ${formName}`;
        document.getElementById('cardItems').classList.remove('d-none');

        fetch(`{{ url('application/api/forms') }}/${formId}/items`)
            .then(res => res.json())
            .then(res => {
                let html = '';
                res.data.items.forEach(item => {
                    let optionsBadge = item.options.map(o => `<span class="badge bg-secondary me-1">${o.option_label}</span>`).join('');
                    html += `
                        <tr>
                            <td>${item.sort_order}</td>
                            <td><strong>${item.item_label}</strong></td>
                            <td><span class="badge bg-primary">${item.field_type.toUpperCase()}</span></td>
                            <td>${item.unit || '-'}</td>
                            <td>${optionsBadge || '-'}</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" onclick='openModalItem(${JSON.stringify(item)})'>Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteItem(${item.id_mcu_form_item})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
                document.getElementById('tableItemsBody').innerHTML = html || '<tr><td colspan="6" class="text-center py-3 text-muted">Belum ada item pertanyaan untuk form ini</td></tr>';
            });
    }

    function toggleSelectOptions() {
        const val = document.getElementById('field_type').value;
        const container = document.getElementById('optionsContainer');
        if (val === 'select') container.classList.remove('d-none');
        else container.classList.add('d-none');
    }

    function openModalItem(data = null) {
        document.getElementById('formItem').reset();
        document.getElementById('id_mcu_form_item').value = data ? data.id_mcu_form_item : '';
        document.getElementById('item_id_mcu_form').value = currentActiveFormId;
        document.getElementById('item_label').value = data ? data.item_label : '';
        document.getElementById('field_type').value = data ? data.field_type : 'yes_no';
        document.getElementById('unit').value = data ? (data.unit || '') : '';
        document.getElementById('item_sort_order').value = data ? data.sort_order : '1';

        if (data && data.options) {
            document.getElementById('options_input').value = data.options.map(o => o.option_label).join(', ');
        } else {
            document.getElementById('options_input').value = '';
        }

        toggleSelectOptions();
        document.getElementById('modalItemTitle').innerText = data ? 'Edit Item' : 'Tambah Item Pertanyaan Baru';

        modalItemInstance.show();
    }

    document.getElementById('formItem').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        const rawOptions = document.getElementById('options_input').value;
        if (rawOptions) {
            rawOptions.split(',').forEach(opt => {
                formData.append('options[]', opt.trim());
            });
        }

        fetch('{{ route("master-mcu.save-item") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                modalItemInstance.hide();
                showAlert(res.message);
                loadItems(currentActiveFormId, '');
                loadForms();
            });
    });

    function deleteItem(itemId) {
        if (!confirm('Hapus item pertanyaan ini?')) return;
        fetch(`{{ url('application/api/items') }}/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(res => {
                showAlert(res.message);
                loadItems(currentActiveFormId, '');
                loadForms();
            });
    }
</script>
@endsection
