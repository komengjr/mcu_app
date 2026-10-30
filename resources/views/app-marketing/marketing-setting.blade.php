@extends('layouts.marketing')

@section('content')


<!-- Header Dashboard -->
<div class="d-sm-flex align-items-center justify-content-between bg-white p-3 p-md-4 shadow-sm rounded mb-3" style="border-left: 4px solid #4e73df;">
    <div class="mb-3 mb-sm-0">
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
            <i class="fas fa-sliders-h text-primary me-2"></i>Setting Indikator Penilaian Marketing
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small bg-transparent p-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Marketing</a></li>
                <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Marketing Setting</li>
            </ol>
        </nav>
    </div>
</div>

<div id="alertContainer"></div>

<div class="row g-3">
    <!-- Sidebar Tab Jabatan -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white font-weight-bold">
                <i class="fas fa-user-tag me-1"></i> Pilih Jabatan
            </div>
            <div class="list-group list-group-flush" id="jabatanTab" role="tablist">
                @foreach($jabatans as $index =>$jabatan)
                @php
                $slug = Str::slug($jabatan);$kpiList = $kpiGrouped->get($jabatan, collect());
                $totalBobot =$kpiList->where('status', 'Aktif')->sum('bobot_persen');
                @endphp
                <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $index === 0 ? 'active' : '' }}"
                    id="tab-{{ $slug }}"
                    data-bs-toggle="list"
                    href="#pane-{{ $slug }}"
                    role="tab">
                    <span><i class="fas fa-briefcase me-2 small"></i>{{ $jabatan }}</span>
                    <span class="badge {{ $totalBobot == 100 ? 'bg-success' : ($totalBobot > 100 ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill" title="Total Bobot KPI">
                        {{ $totalBobot }}%
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Content Area Per Jabatan -->
    <div class="col-lg-9">
        <div class="tab-content" id="jabatanTabContent">
            @foreach($jabatans as $index =>$jabatan)
            @php
            $slug = Str::slug($jabatan);$kpiList = $kpiGrouped->get($jabatan, collect());
            $totalBobot =$kpiList->where('status', 'Aktif')->sum('bobot_persen');
            @endphp
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="pane-{{ $slug }}" role="tabpanel">
                <div class="card shadow mb-4 border-left-primary">
                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold text-primary">Indikator KPI: {{ $jabatan }}</h6>
                            <small class="text-muted">Kelola poin penilaian otomatis & manual untuk skema insentif/evaluasi.</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary shadow-sm btn-tambah-kpi" data-jabatan="{{ $jabatan }}">
                            <i class="fas fa-plus me-1"></i> Tambah Poin Penilaian
                        </button>
                    </div>
                    <div class="card-body">

                        <!-- Status Total Bobot -->
                        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>Status Akumulasi Bobot:</strong>
                                @if($totalBobot == 100)
                                <span class="text-success font-weight-bold"><i class="fas fa-check-circle me-1"></i> Sempurna (100%)</span>
                                @elseif($totalBobot > 100)
                                <span class="text-danger font-weight-bold"><i class="fas fa-exclamation-triangle me-1"></i> Melebihi 100% (Total: {{ $totalBobot }}%)</span>
                                @else
                                <span class="text-warning text-dark font-weight-bold"><i class="fas fa-info-circle me-1"></i> Belum Mencapai 100% (Total: {{ $totalBobot }}%)</span>
                                @endif
                            </div>
                            <div class="progress w-25" style="height: 12px;">
                                <div class="progress-bar {{ $totalBobot == 100 ? 'bg-success' : ($totalBobot > 100 ? 'bg-danger' : 'bg-warning') }}" role="progressbar" style="width: {{ min($totalBobot, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Daftar Indikator -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Indikator Penilaian</th>
                                        <th>Tipe Kalkulasi</th>
                                        <th>Target & Satuan</th>
                                        <th class="text-center">Bobot</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-{{ $slug }}">
                                    @forelse($kpiList as$kpi)
                                    <tr id="row-kpi-{{ $kpi->id }}">
                                        <td>
                                            <strong class="text-dark">{{ $kpi->nama_indikator }}</strong>
                                            @if($kpi->deskripsi)
                                            <br><small class="text-muted">{{ $kpi->deskripsi }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($kpi->tipe_penilaian === 'Otomatis')
                                            <span class="badge bg-info text-dark"><i class="fas fa-robot me-1"></i> Otomatis</span>
                                            <br><small class="text-muted">Sumber: {{ str_replace('_', ' ', $kpi->sumber_data_otomatis) }}</small>
                                            @else
                                            <span class="badge bg-secondary"><i class="fas fa-keyboard me-1"></i> Input Manual</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ number_format($kpi->target_standar, 0, ',', '.') }}</strong> {{$kpi->satuan }}
                                        </td>
                                        <td class="text-center font-weight-bold text-primary">
                                            {{ $kpi->bobot_persen }}%
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $kpi->status === 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $kpi->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-warning btn-edit-kpi"
                                                data-json="{{ json_encode($kpi) }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-kpi"
                                                data-id="{{ $kpi->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                            Belum ada indikator penilaian untuk jabatan ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<!-- Modal Form Tambah/Edit KPI -->
