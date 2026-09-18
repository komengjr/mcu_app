@extends('layouts.template')

@section('base.css')
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    /* Global Stat Cards */
    .card-stat {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s;
    }

    .card-stat:hover {
        transform: translateY(-3px);
    }

    .bg-light-primary {
        background-color: #cfe2ff;
        color: #084298;
    }

    .bg-light-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .bg-light-warning {
        background-color: #fff3cd;
        color: #664d03;
    }

    /* Styling Modal Fullscreen & Fixed Footer */
    #modalPemeriksaanFisik .modal-content {
        height: 100vh !important;
        max-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
        border: none !important;
        border-radius: 0 !important;
    }

    #modalPemeriksaanFisik form#formInputFisik {
        display: flex !important;
        flex-direction: column !important;
        flex: 1 1 auto !important;
        height: calc(100vh - 48px) !important;
        overflow: hidden !important;
        margin: 0 !important;
    }

    #modalPemeriksaanFisik .modal-body {
        flex: 1 1 auto !important;
        overflow-y: auto !important;
        padding: 1rem !important;
        background-color: #f8f9fa !important;
    }

    #modalPemeriksaanFisik .modal-footer {
        flex-shrink: 0 !important;
        background-color: #ffffff !important;
        border-top: 1px solid #dee2e6 !important;
        padding: 0.6rem 1.25rem !important;
        z-index: 1060 !important;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.08) !important;
    }

    .info-label {
        font-size: 0.72rem !important;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .info-value {
        font-size: 0.85rem !important;
        font-weight: 700 !important;
        color: #212529 !important;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .card-param {
        border: 1px solid #e0e6ed !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02) !important;
        margin-bottom: 0.85rem !important;
        background-color: #ffffff;
    }

    .card-param .card-header {
        padding: 0.4rem 0.85rem !important;
        background-color: #f1f5f9 !important;
        border-bottom: 1px solid #e2e8f0 !important;
        border-left: 4px solid #0d6efd !important;
    }

    .card-param .card-header h6 {
        font-size: 0.825rem !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        margin: 0;
        letter-spacing: 0.3px;
    }

    .param-label {
        font-size: 0.78rem !important;
        font-weight: 600 !important;
        color: #475569 !important;
        margin-bottom: 0.2rem !important;
    }

    .param-input {
        font-size: 0.825rem !important;
        padding: 0.25rem 0.5rem !important;
        height: 31px !important;
    }

    .input-keterangan {
        font-size: 0.75rem !important;
        height: 28px !important;
        border-color: #f87171 !important;
        background-color: #fef2f2 !important;
    }

    .input-keterangan:focus {
        background-color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.25) !important;
    }

    /* Styling Grid Odontogram Gigi */
    .odontogram-grid {
        display: grid;
        grid-template-columns: repeat(16, 1fr);
        gap: 3px;
        background: #f1f5f9;
        padding: 6px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
    }

    .tooth-box {
        background: #ffffff;
        border: 1px solid #94a3b8;
        border-radius: 4px;
        text-align: center;
        padding: 3px 1px;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        user-select: none;
    }

    .tooth-box:hover {
        border-color: #0d6efd;
        background-color: #e0e7ff;
    }

    .tooth-box.has-code {
        background-color: #fee2e2;
        border-color: #ef4444;
    }

    .tooth-number {
        font-size: 0.65rem;
        font-weight: 700;
        color: #334155;
    }

    .tooth-code {
        font-size: 0.6rem;
        font-weight: 800;
        color: #dc2626;
        min-height: 14px;
        line-height: 14px;
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Pemeriksaan Fisik Dokter</h3>
        <p class="text-muted mb-0">Penginputan form hasil pemeriksaan fisik peserta MCU berdasarkan perusahaan dan MoU.</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card shadow-sm border-0 mb-3 rounded-3">
    <div class="card-body p-4">
        <h5 class="fw-semibold text-primary mb-3"><i class="fas fa-filter me-2"></i>Filter Data Peserta</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="filter_company" class="form-label fw-medium text-secondary">Pilih Perusahaan <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_company" name="company_code">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->master_company_code }}">{{ $company->master_company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="filter_mou" class="form-label fw-medium text-secondary">Pilih MoU <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_mou" name="company_mou_code" disabled>
                    <option value="">-- Pilih Perusahaan Terlebih Dahulu --</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Summary Stats Card -->
<div id="stats_container" class="row g-3 mb-3 d-none">
    <div class="col-md-4">
        <div class="card card-stat bg-light-primary shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary text-white rounded-3 p-3">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Total Peserta</h6>
                    <h3 class="mb-0 fw-bold" id="stat_total">0</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-light-success shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success text-white rounded-3 p-3">
                    <i class="fas fa-user-check fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Sudah Periksa Fisik</h6>
                    <h3 class="mb-0 fw-bold text-success" id="stat_sudah">0</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-light-warning shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-warning text-white rounded-3 p-3">
                    <i class="fas fa-user-clock fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Belum Periksa Fisik</h6>
                    <h3 class="mb-0 fw-bold text-warning" id="stat_belum">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Container -->
<div id="content_container" class="card shadow-sm border-0 rounded-3 d-none">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="table_peserta_fisik" class="table table-striped table-bordered align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIP / NIK</th>
                        <th>Nama Peserta</th>
                        <th>Departemen</th>
                        <th>Dokter Pemeriksa</th>
                        <th class="text-center">Status Fisik</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody_peserta"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Fullscreen -->
<div class="modal fade" id="modalPemeriksaanFisik" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen p-0 m-0">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2 px-3 flex-shrink-0">
                <h6 class="modal-title text-white fw-bold m-0"><i class="fas fa-stethoscope me-2"></i>Form Hasil Pemeriksaan Fisik Medis</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formInputFisik">
                @csrf
                <input type="hidden" name="mou_peserta_code" id="modal_peserta_code">

                <div class="modal-body">
                    <!-- Info Peserta -->
                    <div class="card card-param mb-3">
                        <div class="card-body p-2 bg-white">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-3 border-end">
                                    <div class="info-label">Nama Peserta</div>
                                    <div class="info-value text-truncate" id="bio_nama">-</div>
                                </div>
                                <div class="col-md-2 border-end">
                                    <div class="info-label">NIP / NIK</div>
                                    <div class="info-value" id="bio_nip">-</div>
                                </div>
                                <div class="col-md-2 border-end">
                                    <div class="info-label">Departemen</div>
                                    <div class="info-value text-truncate" id="bio_dept">-</div>
                                </div>
                                <div class="col-md-2">
                                    <label class="param-label">Tgl Periksa <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control param-input" name="tgl_pemeriksaan" id="inp_tgl_pemeriksaan" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="param-label">No. Reg <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control param-input" name="no_reg" id="inp_no_reg" required placeholder="REG-XXX">
                                </div>
                                <div class="col-md-2">
                                    <label class="param-label">Dokter Pemeriksa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control param-input" name="dokter_pemeriksa" id="inp_dokter" required placeholder="dr. Name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layout Parameters 2 Kolom -->
                    <div class="row g-2">
                        <div class="col-lg-6" id="col_left_parameters"></div>
                        <div class="col-lg-6" id="col_right_parameters"></div>
                    </div>

                    <!-- Kesimpulan -->
                    <div class="card card-param mt-2 mb-2">
                        <div class="card-header bg-white">
                            <h6 class="text-primary m-0"><i class="fas fa-file-medical-alt me-1"></i> Kesimpulan Pemeriksaan Fisik</h6>
                        </div>
                        <div class="card-body p-2">
                            <textarea class="form-control" name="kesimpulan" id="inp_kesimpulan_fisik" rows="2" style="font-size: 0.85rem;" placeholder="Catatan kesimpulan..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-4" id="btnSaveFisik">
                        <i class="fas fa-save me-1"></i> Simpan Hasil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Popover Pilih Kode Odontogram Gigi -->
<div class="modal fade" id="modalSelectKodeGigi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow">
            <div class="modal-header py-2 bg-light">
                <h6 class="modal-title fw-bold">Gigi No: <span id="lbl_selected_gigi" class="text-primary">11</span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <label class="form-label fs-7 fw-semibold mb-1">Pilih Status Odontogram:</label>
                <select class="form-select form-select-sm mb-3" id="sel_kode_gigi">
                    <option value="">-- Normal / Sehat --</option>
                    <option value="CAR">CAR - Karies / Berlubang</option>
                    <option value="SXT">SXT - Sisa Akar (Radix)</option>
                    <option value="MIS">MIS - Gigi Hilang (Missing)</option>
                    <option value="FMC">FMC - Crown / Mahkota Buatan</option>
                    <option value="AMO">AMO - Tumpatan Amalgam</option>
                    <option value="GIF">GIF - Tumpatan GIC</option>
                    <option value="CRB">CRB - Bridge</option>
                    <option value="RCT">RCT - Perawatan Saluran Akar</option>
                    <option value="UNE">UNE - Unerupted (Belum Erupsi)</option>
                    <option value="PRE">PRE - Partial Erupted</option>
                </select>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm btn-primary fw-bold" id="btn_apply_kode_gigi">Set Kode</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('base.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        let dataTablePeserta = null;

        let companyChoices = new Choices('#filter_company', {
            searchEnabled: true,
            itemSelectText: ''
        });
        let mouChoices = new Choices('#filter_mou', {
            searchEnabled: true,
            itemSelectText: ''
        });

        let activeToothNum = null;
        let activeParamInput = null;

        // Filter Perusahaan -> Load MoU
        $('#filter_company').on('change', function() {
            let companyCode = $(this).val();
            mouChoices.clearStore();
            mouChoices.clearChoices();
            mouChoices.disable();
            resetTableAndStats();

            if (companyCode) {
                $.ajax({
                    url: "{{ route('pemeriksaan_fisik.get_mou') }}",
                    type: 'GET',
                    data: {
                        company_code: companyCode
                    },
                    success: function(response) {
                        let choicesData = [{
                            value: '',
                            label: '-- Pilih MoU --',
                            selected: true,
                            disabled: true
                        }];
                        $.each(response, function(index, item) {
                            choicesData.push({
                                value: item.company_mou_code,
                                label: item.company_mou_name
                            });
                        });
                        mouChoices.setChoices(choicesData, 'value', 'label', true);
                        mouChoices.enable();
                    }
                });
            }
        });

        // Filter MoU -> Load Table Peserta
        $('#filter_mou').on('change', function() {
            let mouCode = $(this).val();
            if (mouCode) {
                loadPesertaFisikData(mouCode);
            } else {
                resetTableAndStats();
            }
        });

        function loadPesertaFisikData(mouCode) {
            $('#stats_container').removeClass('d-none');
            $('#content_container').removeClass('d-none');

            // Destroy instance DataTable lama jika ada
            if (dataTablePeserta !== null) {
                dataTablePeserta.destroy();
                dataTablePeserta = null;
            }

            $('#tbody_peserta').html('<tr><td colspan="7" class="text-center py-4"><span class="spinner-border spinner-border-sm me-2 text-primary"></span>Memuat data peserta...</td></tr>');

            $.ajax({
                url: "{{ route('pemeriksaan_fisik.get_participants') }}",
                type: "GET",
                data: {
                    mou_code: mouCode
                },
                success: function(response) {
                    let rows = '';
                    if (response.length === 0) {
                        rows = '';
                    } else {
                        $.each(response, function(index, item) {
                            let nip = item.mou_peserta_nip ? item.mou_peserta_nip : '-';
                            let nik = item.mou_peserta_nik ? item.mou_peserta_nik : '-';
                            let dokter = item.dokter_pemeriksa ? `<span class="fw-semibold text-dark"><i class="fas fa-user-md me-1 text-primary"></i>${item.dokter_pemeriksa}</span>` : '<span class="text-muted fs-7">-</span>';

                            let statusBadge = item.id_pemeriksaan_fisik ?
                                '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Sudah Periksa</span>' :
                                '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Belum Periksa</span>';

                            let btnText = item.id_pemeriksaan_fisik ? 'Edit Fisik' : 'Input Fisik';
                            let btnClass = item.id_pemeriksaan_fisik ? 'btn-outline-primary' : 'btn-primary';

                            rows += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>${nip} / ${nik}</td>
                                    <td class="fw-semibold">${item.mou_peserta_name}</td>
                                    <td>${item.mou_peserta_departemen ?? '-'}</td>
                                    <td>${dokter}</td>
                                    <td class="text-center">${statusBadge}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm ${btnClass} btn-input-fisik" data-peserta-code="${item.mou_peserta_code}">
                                            <i class="fas fa-edit me-1"></i>${btnText}
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    $('#tbody_peserta').html(rows);

                    // Inisialisasi DataTable
                    dataTablePeserta = $('#table_peserta_fisik').DataTable({
                        language: {
                            search: "Cari Peserta:",
                            searchPlaceholder: "Ketik nama, NIP, NIK, dll...",
                            lengthMenu: "Tampilkan _MENU_ data",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ peserta",
                            infoEmpty: "Menampilkan 0 data",
                            infoFiltered: "(disaring dari _MAX_ total peserta)",
                            zeroRecords: "Tidak ada data peserta yang cocok ditemukan",
                            paginate: {
                                first: "Awal",
                                last: "Akhir",
                                next: "Lanjut",
                                previous: "Kembali"
                            }
                        },
                        pageLength: 10,
                        order: [
                            [0, 'asc']
                        ],
                        columnDefs: [{
                                orderable: false,
                                targets: [6]
                            } // Matikan sorting untuk kolom aksi
                        ]
                    });
                },
                error: function() {
                    $('#tbody_peserta').html('<tr><td colspan="7" class="text-center text-danger py-4">Gagal memuat data peserta.</td></tr>');
                }
            });

            $.ajax({
                url: "{{ route('pemeriksaan_fisik.get_summary_stats') }}",
                type: "GET",
                data: {
                    mou_code: mouCode
                },
                success: function(res) {
                    $('#stat_total').text(res.total);
                    $('#stat_sudah').text(res.sudah);
                    $('#stat_belum').text(res.belum);
                }
            });
        }

        function resetTableAndStats() {
            if (dataTablePeserta !== null) {
                dataTablePeserta.destroy();
                dataTablePeserta = null;
            }
            $('#stats_container').addClass('d-none');
            $('#content_container').addClass('d-none');
            $('#tbody_peserta').empty();
        }

        // Open Modal & Set Default Values
        $(document).on('click', '.btn-input-fisik', function() {
            let pesertaCode = $(this).data('peserta-code');
            $('#formInputFisik')[0].reset();
            $('#modal_peserta_code').val(pesertaCode);

            let today = new Date().toISOString().split('T')[0];
            $('#inp_tgl_pemeriksaan').val(today);

            $('#col_left_parameters').html('');
            $('#col_right_parameters').html('');

            $.ajax({
                url: "{{ route('pemeriksaan_fisik.get_detail') }}",
                type: "GET",
                data: {
                    peserta_code: pesertaCode
                },
                success: function(res) {
                    $('#bio_nama').text(res.peserta.mou_peserta_name);
                    $('#bio_nip').text((res.peserta.mou_peserta_nip ?? '-') + ' / ' + (res.peserta.mou_peserta_nik ?? '-'));
                    $('#bio_dept').text(res.peserta.mou_peserta_departemen ?? '-');

                    if (res.header) {
                        $('#inp_no_reg').val(res.header.no_reg);
                        $('#inp_dokter').val(res.header.dokter_pemeriksa);
                        if (res.header.tgl_pemeriksaan) {
                            $('#inp_tgl_pemeriksaan').val(res.header.tgl_pemeriksaan);
                        }
                        $('#inp_kesimpulan_fisik').val(res.header.kesimpulan);
                    }

                    renderDynamicForm(res.parameters, res.saved_results, res.saved_keterangan || {});
                    $('#modalPemeriksaanFisik').modal('show');
                }
            });
        });

        // Event Listener Toggle Dynamic Input Keterangan saat Option Berubah
        $(document).on('change', '.select-param', function() {
            let selectedVal = $(this).val() ? $(this).val().toUpperCase() : '';
            let paramId = $(this).data('param-id');
            let containerKet = $(`.wrapper-keterangan-${paramId}`);

            if (selectedVal !== '' && selectedVal !== 'NORMAL') {
                containerKet.slideDown(150);
                containerKet.find('.input-keterangan').focus();
            } else {
                containerKet.slideUp(150);
                containerKet.find('.input-keterangan').val('');
            }
        });

        // Interaksi Odontogram: Klik Kotak Gigi
        $(document).on('click', '.tooth-box', function() {
            activeToothNum = $(this).data('tooth');
            activeParamInput = $(this).closest('.odontogram-wrapper').find('.input-odontogram-result');
            let currentCode = $(`#code_tooth_${activeToothNum}`).text().trim();

            $('#lbl_selected_gigi').text(activeToothNum);
            $('#sel_kode_gigi').val(currentCode);
            $('#modalSelectKodeGigi').modal('show');
        });

        // Interaksi Odontogram: Apply Kode Gigi
        $('#btn_apply_kode_gigi').on('click', function() {
            let selectedCode = $('#sel_kode_gigi').val();
            let toothCodeElem = $(`#code_tooth_${activeToothNum}`);
            let toothBoxElem = toothCodeElem.closest('.tooth-box');

            toothCodeElem.text(selectedCode);
            if (selectedCode) {
                toothBoxElem.addClass('has-code');
            } else {
                toothBoxElem.removeClass('has-code');
            }

            let resultsArr = [];
            $('.tooth-box').each(function() {
                let tNum = $(this).data('tooth');
                let tCode = $(this).find('.tooth-code').text().trim();
                if (tCode) {
                    resultsArr.push(`${tNum}:${tCode}`);
                }
            });

            if (activeParamInput) {
                activeParamInput.val(resultsArr.join(', '));
            }

            $('#modalSelectKodeGigi').modal('hide');
        });

        // Function Render Input Form Parameter Dinamis
        function renderDynamicForm(parameters, savedResults, savedKeterangan) {
            let grouped = {};

            const leftCategories = [
                'TANDA VITAL', 'STATUS GIZI', 'KEADAAN UMUM', 'KEPALA & WAJAH',
                'MATA', 'TELINGA', 'HIDUNG', 'GIGI & MULUT', 'LEHER', 'THORAX / DADA', 'PARU-PARU', 'JANTUNG'
            ];

            const categoryColors = {
                'TANDA VITAL': '#0d6efd',
                'STATUS GIZI': '#198754',
                'KEADAAN UMUM': '#6f42c1',
                'MATA': '#0dcaf0',
                'TELINGA': '#fd7e14',
                'HIDUNG': '#20c997',
                'GIGI & MULUT': '#d63384',
                'PERUT / ABDOMEN': '#0284c7',
                'SISTEM INTEGUMEN': '#84cc16',
                'SISTEM PERSYARAFAN': '#eab308',
                'LOW BACK PAIN SCREENING': '#dc3545'
            };

            parameters.forEach(param => {
                if (!grouped[param.kategori]) {
                    grouped[param.kategori] = [];
                }
                grouped[param.kategori].push(param);
            });

            let leftHtml = '';
            let rightHtml = '';

            $.each(grouped, function(kategori, items) {
                let accentColor = categoryColors[kategori] || '#0d6efd';

                let cardHtml = `
                    <div class="card card-param">
                        <div class="card-header" style="border-left-color: ${accentColor} !important;">
                            <h6 style="color: ${accentColor} !important;">${kategori}</h6>
                        </div>
                        <div class="card-body p-2 bg-white">
                            <div class="row g-2">
                `;

                items.forEach(item => {
                    let savedVal = savedResults[item.id_parameter] !== undefined ? savedResults[item.id_parameter] : '';
                    let savedKet = savedKeterangan[item.id_parameter] !== undefined ? savedKeterangan[item.id_parameter] : '';
                    let paramNameLower = item.nama_parameter.toLowerCase();

                    let isOdontogram = paramNameLower.includes('odontogram') || paramNameLower.includes('status gigi');

                    if (isOdontogram) {
                        const teethUpper = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
                        const teethLower = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];

                        let parsedTeeth = {};
                        if (savedVal) {
                            savedVal.split(',').forEach(part => {
                                let pair = part.trim().split(':');
                                if (pair.length === 2) {
                                    parsedTeeth[pair[0].trim()] = pair[1].trim();
                                }
                            });
                        }

                        let buildTeethGrid = (teethArray) => {
                            return teethArray.map(num => {
                                let code = parsedTeeth[num] || '';
                                let activeClass = code ? 'has-code' : '';
                                return `
                                    <div class="tooth-box ${activeClass}" data-tooth="${num}" title="Gigi ${num}">
                                        <div class="tooth-number">${num}</div>
                                        <div class="tooth-code" id="code_tooth_${num}">${code}</div>
                                    </div>
                                `;
                            }).join('');
                        };

                        cardHtml += `
                            <div class="col-12 mb-2 odontogram-wrapper">
                                <label class="param-label fw-bold text-primary">${item.nama_parameter}</label>

                                <div class="p-2 border rounded bg-light mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">RAHANG ATAS</span>
                                        <span class="text-muted" style="font-size: 0.65rem;">Klik nomor gigi untuk isi kode</span>
                                    </div>
                                    <div class="odontogram-grid mb-2">
                                        ${buildTeethGrid(teethUpper)}
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">RAHANG BAWAH</span>
                                    </div>
                                    <div class="odontogram-grid">
                                        ${buildTeethGrid(teethLower)}
                                    </div>
                                </div>

                                <input type="text"
                                       class="form-control param-input input-odontogram-result bg-white"
                                       id="input_odontogram_${item.id_parameter}"
                                       name="results[${item.id_parameter}]"
                                       value="${savedVal}"
                                       placeholder="Kode odontogram terkompilasi..."
                                       readonly>
                            </div>
                        `;
                    } else if (item.input_type === 'select') {
                        let opts = JSON.parse(item.options || '[]');
                        let optHtml = `<option value="">-- Pilih --</option>`;
                        opts.forEach(o => {
                            let selected = savedVal.toUpperCase() == o.toUpperCase() ? 'selected' : '';
                            optHtml += `<option value="${o}" ${selected}>${o.toUpperCase()}</option>`;
                        });

                        let isAbnormal = savedVal && savedVal.toUpperCase() !== 'NORMAL';
                        let displayStyle = isAbnormal ? 'display: block;' : 'display: none;';

                        cardHtml += `
                            <div class="col-6 mb-1">
                                <label class="param-label text-truncate d-block" title="${item.nama_parameter}">${item.nama_parameter}</label>
                                <select class="form-select param-input select-param" name="results[${item.id_parameter}]" data-param-id="${item.id_parameter}">
                                    ${optHtml}
                                </select>
                                <div class="wrapper-keterangan-${item.id_parameter} mt-1" style="${displayStyle}">
                                    <input type="text"
                                           class="form-control input-keterangan"
                                           name="keterangan[${item.id_parameter}]"
                                           placeholder="Ket. Tidak Normal..."
                                           value="${savedKet}">
                                </div>
                            </div>
                        `;
                    } else {
                        cardHtml += `
                            <div class="col-6 mb-1">
                                <label class="param-label text-truncate d-block" title="${item.nama_parameter}">${item.nama_parameter}</label>
                                <input type="text" class="form-control param-input" name="results[${item.id_parameter}]" value="${savedVal}">
                            </div>
                        `;
                    }
                });

                cardHtml += `
                            </div>
                        </div>
                    </div>
                `;

                if (leftCategories.includes(kategori)) {
                    leftHtml += cardHtml;
                } else {
                    rightHtml += cardHtml;
                }
            });

            $('#col_left_parameters').html(leftHtml);
            $('#col_right_parameters').html(rightHtml);
        }

        // Submit Form via AJAX
        $('#formInputFisik').on('submit', function(e) {
            e.preventDefault();

            let btnSave = $('#btnSaveFisik');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

            $.ajax({
                url: "{{ route('pemeriksaan_fisik.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Hasil');
                    if (res.status === 'success') {
                        $('#modalPemeriksaanFisik').modal('hide');
                        loadPesertaFisikData($('#filter_mou').val());
                        alert(res.message);
                    }
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Hasil');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errMsgs = [];
                        $.each(errors, function(key, val) {
                            errMsgs.push(val[0]);
                        });
                        alert('Validasi Gagal:\n' + errMsgs.join('\n'));
                    } else {
                        alert('Gagal menyimpan hasil pemeriksaan fisik.');
                    }
                }
            });
        });
    });
</script>
@endsection
