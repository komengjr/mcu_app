@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
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

    /* Penyesuaian Scroll Modal */
    #modalPemeriksaan .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }

    #modalPemeriksaan .modal-footer {
        position: sticky;
        bottom: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Pemeriksaan Dokter & Vital Sign</h3>
        <p class="text-muted mb-0">Monitoring dan input hasil pemeriksaan fisik serta tanda vital peserta MCU.</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card shadow-sm border-0 mb-3 rounded-3">
    <div class="card-body p-4">
        <h5 class="fw-semibold text-primary mb-3"><i class="fas fa-filter me-2"></i>Filter Data Peserta</h5>
        <div class="row g-3">
            <!-- Pilih Perusahaan -->
            <div class="col-md-6">
                <label for="filter_company" class="form-label fw-medium text-secondary">Pilih Perusahaan <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_company" name="company_code">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->master_company_code }}">{{ $company->master_company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih MoU -->
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
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Sudah Diperiksa</h6>
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
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Belum Diperiksa</h6>
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
            <table id="table_peserta" class="table table-striped table-bordered dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>NIP / NIK</th>
                        <th>Nama Peserta</th>
                        <th>Departemen</th>
                        <th>Status Periksa</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Input Pemeriksaan -->
<div class="modal fade" id="modalPemeriksaan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-user-md me-2"></i>Form Pemeriksaan Fisik & Vital Sign</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formInputPemeriksaan" class="d-flex flex-column" style="min-height: 0;">
                @csrf
                <input type="hidden" name="mou_peserta_code" id="modal_peserta_code">

                <!-- Modal Body dengan Scroll -->
                <div class="modal-body p-4">
                    <!-- Bio Peserta -->
                    <div class="alert alert-primary bg-light-primary border-primary rounded-3 mb-3 p-3">
                        <div class="row text-dark">
                            <div class="col-md-6">
                                <strong>Nama:</strong> <span id="bio_nama">-</span><br>
                                <strong>NIP / NIK:</strong> <span id="bio_nip">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Departemen:</strong> <span id="bio_dept">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Input Vital Sign -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-heartbeat me-1"></i>Tanda-Tanda Vital</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" name="tinggi_badan" id="inp_tinggi" placeholder="misal: 170" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Berat Badan (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" name="berat_badan" id="inp_berat" placeholder="misal: 65.5" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tekanan Darah (mmHg) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tensi" id="inp_tensi" placeholder="Contoh: 120/80" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Denyut Nadi (x/menit)</label>
                            <input type="number" class="form-control" name="nadi" id="inp_nadi" placeholder="80">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Laju Pernapasan (x/menit)</label>
                            <input type="number" class="form-control" name="respirasi" id="inp_respirasi" placeholder="18">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Suhu Tubuh (°C)</label>
                            <input type="number" step="0.1" class="form-control" name="suhu" id="inp_suhu" placeholder="36.5">
                        </div>
                    </div>

                    <!-- Input Dokter -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-stethoscope me-1"></i>Catatan & Kesimpulan Medis</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan Fisik Tambahan</label>
                            <textarea class="form-control" name="catatan_dokter" id="inp_catatan" rows="3" placeholder="Catatan kelainan / temuan fisik..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Kesimpulan Medis <span class="text-danger">*</span></label>
                            <select class="form-select" name="kesimpulan" id="inp_kesimpulan" required>
                                <option value="">-- Pilih Kesimpulan --</option>
                                <option value="Fit">Fit (Sehat / Laik Kerja)</option>
                                <option value="Fit with Note">Fit with Note (Laik Kerja dengan Catatan)</option>
                                <option value="Temporary Unfit">Temporary Unfit (Tidak Laik Sementara)</option>
                                <option value="Unfit">Unfit (Tidak Laik Kerja)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer Permanen / Sticky di Bawah -->
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold" id="btnSavePemeriksaan">
                        <i class="fas fa-save me-1"></i> Simpan Pemeriksaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

<script>
    $(document).ready(function() {
        let companyChoices = new Choices('#filter_company', {
            searchEnabled: true,
            itemSelectText: ''
        });
        let mouChoices = new Choices('#filter_mou', {
            searchEnabled: true,
            itemSelectText: ''
        });

        // 1. Filter Perusahaan -> Load MoU
        $('#filter_company').on('change', function() {
            let companyCode = $(this).val();

            mouChoices.clearStore();
            mouChoices.clearChoices();
            mouChoices.disable();
            resetTableAndStats();

            if (companyCode) {
                $.ajax({
                    url: "{{ route('pemeriksaan.get_mou') }}",
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

        // 2. Filter MoU -> Load Table & Stats Peserta
        $('#filter_mou').on('change', function() {
            let mouCode = $(this).val();

            if (mouCode) {
                loadPesertaData(mouCode);
            } else {
                resetTableAndStats();
            }
        });

        function loadPesertaData(mouCode) {
            $('#stats_container').removeClass('d-none');
            $('#content_container').removeClass('d-none');

            if ($.fn.DataTable.isDataTable('#table_peserta')) {
                $('#table_peserta').DataTable().destroy();
            }

            $('#table_peserta').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pemeriksaan.get_participants') }}",
                    type: "GET",
                    data: {
                        mou_code: mouCode
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nip_nik',
                        name: 'nip_nik'
                    },
                    {
                        data: 'mou_peserta_name',
                        name: 'mou_peserta_name'
                    },
                    {
                        data: 'mou_peserta_departemen',
                        name: 'mou_peserta_departemen'
                    },
                    {
                        data: 'dokter_penginput', // Kolom Dokter Penginput
                        name: 'dokter_penginput',
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            return data && data !== '-' ?
                                `<span class="fw-semibold text-dark"><i class="fas fa-user-md me-1 text-primary"></i>${data}</span>` :
                                '<span class="text-muted fs-7">-</span>';
                        }
                    },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Summary Stats
            $.ajax({
                url: "{{ route('pemeriksaan.get_summary_stats') }}",
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
            $('#stats_container').addClass('d-none');
            $('#content_container').addClass('d-none');
        }

        // 3. Open Modal & Load Existing Data
        $(document).on('click', '.btn-input-pemeriksaan', function() {
            let pesertaCode = $(this).data('peserta-code');
            $('#formInputPemeriksaan')[0].reset();
            $('#modal_peserta_code').val(pesertaCode);

            $.ajax({
                url: "{{ route('pemeriksaan.get_detail') }}",
                type: "GET",
                data: {
                    peserta_code: pesertaCode
                },
                success: function(res) {
                    $('#bio_nama').text(res.peserta.mou_peserta_name);
                    $('#bio_nip').text((res.peserta.mou_peserta_nip ?? '-') + ' / ' + (res.peserta.mou_peserta_nik ?? '-'));
                    $('#bio_dept').text(res.peserta.mou_peserta_departemen ?? '-');

                    if (res.pemeriksaan) {
                        $('#inp_tinggi').val(res.pemeriksaan.tinggi_badan);
                        $('#inp_berat').val(res.pemeriksaan.berat_badan);
                        $('#inp_tensi').val(res.pemeriksaan.tensi ?? res.pemeriksaan.tekanan_darah);
                        $('#inp_nadi').val(res.pemeriksaan.nadi ?? res.pemeriksaan.nadi_hr);
                        $('#inp_respirasi').val(res.pemeriksaan.respirasi ?? res.pemeriksaan.rr_nafas);
                        $('#inp_suhu').val(res.pemeriksaan.suhu);
                        $('#inp_catatan').val(res.pemeriksaan.catatan_dokter);
                        $('#inp_kesimpulan').val(res.pemeriksaan.kesimpulan);
                    }

                    $('#modalPemeriksaan').modal('show');
                }
            });
        });

        // 4. Save Form via AJAX
        $('#formInputPemeriksaan').on('submit', function(e) {
            e.preventDefault();

            let btnSave = $('#btnSavePemeriksaan');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');

            $.ajax({
                url: "{{ route('pemeriksaan.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Pemeriksaan');
                    if (res.status === 'success') {
                        $('#modalPemeriksaan').modal('hide');
                        $('#table_peserta').DataTable().ajax.reload(null, false);
                        loadPesertaData($('#filter_mou').val());
                        alert(res.message);
                    }
                },
                error: function(err) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Pemeriksaan');
                    alert('Gagal menyimpan data pemeriksaan.');
                }
            });
        });
    });
</script>
@endsection
