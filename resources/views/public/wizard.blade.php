<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Status Pemeriksaan MCU - {{ $peserta->mou_peserta_name }}</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .circle-bg-1 {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            border: 4px solid #3b82f6;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.6;
        }

        .circle-bg-2 {
            position: absolute;
            top: 150px;
            right: 80px;
            width: 100px;
            height: 100px;
            border: 4px solid #cbd5e1;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.8;
        }

        .circle-bg-3 {
            position: absolute;
            bottom: 40px;
            left: 40px;
            width: 120px;
            height: 120px;
            border: 5px solid #3b82f6;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.6;
        }

        .main-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            z-index: 1;
            position: relative;
        }

        .left-panel {
            background: linear-gradient(165deg, #e11d48 0%, #be123c 45%, #881337 100%);
            color: #ffffff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .badge-system {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-radius: 20px;
            padding: 6px 16px;
            display: inline-block;
        }

        .quote-box {
            background: rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 20px;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #fecdd3;
            backdrop-filter: blur(5px);
        }

        .right-panel {
            padding: 40px;
            background: #ffffff;
        }

        .form-control-static {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 700;
            color: #334155;
        }

        .table-custom {
            border: 1px solid #fee2e2;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-custom thead {
            background-color: #fff1f2;
            color: #9f1239;
        }

        .table-custom th {
            font-size: 0.85rem;
            font-weight: 700;
            padding: 12px 20px;
            border: none;
        }

        .table-custom td {
            padding: 14px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .btn-submit-mcu {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-submit-mcu:hover {
            background: linear-gradient(135deg, #be123c 0%, #9f1239 100%);
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <div class="circle-bg-1"></div>
    <div class="circle-bg-2"></div>
    <div class="circle-bg-3"></div>

    <div class="main-card">
        <div class="row g-0">

            <!-- PANEL KIRI -->
            <div class="col-lg-5 left-panel">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-white rounded-3 px-3 py-2 d-inline-block shadow-sm">
                            <span class="fw-bold text-danger fs-5"><i class="bi bi-heart-pulse-fill me-1"></i> PRAMITA</span>
                        </div>
                        <div class="bg-white rounded-3 p-2 d-inline-block shadow-sm">
                            <i class="bi bi-qr-code fs-3 text-dark"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="badge-system">
                            <i class="bi bi-suit-heart-fill me-1"></i> MCU MANAGEMENT SYSTEM
                        </span>
                    </div>

                    <h1 class="fw-extrabold display-6 mb-3">Selamat Datang!</h1>
                    <p class="text-white-50 fs-7 mb-4">
                        Peserta Medical Check Up. Mohon periksa kelengkapan nama dan data Anda sebelum menyetujui formulir ini.
                    </p>

                    <div class="quote-box">
                        "Terima kasih atas kepercayaan yang telah diberikan kepada <strong>Pramita</strong> untuk memenuhi kebutuhan pemeriksaan Medical Check Up (MCU). Kami berkomitmen memberikan pelayanan terbaik, menjaga kualitas pemeriksaan, serta pengalaman layanan yang optimal bagi seluruh peserta."
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top border-white border-opacity-10 text-white-50 small">
                    &copy; {{ date('Y') }} MCU Management System. All rights reserved.
                </div>
            </div>

            <!-- PANEL KANAN -->
            <div class="col-lg-7 right-panel">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">Status Pemeriksaan</h3>
                        <p class="text-muted small mb-0">Periksa identitas dan perbarui status tindakan pemeriksaan Anda.</p>
                    </div>
                    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill" id="stepBadge">
                        Form <span id="currentStepNum">1</span> / <span id="totalStepNum">1</span>
                    </span>
                </div>

                <div id="alertContainer" class="mt-3"></div>

                <form id="wizardForm" class="mt-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="form-label text-muted small fw-bold mb-1">Nama Lengkap</label>
                            <div class="form-control-static text-uppercase">{{ $peserta->mou_peserta_name }}</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label text-muted small fw-bold mb-1">Nomor Induk Pegawai</label>
                            <div class="form-control-static">{{ $peserta->mou_peserta_nip }}</div>
                        </div>
                    </div>

                    <div class="text-center my-3">
                        <span class="text-uppercase text-muted fw-bold tracking-wider" style="font-size: 0.7rem; letter-spacing: 1px;">
                            DAFTAR ITEM PEMERIKSAAN (<span id="formStepTitle">Memuat...</span>)
                        </span>
                    </div>

                    <div class="table-responsive table-custom mb-4">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Pemeriksaan / Pertanyaan</th>
                                    <th scope="col" class="text-center" style="width: 140px;">Pilihan / Input</th>
                                </tr>
                            </thead>
                            <tbody id="formFieldsContainer">
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted">Memuat formulir...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <button type="button" class="btn btn-light border px-4 rounded-3 fw-bold d-none" id="btnPrev" onclick="changeStep(-1)">
                            &laquo; Sebelumnya
                        </button>
                        <div class="ms-auto">
                            <button type="submit" class="btn btn-submit-mcu shadow-sm" id="btnNext">
                                Simpan & Lanjut &raquo;
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Script JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const mouPesertaCode = '{{ $peserta->mou_peserta_code }}';
        const homeRouteUrl = '{{ route("login") }}';

        let mcuForms = [];
        let savedAnswers = {};
        let currentStepIndex = 0;

        document.addEventListener('DOMContentLoaded', () => {
            loadWizardData();
        });

        function showAlert(msg, type = 'success') {
            document.getElementById('alertContainer').innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                    <small class="fw-semibold">${msg}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        }

        function loadWizardData() {
            fetch(`{{ url('peserta-mcu/api/wizard-data') }}/${mouPesertaCode}`)
                .then(res => res.json())
                .then(res => {
                    mcuForms = res.forms || [];
                    savedAnswers = res.answers || {};

                    if (mcuForms.length === 0) {
                        document.getElementById('formFieldsContainer').innerHTML = `
                            <tr><td colspan="2" class="text-center py-4 text-muted">Belum ada form pemeriksaan MCU yang dikonfigurasi.</td></tr>`;
                        return;
                    }

                    // CEK PROTEKSI REFRESH: Jika jumlah jawaban sama/lebih dari total form, langsung lempar ke Home
                    const completedFormsCount = Object.keys(savedAnswers).length;
                    if (completedFormsCount >= mcuForms.length) {
                        window.location.href = homeRouteUrl;
                        return;
                    }

                    document.getElementById('totalStepNum').innerText = mcuForms.length;

                    // Mencari step pertama yang belum diisi agar pengguna tidak perlu ulang dari step 0
                    let startStep = 0;
                    for (let i = 0; i < mcuForms.length; i++) {
                        if (!savedAnswers[mcuForms[i].id_mcu_form]) {
                            startStep = i;
                            break;
                        }
                    }
                    renderStepForm(startStep);
                })
                .catch(() => {
                    showAlert('Gagal memuat data formulir. Silakan muat ulang halaman.', 'danger');
                });
        }

        function renderStepForm(stepIndex) {
            currentStepIndex = stepIndex;
            document.getElementById('currentStepNum').innerText = stepIndex + 1;

            const currentForm = mcuForms[stepIndex];
            document.getElementById('formStepTitle').innerText = currentForm.form_name;

            const currentAnswers = savedAnswers[currentForm.id_mcu_form] ? savedAnswers[currentForm.id_mcu_form].answers_data : {};

            let fieldsHtml = '';
            currentForm.items.forEach(item => {
                const value = currentAnswers[item.id_mcu_form_item] || '';

                fieldsHtml += `<tr>`;
                fieldsHtml += `
                    <td>
                        <div class="fw-bold text-dark">${item.item_label}</div>
                        ${item.unit ? `<small class="text-muted font-monospace">Satuan: ${item.unit}</small>` : ''}
                    </td>
                    <td class="text-center">`;

                if (item.field_type === 'yes_no') {
                    fieldsHtml += `
                        <div class="d-flex justify-content-center gap-3">
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input" type="radio" name="answers[${item.id_mcu_form_item}]" value="Ya" ${value === 'Ya' ? 'checked' : ''} required>
                                <label class="form-check-label small fw-semibold">Yes</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input" type="radio" name="answers[${item.id_mcu_form_item}]" value="Tidak" ${value === 'Tidak' ? 'checked' : ''} required>
                                <label class="form-check-label small fw-semibold">No</label>
                            </div>
                        </div>
                    `;
                } else if (item.field_type === 'select') {
                    fieldsHtml += `<select name="answers[${item.id_mcu_form_item}]" class="form-select form-select-sm" required>`;
                    fieldsHtml += `<option value="">-- Pilih --</option>`;
                    item.options.forEach(opt => {
                        const selected = value === opt.option_value ? 'selected' : '';
                        fieldsHtml += `<option value="${opt.option_value}" ${selected}>${opt.option_label}</option>`;
                    });
                    fieldsHtml += `</select>`;
                } else if (item.field_type === 'textarea') {
                    fieldsHtml += `<textarea name="answers[${item.id_mcu_form_item}]" class="form-control form-control-sm" rows="2" placeholder="Keterangan..." required>${value}</textarea>`;
                } else if (item.field_type === 'number') {
                    fieldsHtml += `<input type="number" step="any" name="answers[${item.id_mcu_form_item}]" class="form-control form-control-sm" value="${value}" required>`;
                } else {
                    fieldsHtml += `<input type="text" name="answers[${item.id_mcu_form_item}]" class="form-control form-control-sm" value="${value}" required>`;
                }

                fieldsHtml += `</td></tr>`;
            });

            document.getElementById('formFieldsContainer').innerHTML = fieldsHtml;

            document.getElementById('btnPrev').classList.toggle('d-none', stepIndex === 0);

            const isLastStep = stepIndex === mcuForms.length - 1;
            const btnNext = document.getElementById('btnNext');

            if (isLastStep) {
                btnNext.className = 'btn btn-danger px-4 rounded-3 fw-bold shadow-sm';
                btnNext.innerHTML = 'Simpan & Selesai';
            } else {
                btnNext.className = 'btn btn-submit-mcu shadow-sm';
                btnNext.innerHTML = 'Simpan & Lanjut &raquo;';
            }
        }

        document.getElementById('wizardForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const currentForm = mcuForms[currentStepIndex];
            const formData = new FormData(this);
            formData.append('mou_peserta_code', mouPesertaCode);
            formData.append('id_mcu_form', currentForm.id_mcu_form);

            const btnNext = document.getElementById('btnNext');
            btnNext.disabled = true;

            fetch('{{ route("peserta-mcu.save-step") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    btnNext.disabled = false;
                    savedAnswers[currentForm.id_mcu_form] = res.data;

                    if (currentStepIndex < mcuForms.length - 1) {
                        showAlert(res.message, 'success');
                        renderStepForm(currentStepIndex + 1);
                    } else {
                        // SETELAH STEP TERAKHIR SELESAI: Direct Redirect ke Home
                        window.location.href = homeRouteUrl;
                    }
                })
                .catch(() => {
                    btnNext.disabled = false;
                    showAlert('Terjadi kesalahan saat menyimpan data. Coba lagi.', 'danger');
                });
        });

        function changeStep(direction) {
            const targetStep = currentStepIndex + direction;
            if (targetStep >= 0 && targetStep < mcuForms.length) {
                renderStepForm(targetStep);
            }
        }
    </script>
</body>

</html>
