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

    .bg-light-primary {
        background-color: #cfe2ff;
        color: #084298;
    }

    #modalFisikUmum .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }

    #modalFisikUmum .modal-footer {
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
        <h3 class="fw-bold text-dark mb-1">Laporan Hasil Fisik Umum</h3>
        <p class="text-muted mb-0">Monitoring dan rekapitulasi hasil pemeriksaan fisik umum pasien berdasarkan Perusahaan dan MoU.</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card shadow-sm border-0 mb-3 rounded-3">
    <div class="card-body p-4">
        <h5 class="fw-semibold text-primary mb-3"><i class="fas fa-filter me-2"></i>Filter Data</h5>
        <div class="row g-3">
            <!-- 1. Pilih Perusahaan -->
            <div class="col-md-6">
                <label for="filter_company" class="form-label fw-medium text-secondary">Pilih Perusahaan <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_company" name="master_company_code">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as$company)
                    <option value="{{ $company->master_company_code }}">{{ $company->master_company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Pilih MoU -->
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
    <div class="col-md-6">
        <div class="card card-stat bg-light-primary shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary text-white rounded-3 p-3">
                    <i class="fas fa-notes-medical fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Total Pemeriksaan Fisik</h6>
                    <h3 class="mb-0 fw-bold" id="stat_total">0</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat bg-light-success shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success text-white rounded-3 p-3">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Total Peserta Terdaftar</h6>
                    <h3 class="mb-0 fw-bold text-success" id="stat_peserta">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Table -->
<div id="content_container" class="card shadow-sm border-0 rounded-3 d-none">
    <div class="card-header bg-white border-bottom pt-3 pb-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold text-dark mb-0"><i class="fas fa-list me-2"></i>Daftar Hasil Pemeriksaan Fisik Umum</h5>

        <!-- Tombol Cetak PDF Rekap -->
        <a id="btn_print_rekap" href="#" target="_blank" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-file-pdf me-1"></i> Cetak Rekap PDF
        </a>
    </div>

    <div class="card-body p-4">
        <!-- Filter Tanggal Periksa -->
        <div class="row mb-3 align-items-end">
            <div class="col-md-4">
                <label for="filter_tgl_periksa" class="form-label fw-medium text-secondary fs--1">
                    <i class="fas fa-calendar-alt me-1"></i>Filter Tanggal Periksa
                </label>
                <div class="input-group input-group-sm">
                    <input type="date" id="filter_tgl_periksa" class="form-control">
                    <button class="btn btn-outline-secondary" type="button" id="btn_reset_tgl" title="Reset Tanggal">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="table_hasil_fisik_umum" class="table table-striped table-bordered dt-responsive nowrap align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIP / NIK</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Periksa</th>
                        <th>Pemeriksa / Petugas</th>
                        <th class="text-center">Kondisi Umum</th>
                        <th width="18%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Hasil Fisik Umum -->
<div class="modal fade" id="modalDetailHasil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-file-medical me-2"></i>Detail Hasil Pemeriksaan Fisik Umum</h5>
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

<!-- Modal Form Edit Fisik Umum -->
<div class="modal fade" id="modalFisikUmum" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-edit me-2"></i>Form Edit Hasil Fisik Umum</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formInputFisikUmum" class="d-flex flex-column" style="min-height: 0;">
                @csrf
                <input type="hidden" name="mou_peserta_code" id="modal_peserta_code">

                <div class="modal-body p-4">
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

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user-check me-1"></i>Pemeriksaan Fisik Generalis</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kepala & Leher</label>
                            <input type="text" class="form-control" name="kepala_leher" id="inp_kepala_leher" placeholder="Normal / Kelainan...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mata & Penglihatan</label>
                            <input type="text" class="form-control" name="mata" id="inp_mata" placeholder="Normal / Anemis / Ikterik...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Thoraks / Dada</label>
                            <input type="text" class="form-control" name="thoraks" id="inp_thoraks" placeholder="Simetris, Suara Napas Vesikuler...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Abdomen / Perut</label>
                            <input type="text" class="form-control" name="abdomen" id="inp_abdomen" placeholder="Supel, Bising Usus (+)...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ekstremitas / Anggota Gerak</label>
                            <input type="text" class="form-control" name="ekstremitas" id="inp_ekstremitas" placeholder="Akral Hangat, Edema (-)...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kulit & Integumen</label>
                            <input type="text" class="form-control" name="kulit" id="inp_kulit" placeholder="Normal / Ruam...">
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-clipboard-check me-1"></i>Kesimpulan Fisik Umum</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan Pemeriksaan</label>
                            <textarea class="form-control" name="catatan_fisik" id="inp_catatan_fisik" rows="3" placeholder="Catatan temuan fisik umum..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Kondisi Fisik Umum <span class="text-danger">*</span></label>
                            <select class="form-select" name="kondisi_umum" id="inp_kondisi_umum" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Normal">Normal</option>
                                <option value="Abnormal">Abnormal / Kelainan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold" id="btnSaveFisikUmum">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
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
        let tableDataTables = null;

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
                    url: "{{ route('laporan.fisik_umum.get_mou') }}",
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

        // 2. Filter MoU -> Langsung Load Data Peserta & Stats
        $('#filter_mou').on('change', function() {
            let mouCode = $(this).val();

            if (mouCode) {
                let printRekapUrl = "{{ route('laporan.fisik_umum.print_rekap_pdf') }}" + "?mou_code=" + mouCode;
                $('#btn_print_rekap').attr('href', printRekapUrl);

                loadFisikUmumData(mouCode);
            } else {
                resetTableAndStats();
            }
        });

        // 3. Filter Tanggal Periksa
        $('#filter_tgl_periksa').on('change', function() {
            if (tableDataTables) {
                tableDataTables.ajax.reload();
            }
        });

        $('#btn_reset_tgl').on('click', function() {
            $('#filter_tgl_periksa').val('');
            if (tableDataTables) {
                tableDataTables.ajax.reload();
            }
        });

        function loadFisikUmumData(mouCode) {
            $('#stats_container').removeClass('d-none');
            $('#content_container').removeClass('d-none');

            if ($.fn.DataTable.isDataTable('#table_hasil_fisik_umum')) {
                $('#table_hasil_fisik_umum').DataTable().destroy();
            }

            tableDataTables = $('#table_hasil_fisik_umum').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    search: "Cari Pasien / NIP / NIK:",
                    searchPlaceholder: "Nama Pasien, NIP, NIK...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data fisik umum",
                    infoEmpty: "Tidak ada data pemeriksaan",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Data hasil pemeriksaan fisik tidak ditemukan",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                },
                ajax: {
                    url: "{{ route('laporan.fisik_umum.get_data') }}",
                    type: "GET",
                    data: function(d) {
                        d.mou_code = mouCode;
                        d.tgl_pemeriksaan = $('#filter_tgl_periksa').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nip_nik',
                        name: 'nip_nik'
                    },
                    {
                        data: 'nama_pasien',
                        name: 'nama_pasien',
                        className: 'fw-semibold'
                    },
                    {
                        data: 'tgl_pemeriksaan',
                        name: 'tgl_pemeriksaan'
                    },
                    {
                        data: 'pemeriksa',
                        name: 'pemeriksa'
                    },
                    {
                        data: 'kondisi_umum',
                        name: 'kondisi_umum',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            // Summary Stats
            $.ajax({
                url: "{{ route('laporan.fisik_umum.get_summary_stats') }}",
                type: "GET",
                data: {
                    mou_code: mouCode
                },
                success: function(res) {
                    $('#stat_total').text(res.total);
                    $('#stat_peserta').text(res.total_peserta);
                }
            });
        }

        function resetTableAndStats() {
            $('#stats_container').addClass('d-none');
            $('#content_container').addClass('d-none');
            if ($.fn.DataTable.isDataTable('#table_hasil_fisik_umum')) {
                $('#table_hasil_fisik_umum').DataTable().destroy();
                $('#table_hasil_fisik_umum tbody').empty();
            }
        }

        // View Detail Modal Callback
        $(document).on('click', '.btn-view-detail', function() {
            let pesertaCode = $(this).data('peserta-code');

            $('#modalDetailHasil').modal('show');
            $('#modal_detail_body').html(`
                <div class="text-center my-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: "{{ route('laporan.fisik_umum.get_detail') }}",
                type: "GET",
                data: {
                    peserta_code: pesertaCode
                },
                success: function(response) {
                    $('#modal_detail_body').html(response);
                },
                error: function() {
                    $('#modal_detail_body').html('<div class="alert alert-danger">Gagal memuat detail hasil pemeriksaan fisik umum.</div>');
                }
            });
        });

        // Event Edit diklik
        $(document).on('click', '.btn-edit-fisik-umum', function() {
            let data = $(this).data('json');

            if (!data) return;
            if (typeof data === 'string') data = JSON.parse(data);

            $('#modal_peserta_code').val(data.mou_peserta_code);
            $('#bio_nama').text(data.mou_peserta_name || '-');
            $('#bio_nip').text((data.mou_peserta_nip || '-') + ' / ' + (data.mou_peserta_nik || '-'));
            $('#bio_dept').text(data.mou_peserta_departemen || '-');

            $('#inp_kepala_leher').val(data.kepala_leher);
            $('#inp_mata').val(data.mata);
            $('#inp_thoraks').val(data.thoraks);
            $('#inp_abdomen').val(data.abdomen);
            $('#inp_ekstremitas').val(data.ekstremitas);
            $('#inp_kulit').val(data.kulit);
            $('#inp_catatan_fisik').val(data.catatan_fisik);
            $('#inp_kondisi_umum').val(data.kondisi_umum);

            let $modalDetail = $('#modalDetailHasil');
            if ($modalDetail.hasClass('show')) {
                $modalDetail.one('hidden.bs.modal', function() {
                    $('#modalFisikUmum').modal('show');
                });
                $modalDetail.modal('hide');
            } else {
                $('#modalFisikUmum').modal('show');
            }
        });

        // Submit Form Edit
        $('#formInputFisikUmum').on('submit', function(e) {
            e.preventDefault();

            let btnSave = $('#btnSaveFisikUmum');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            $.ajax({
                url: "{{ route('laporan.fisik_umum.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                    $('#modalFisikUmum').modal('hide');

                    if (tableDataTables) {
                        tableDataTables.ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                    alert('Gagal menyimpan data: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan.'));
                }
            });
        });
    });
</script>
@endsection