<div class="modal fade" id="modalKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formKpi">
                @csrf
                <input type="hidden" name="id" id="kpiId">
                <input type="hidden" name="jabatan" id="kpiJabatan">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="modalKpiTitle">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Indikator Penilaian
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalErrorAlert" class="alert alert-danger d-none">
                        <ul class="mb-0" id="errorList"></ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Jabatan Target</label>
                        <input type="text" id="displayJabatan" class="form-control bg-light" readonly>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label font-weight-bold">Nama Indikator / Poin Penilaian <span class="text-danger">*</span></label>
                            <input type="text" name="nama_indikator" id="nama_indikator" class="form-control" placeholder="Contoh: Jumlah Kunjungan Dokter / Capaian Omset Mitra" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Tipe Penilaian <span class="text-danger">*</span></label>
                            <select name="tipe_penilaian" id="tipe_penilaian" class="form-select" required>
                                <option value="Manual">Manual (Dikelola Supervisor/Admin)</option>
                                <option value="Otomatis">Otomatis (Hitung dari Sistem)</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="boxSumberOtomatis" style="display: none;">
                            <label class="form-label font-weight-bold">Sumber Data Otomatis <span class="text-danger">*</span></label>
                            <select name="sumber_data_otomatis" id="sumber_data_otomatis" class="form-select">
                                <option value="pencapaian_omset">Total Omset Penjualan (Rp)</option>
                                <option value="jumlah_kunjungan">Jumlah Kunjungan / Field Visit</option>
                                <option value="jumlah_klien_baru">Jumlah Akuisisi Klien Baru</option>
                                <option value="persentase_target">Persentase Capaian Target Omset (%)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Target Standar <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="target_standar" id="target_standar" class="form-control" placeholder="100" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Satuan Target <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Contoh: Kunjungan, Dokter, Rupiah, %" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Bobot Penilaian (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="bobot_persen" id="bobot_persen" class="form-control" placeholder="Contoh: 20" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label font-weight-bold">Deskripsi / Petunjuk Pengisian</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2" placeholder="Detail keterangan cara penilaian..."></textarea>
                        </div>

                        <div class="col-md-12" id="boxStatus" style="display: none;">
                            <label class="form-label font-weight-bold">Status Indikator</label>
                            <select name="status" id="status" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanKpi" class="btn btn-primary px-4">Simpan Indikator</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    $(document).ready(function() {

        // Toggle Sumber Data Otomatis
        $('#tipe_penilaian').on('change', function() {
            if ($(this).val() === 'Otomatis') {
                $('#boxSumberOtomatis').slideDown(200);
            } else {
                $('#boxSumberOtomatis').slideUp(200);
            }
        });

        // Buka Modal Tambah KPI
        $(document).on('click', '.btn-tambah-kpi', function() {
            let jabatan = $(this).data('jabatan');
            $('#formKpi')[0].reset();
            $('#kpiId').val('');
            $('#kpiJabatan').val(jabatan);
            $('#displayJabatan').val(jabatan);
            $('#boxSumberOtomatis').hide();
            $('#boxStatus').hide();
            $('#modalKpiTitle').html('<i class="fas fa-plus-circle me-1"></i> Tambah Indikator Penilaian');
            $('#modalErrorAlert').addClass('d-none');
            $('#modalKpi').modal('show');
        });

        // Buka Modal Edit KPI
        $(document).on('click', '.btn-edit-kpi', function() {
            let data = $(this).data('json');
            $('#kpiId').val(data.id);
            $('#kpiJabatan').val(data.jabatan);
            $('#displayJabatan').val(data.jabatan);
            $('#nama_indikator').val(data.nama_indikator);
            $('#tipe_penilaian').val(data.tipe_penilaian);

            if (data.tipe_penilaian === 'Otomatis') {
                $('#sumber_data_otomatis').val(data.sumber_data_otomatis);
                $('#boxSumberOtomatis').show();
            } else {
                $('#boxSumberOtomatis').hide();
            }

            $('#target_standar').val(data.target_standar);
            $('#satuan').val(data.satuan);
            $('#bobot_persen').val(data.bobot_persen);
            $('#deskripsi').val(data.deskripsi);
            $('#status').val(data.status);
            $('#boxStatus').show();

            $('#modalKpiTitle').html('<i class="fas fa-edit me-1"></i> Edit Indikator Penilaian');
            $('#modalErrorAlert').addClass('d-none');
            $('#modalKpi').modal('show');
        });

        // Submit Form Tambah / Edit
        $('#formKpi').on('submit', function(e) {
            e.preventDefault();
            let isEdit = $('#kpiId').val() !== '';
            let url = isEdit ? "{{ route('marketing_setting.kpi.update') }}" : "{{ route('marketing_setting.kpi.store') }}";
            let btnSimpan = $('#btnSimpanKpi');

            btnSimpan.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $('#modalErrorAlert').addClass('d-none');

            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#modalKpi').modal('hide');
                        showAlert(response.message);
                        setTimeout(function() {
                            location.reload(); // Reload untuk memperbarui persentase & daftar
                        }, 800);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('#errorList').empty();
                        $.each(errors, function(key, value) {
                            $('#errorList').append('<li>' + value[0] + '</li>');
                        });
                        $('#modalErrorAlert').removeClass('d-none');
                    } else {
                        alert('Terjadi kesalahan sistem.');
                    }
                },
                complete: function() {
                    btnSimpan.prop('disabled', false).html('Simpan Indikator');
                }
            });
        });

        // Hapus KPI
        $(document).on('click', '.btn-hapus-kpi', function() {
            let id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus indikator penilaian ini?')) {
                $.ajax({
                    url: "{{ url('master-marketing/marketing-setting/kpi/delete') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#row-kpi-' + id).fadeOut(300, function() {
                                $(this).remove();
                            });
                            showAlert(response.message);
                        }
                    }
                });
            }
        });

        function showAlert(msg) {
            $('#alertContainer').html(`
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-1"></i> ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `);
        }
    });
</script>
@endsection
