@extends('layouts.template')

@section('base.css')
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
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Laporan Hasil Pemeriksaan Dokter</h3>
        <p class="text-muted mb-0">Monitoring dan rekapitulasi hasil pemeriksaan medis pasien berdasarkan Perusahaan, MoU, dan Dokter Penginput.</p>
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
                <select class="form-select" id="filter_company" name="master_company_code">
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

            <!-- Pilih Dokter (Termasuk Opsi ALL) -->
            <div class="col-md-4">
                <label for="filter_dokter" class="form-label fw-medium text-secondary">Pilih Dokter Penginput <span class="text-danger">*</span></label>
                <select class="form-select" id="filter_dokter" name="dokter_penginput" disabled>
                    <option value="">-- Pilih MoU Terlebih Dahulu --</option>
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
                    <i class="fas fa-stethoscope fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Total Pemeriksaan</h6>
                    <h3 class="mb-0 fw-bold" id="stat_total">0</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat bg-light-success shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success text-white rounded-3 p-3">
                    <i class="fas fa-user-md fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="text-uppercase mb-1 fw-bold fs--1">Dokter Terlibat</h6>
                    <h3 class="mb-0 fw-bold text-success" id="stat_dokter">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Table -->
<div id="content_container" class="card shadow-sm border-0 rounded-3 d-none">
    <div class="card-header bg-white border-bottom pt-3 pb-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold text-dark mb-0"><i class="fas fa-list me-2"></i>Daftar Hasil Pemeriksaan</h5>

        <!-- Tombol Cetak PDF Rekap -->
        <a id="btn_print_rekap" href="#" target="_blank" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-file-pdf me-1"></i> Cetak Rekap PDF
        </a>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="table_hasil_pemeriksaan" class="table table-striped table-bordered align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>NIP / NIK</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Periksa</th>
                        <th>Dokter Penginput</th>
                        <th class="text-center">Kesimpulan</th>
                        <th width="18%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Processed via AJAX Native -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Hasil Pemeriksaan -->
<div class="modal fade" id="modalDetailHasil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-file-medical me-2"></i>Detail Hasil Pemeriksaan Dokter</h5>
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
        let dokterChoices = new Choices('#filter_dokter', {
            searchEnabled: true,
            itemSelectText: ''
        });

        // 1. Filter Perusahaan -> Load MoU
        $('#filter_company').on('change', function() {
            let companyCode = $(this).val();

            mouChoices.clearStore();
            mouChoices.clearChoices();
            mouChoices.disable();

            dokterChoices.clearStore();
            dokterChoices.clearChoices();
            dokterChoices.disable();

            resetTableAndStats();

            if (companyCode) {
                $.ajax({
                    url: "{{ route('laporan.pemeriksaan.get_mou') }}",
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

        // 2. Filter MoU -> Load Dokter Penginput (Termasuk Opsi ALL)
        $('#filter_mou').on('change', function() {
            let mouCode = $(this).val();

            dokterChoices.clearStore();
            dokterChoices.clearChoices();
            dokterChoices.disable();
            resetTableAndStats();

            if (mouCode) {
                $.ajax({
                    url: "{{ route('laporan.pemeriksaan.get_dokter') }}",
                    type: 'GET',
                    data: {
                        mou_code: mouCode
                    },
                    success: function(response) {
                        let choicesData = [{
                                value: '',
                                label: '-- Pilih Dokter --',
                                selected: true,
                                disabled: true
                            },
                            {
                                value: 'all',
                                label: '-- Semua Dokter (ALL) --'
                            }
                        ];
                        $.each(response, function(index, item) {
                            choicesData.push({
                                value: item.dokter_penginput,
                                label: item.dokter_penginput
                            });
                        });
                        dokterChoices.setChoices(choicesData, 'value', 'label', true);
                        dokterChoices.enable();
                    }
                });
            }
        });

        // 3. Filter Dokter -> Load Data & Set Print URL
        $('#filter_dokter').on('change', function() {
            let dokterPenginput = $(this).val();
            let mouCode = $('#filter_mou').val();

            if (dokterPenginput && mouCode) {
                // Set Link URL Cetak Rekap PDF
                let printRekapUrl = "{{ route('laporan.pemeriksaan.print_rekap_pdf') }}" + "?mou_code=" + mouCode + "&dokter_penginput=" + dokterPenginput;
                $('#btn_print_rekap').attr('href', printRekapUrl);

                loadPemeriksaanData(mouCode, dokterPenginput);
            } else {
                resetTableAndStats();
            }
        });

        function loadPemeriksaanData(mouCode, dokterPenginput) {
            $('#stats_container').removeClass('d-none');
            $('#content_container').removeClass('d-none');

            let tableBody = $('#table_hasil_pemeriksaan tbody');
            tableBody.html(`
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>
            `);

            // Fetch Table Data via Native AJAX
            $.ajax({
                url: "{{ route('laporan.pemeriksaan.get_data') }}",
                type: "GET",
                data: {
                    mou_code: mouCode,
                    dokter_penginput: dokterPenginput
                },
                success: function(response) {
                    tableBody.empty();

                    if (!response.data || response.data.length === 0) {
                        tableBody.html(`
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Tidak ada data pemeriksaan ditemukan.</td>
                            </tr>
                        `);
                        return;
                    }

                    $.each(response.data, function(index, item) {
                        tableBody.append(`
                            <tr>
                                <td class="text-center">${item.no}</td>
                                <td>${item.nip_nik}</td>
                                <td>${item.nama_pasien}</td>
                                <td>${item.tgl_pemeriksaan}</td>
                                <td>${item.dokter_penginput}</td>
                                <td class="text-center">${item.kesimpulan}</td>
                                <td class="text-center">${item.action}</td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    tableBody.html(`
                        <tr>
                            <td colspan="7" class="text-center text-danger py-3">Gagal mengambil data pemeriksaan.</td>
                        </tr>
                    `);
                }
            });

            // Fetch Stats Summary
            $.ajax({
                url: "{{ route('laporan.pemeriksaan.get_summary_stats') }}",
                type: "GET",
                data: {
                    mou_code: mouCode,
                    dokter_penginput: dokterPenginput
                },
                success: function(res) {
                    $('#stat_total').text(res.total);
                    $('#stat_dokter').text(res.total_dokter);
                }
            });
        }

        function resetTableAndStats() {
            $('#stats_container').addClass('d-none');
            $('#content_container').addClass('d-none');
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
                url: "{{ route('laporan.pemeriksaan.get_detail') }}",
                type: "GET",
                data: {
                    peserta_code: pesertaCode
                },
                success: function(response) {
                    $('#modal_detail_body').html(response);
                },
                error: function() {
                    $('#modal_detail_body').html('<div class="alert alert-danger">Gagal memuat detail hasil pemeriksaan dokter.</div>');
                }
            });
        });
    });
</script>
@endsection
