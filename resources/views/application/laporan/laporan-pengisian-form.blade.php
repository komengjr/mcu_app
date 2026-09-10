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

    .bg-light-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .bg-light-danger {
        background-color: #f8d7da;
        color: #842029;
    }

    .bg-light-primary {
        background-color: #cfe2ff;
        color: #084298;
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Laporan Pengisian Formulir</h3>
        <p class="text-muted mb-0">Monitoring status pengisian formulir peserta berdasarkan Perusahaan dan MoU.</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card shadow-sm border-0 mb-3 rounded-3">
    <div class="card-body p-4">
        <h5 class="fw-semibold text-primary mb-3"><i class="fas fa-filter me-2"></i>Filter Data</h5>
        <div class="row g-3">
            <!-- Pilih Perusahaan -->
            <div class="col-md-4">
                <label for="filter_company" class="form-label fw-medium text-secondary">Pilih Perusahaan <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_company" name="company_code">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->master_company_code }}">{{ $company->master_company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih MoU -->
            <div class="col-md-4">
                <label for="filter_mou" class="form-label fw-medium text-secondary">Pilih MoU <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_mou" name="company_mou_code" disabled>
                    <option value="">-- Pilih Perusahaan Terlebih Dahulu --</option>
                </select>
            </div>

            <!-- Pilih Form -->
            <div class="col-md-4">
                <label for="filter_form" class="form-label fw-medium text-secondary">Pilih Formulir MCU <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_form" name="form_code" disabled>
                    <option value="">-- Pilih MoU Terlebih Dahulu --</option>
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
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Sudah Mengisi Form</h6>
                    <h3 class="mb-0 fw-bold text-success" id="stat_sudah">0</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-light-danger shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-danger text-white rounded-3 p-3">
                    <i class="fas fa-user-times fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Belum Mengisi Form</h6>
                    <h3 class="mb-0 fw-bold text-danger" id="stat_belum">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Tables -->
<div id="content_container" class="card shadow-sm border-0 rounded-3 d-none">
    <div class="card-header bg-white border-bottom pt-3 pb-3">
        <!-- Pilihan Tampilan Menggunakan Button Group -->
        <div class="btn-group" role="group" aria-label="Status Pengisian Form">
            <button type="button" class="btn btn-outline-success active fw-bold" id="btn-sudah">
                <i class="fas fa-check-circle me-1"></i> Sudah Mengisi Form (<span id="badge_count_sudah">0</span>)
            </button>
            <button type="button" class="btn btn-outline-danger fw-bold" id="btn-belum">
                <i class="fas fa-exclamation-circle me-1"></i> Belum Mengisi Form (<span id="badge_count_belum">0</span>)
            </button>
        </div>
    </div>

    <div class="card-body p-4">
        <!-- TABLE 1: SUDAH MENGISI -->
        <div id="container-table-sudah">
            <div class="table-responsive">
                <table id="table_sudah_isi" class="table table-striped table-bordered dt-responsive nowrap w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>NIP / NIK</th>
                            <th>Nama Peserta</th>
                            <th>Departemen</th>
                            <th>Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- TABLE 2: BELUM MENGISI -->
        <div id="container-table-belum" class="d-none">
            <div class="table-responsive">
                <table id="table_belum_isi" class="table table-striped table-bordered dt-responsive nowrap w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>NIP / NIK</th>
                            <th>Nama Peserta</th>
                            <th>Departemen</th>
                            <th>No HP / Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Jawaban Form -->
<div class="modal fade" id="modalDetailHasil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-file-alt me-2"></i>Detail Hasil Pengisian Formulir</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal_detail_body">
                <div class="text-center my-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
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
        let formChoices = new Choices('#filter_form', {
            searchEnabled: true,
            itemSelectText: ''
        });

        // Toggle Switcher Button
        $('#btn-sudah').on('click', function() {
            $(this).addClass('active').removeClass('btn-outline-success').addClass('btn-success');
            $('#btn-belum').removeClass('active').removeClass('btn-danger').addClass('btn-outline-danger');

            $('#container-table-sudah').removeClass('d-none');
            $('#container-table-belum').addClass('d-none');

            // Adjust DataTables responsiveness when showing hidden tables
            if ($.fn.DataTable.isDataTable('#table_sudah_isi')) {
                $('#table_sudah_isi').DataTable().columns.adjust().responsive.recalc();
            }
        });

        $('#btn-belum').on('click', function() {
            $(this).addClass('active').removeClass('btn-outline-danger').addClass('btn-danger');
            $('#btn-sudah').removeClass('active').removeClass('btn-success').addClass('btn-outline-success');

            $('#container-table-belum').removeClass('d-none');
            $('#container-table-sudah').addClass('d-none');

            // Adjust DataTables responsiveness when showing hidden tables
            if ($.fn.DataTable.isDataTable('#table_belum_isi')) {
                $('#table_belum_isi').DataTable().columns.adjust().responsive.recalc();
            }
        });

        // 1. Filter Perusahaan -> Load MoU
        $('#filter_company').on('change', function() {
            let companyCode = $(this).val();

            mouChoices.clearStore();
            mouChoices.clearChoices();
            mouChoices.disable();
            formChoices.clearStore();
            formChoices.clearChoices();
            formChoices.disable();
            resetTableAndStats();

            if (companyCode) {
                $.ajax({
                    url: "{{ route('laporan.get_mou') }}",
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

        // 2. Filter MoU -> Load Forms
        $('#filter_mou').on('change', function() {
            let mouCode = $(this).val();

            formChoices.clearStore();
            formChoices.clearChoices();
            formChoices.disable();
            resetTableAndStats();

            if (mouCode) {
                $.ajax({
                    url: "{{ route('laporan.get_forms') }}",
                    type: 'GET',
                    data: {
                        mou_code: mouCode
                    },
                    success: function(response) {
                        let choicesData = [{
                            value: '',
                            label: '-- Pilih Form --',
                            selected: true,
                            disabled: true
                        }];
                        $.each(response, function(index, item) {
                            choicesData.push({
                                value: item.form_code,
                                label: item.form_name
                            });
                        });
                        formChoices.setChoices(choicesData, 'value', 'label', true);
                        formChoices.enable();
                    }
                });
            }
        });

        // 3. Filter Form -> Load Datatable & Stats
        $('#filter_form').on('change', function() {
            let formCode = $(this).val();
            let mouCode = $('#filter_mou').val();

            if (formCode && mouCode) {
                loadMonitoringData(mouCode, formCode);
            } else {
                resetTableAndStats();
            }
        });

        function loadMonitoringData(mouCode, formCode) {
            $('#stats_container').removeClass('d-none');
            $('#content_container').removeClass('d-none');

            if ($.fn.DataTable.isDataTable('#table_sudah_isi')) $('#table_sudah_isi').DataTable().destroy();
            if ($.fn.DataTable.isDataTable('#table_belum_isi')) $('#table_belum_isi').DataTable().destroy();

            // Table Sudah Mengisi
            $('#table_sudah_isi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.get_participants') }}",
                    type: "GET",
                    data: {
                        mou_code: mouCode,
                        form_code: formCode,
                        is_completed: 1
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

            // Table Belum Mengisi
            $('#table_belum_isi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.get_participants') }}",
                    type: "GET",
                    data: {
                        mou_code: mouCode,
                        form_code: formCode,
                        is_completed: 0
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
                        data: 'kontak',
                        name: 'kontak'
                    },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Stats Summary
            $.ajax({
                url: "{{ route('laporan.get_summary_stats') }}",
                type: "GET",
                data: {
                    mou_code: mouCode,
                    form_code: formCode
                },
                success: function(res) {
                    $('#stat_total').text(res.total);
                    $('#stat_sudah').text(res.sudah);
                    $('#stat_belum').text(res.belum);
                    $('#badge_count_sudah').text(res.sudah);
                    $('#badge_count_belum').text(res.belum);
                }
            });
        }

        function resetTableAndStats() {
            $('#stats_container').addClass('d-none');
            $('#content_container').addClass('d-none');
        }

        // View Detail Form Peserta Modal
        $(document).on('click', '.btn-view-detail', function() {
            let pesertaCode = $(this).data('peserta-code');
            let formCode = $('#filter_form').val();

            $('#modalDetailHasil').modal('show');
            $('#modal_detail_body').html(`
            <div class="text-center my-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

            $.ajax({
                url: "{{ route('laporan.get_participant_detail') }}",
                type: "GET",
                data: {
                    peserta_code: pesertaCode,
                    form_code: formCode
                },
                success: function(response) {
                    $('#modal_detail_body').html(response);
                },
                error: function() {
                    $('#modal_detail_body').html('<div class="alert alert-danger">Gagal memuat detail jawaban form peserta.</div>');
                }
            });
        });
    });
</script>
@endsection
