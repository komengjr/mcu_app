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
                    @foreach($companies as$company)
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
        <!-- Filter Spesifik DataTables: Filter Tanggal Periksa -->
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
            <table id="table_hasil_pemeriksaan" class="table table-striped table-bordered dt-responsive nowrap align-middle w-100">
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
                <tbody></tbody>
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

<!-- Modal Form Input/Edit Pemeriksaan -->
<div class="modal fade" id="modalPemeriksaan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-user-md me-2"></i>Form Edit Pemeriksaan Fisik & Vital Sign</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formInputPemeriksaan" class="d-flex flex-column" style="min-height: 0;">
                @csrf
                <input type="hidden" name="mou_peserta_code" id="modal_peserta_code">

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
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-semibold">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" name="tinggi_badan" id="inp_tinggi" placeholder="170" required>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-semibold">Berat Badan (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" name="berat_badan" id="inp_berat" placeholder="65.5" required>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-semibold">Tekanan Darah (mmHg) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tensi" id="inp_tensi" placeholder="120/80" required>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-semibold">Denyut Nadi (x/m)</label>
                            <input type="number" class="form-control" name="nadi" id="inp_nadi" placeholder="80">
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="form-label fw-semibold">Laju Pernapasan (x/m)</label>
                            <input type="number" class="form-control" name="respirasi" id="inp_respirasi" placeholder="18">
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="form-label fw-semibold">Suhu Tubuh (°C)</label>
                            <input type="number" step="0.1" class="form-control" name="suhu" id="inp_suhu" placeholder="36.5">
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="form-label fw-semibold">SpO2 (%)</label>
                            <input type="number" min="0" max="100" class="form-control" name="spo2" id="inp_spo2" placeholder="98">
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

                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold" id="btnSavePemeriksaan">
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
                let printRekapUrl = "{{ route('laporan.pemeriksaan.print_rekap_pdf') }}" + "?mou_code=" + mouCode + "&dokter_penginput=" + dokterPenginput;
                $('#btn_print_rekap').attr('href', printRekapUrl);

                loadPemeriksaanData(mouCode, dokterPenginput);
            } else {
                resetTableAndStats();
            }
        });

        // 4. Filter Tambahan Tanggal Periksa
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

        function loadPemeriksaanData(mouCode, dokterPenginput) {
            $('#stats_container').removeClass('d-none');
            $('#content_container').removeClass('d-none');

            if ($.fn.DataTable.isDataTable('#table_hasil_pemeriksaan')) {
                $('#table_hasil_pemeriksaan').DataTable().destroy();
            }

            tableDataTables = $('#table_hasil_pemeriksaan').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    search: "Cari Pasien / NIP / NIK:",
                    searchPlaceholder: "Nama Pasien, NIP, NIK...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pemeriksaan",
                    infoEmpty: "Tidak ada data pemeriksaan",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Data hasil pemeriksaan tidak ditemukan",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                },
                ajax: {
                    url: "{{ route('laporan.pemeriksaan.get_data') }}",
                    type: "GET",
                    data: function(d) {
                        d.mou_code = mouCode;
                        d.dokter_penginput = dokterPenginput;
                        d.tgl_pemeriksaan = $('#filter_tgl_periksa').val(); // Kirim filter tanggal ke backend
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
                        data: 'dokter_penginput',
                        name: 'dokter_penginput'
                    },
                    {
                        data: 'kesimpulan',
                        name: 'kesimpulan',
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
            if ($.fn.DataTable.isDataTable('#table_hasil_pemeriksaan')) {
                $('#table_hasil_pemeriksaan').DataTable().destroy();
                $('#table_hasil_pemeriksaan tbody').empty();
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

        // Event Transisi saat Tombol Edit diklik di dalam Modal Detail
        $(document).on('click', '.btn-edit-pemeriksaan', function() {
            let data = $(this).data('json');

            if (!data) {
                console.error('Data JSON tidak ditemukan pada tombol!');
                return;
            }

            if (typeof data === 'string') {
                data = JSON.parse(data);
            }

            // Populate data ke form modal
            $('#modal_peserta_code').val(data.mou_peserta_code);
            $('#bio_nama').text(data.mou_peserta_name || '-');
            $('#bio_nip').text((data.mou_peserta_nip || '-') + ' / ' + (data.mou_peserta_nik || '-'));
            $('#bio_dept').text(data.mou_peserta_departemen || '-');

            $('#inp_tinggi').val(data.tinggi_badan);
            $('#inp_berat').val(data.berat_badan);
            $('#inp_tensi').val(data.tensi);
            $('#inp_nadi').val(data.nadi_hr);
            $('#inp_respirasi').val(data.rr_nafas);
            $('#inp_suhu').val(data.suhu);
            $('#inp_spo2').val(data.spo2);
            $('#inp_catatan').val(data.catatan_dokter);
            $('#inp_kesimpulan').val(data.kesimpulan);

            // Penanganan Penutupan Modal Detail sebelum Buka Modal Edit Form
            let $modalDetail = $('#modalDetailHasil');

            if ($modalDetail.hasClass('show')) {
                $modalDetail.one('hidden.bs.modal', function() {
                    $('#modalPemeriksaan').modal('show');
                });
                $modalDetail.modal('hide');
            } else {
                $('#modalPemeriksaan').modal('show');
            }
        });

        // Handling Submit Form Edit / Simpan Data
        $('#formInputPemeriksaan').on('submit', function(e) {
            e.preventDefault();

            let btnSave = $('#btnSavePemeriksaan');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            $.ajax({
                url: "{{ route('laporan.pemeriksaan.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                    $('#modalPemeriksaan').modal('hide');

                    // Reload DataTables tanpa reset pagination
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
