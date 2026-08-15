@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
@endsection

@section('content')

<!-- CARD 1: FORM INPUT TARGET CABANG USER & TABEL DATA TARGET -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-header bg-white pb-0">
        <h6 class="font-weight-bold text-primary mb-0">
            <i class="fas fa-bullseye me-2"></i>Kelola Target Cabang Bulanan
            <span class="badge bg-info ms-2">Cabang: {{ Auth::user()->access->cabang ?? Auth::user()->cabang ?? 'PA' }}</span>
        </h6>
    </div>
    <div class="card-body">
        <!-- Form Input Target (Tanpa Dropdown Cabang) -->
        <form id="form-target-cabang" onsubmit="return false;">
            @csrf
            <div class="row g-3 align-items-end mb-4">
                <!-- Select Tahun -->
                <div class="col-md-3">
                    <label class="form-label font-weight-bold">Tahun</label>
                    <select name="tahun" id="target_tahun" class="form-select" required>
                        @php
                        $tahunSekarang = date('Y');
                        @endphp
                        @for($i = $tahunSekarang - 2; $i <= $tahunSekarang + 2; $i++)
                            <option value="{{ $i }}" {{ $i == $tahunSekarang ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                </div>

                <!-- Select Bulan -->
                <div class="col-md-3">
                    <label class="form-label font-weight-bold">Bulan</label>
                    <select name="bulan" id="target_bulan" class="form-select" required>
                        @php
                        $daftarBulan = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $bulanSekarang = date('n');
                        @endphp
                        @foreach($daftarBulan as $key => $namaBulan)
                        <option value="{{ $key }}" {{ $key == $bulanSekarang ? 'selected' : '' }}>{{ $namaBulan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Nominal Target & Button -->
                <div class="col-md-6">
                    <label class="form-label font-weight-bold">Nominal Target (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="target" id="target_nominal" class="form-control" placeholder="Contoh: 150000000" min="0" step="1000" required>
                        <button type="button" id="btn-save-target" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Target
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <hr class="my-4">

        <!-- Tabel Data Target Ter-input -->
        <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-list me-2"></i>Daftar Target Cabang Anda</h6>
        <div class="table-responsive">
            <table id="table-target-cabang" class="table table-sm table-striped table-bordered dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Cabang</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Nominal Target (Rp)</th>
                        <th>Terakhir Diupdate</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($listTarget) && count($listTarget) > 0)
                    @foreach($listTarget as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-secondary">{{ $item->master_cabang_code }}</span></td>
                        <td>{{ $item->tahun }}</td>
                        <td>
                            @php
                            $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            @endphp
                            {{ $namaBulan[$item->bulan] ?? $item->bulan }}
                        </td>
                        <td class="font-weight-bold text-success">Rp {{ number_format($item->target, 0, ',', '.') }}</td>
                        <td>{{ $item->updated_at ? date('d-m-Y H:i', strtotime($item->updated_at)) : '-' }}</td>
                    </tr>
                    @endforeach
                    @else

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CARD 2: UPLOAD DATA OMSET -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-header bg-white pb-0">
        <h6 class="font-weight-bold text-primary mb-0"><i class="fas fa-file-excel me-2"></i>Upload & Preview Data Omset</h6>
    </div>
    <div class="card-body">
        <form id="form-upload" enctype="multipart/form-data" onsubmit="return false;">
            @csrf
            <div class="row g-3">
                <div class="col-md-9">
                    <label class="form-label font-weight-bold">File Excel (.xls / .xlsx)</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="btn-preview" class="btn btn-primary w-100">
                        Upload & Preview
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Table Section -->
<div class="card d-none shadow-sm border-0 mb-3" id="preview-section">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 font-weight-bold text-dark">Preview Data (Belum Disimpan)</h6>
        <button type="button" id="btn-import" class="btn btn-success">
            <i class="fas fa-file-import me-1"></i> Proses Import Ke Database
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-preview" class="table table-striped table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>NoReg</th>
                        <th>Pasien</th>
                        <th>HP</th>
                        <th>Tipe Omset</th>
                        <th>Bruto</th>
                        <th>Disc</th>
                        <th>Total</th>
                        <th>Pay</th>
                        <th>Jml Test</th>
                        <th>Pemeriksaan</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('base.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>

<script>
    let rawImportData = [];
    let tablePreview = null;

    $(document).ready(function() {
        // Inisialisasi DataTables untuk Tabel List Target
        $('#table-target-cabang').DataTable({
            responsive: true,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            language: {
                emptyTable: "Belum ada data target"
            }
        });
    });

    // ==========================================
    // 1. HANDLER SIMPAN TARGET CABANG USER
    // ==========================================
    $('#btn-save-target').on('click', function(e) {
        e.preventDefault();

        let tahun = $('#target_tahun').val();
        let bulan = $('#target_bulan').val();
        let targetNominal = $('#target_nominal').val();

        if (!targetNominal || targetNominal < 0) {
            alert('Silakan isi Nominal Target dengan benar!');
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
            url: "{{ route('target_cabang_store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                tahun: tahun,
                bulan: bulan,
                target: targetNominal
            },
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Target');
                alert(res.message || 'Target cabang berhasil disimpan!');
                $('#target_nominal').val('');

                // Reload halaman agar tabel data target memperbarui datanya secara langsung
                location.reload();
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Target');
                alert('Gagal menyimpan target: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan sistem'));
            }
        });
    });

    // ==========================================
    // 2. HANDLER PREVIEW UPLOAD OMSET
    // ==========================================
    $('#btn-preview').on('click', function(e) {
        e.preventDefault();

        let fileInput = $('#file')[0];
        if (!fileInput.files.length) {
            alert('Silakan pilih file Excel terlebih dahulu!');
            return;
        }

        let formData = new FormData($('#form-upload')[0]);
        let btn = $(this);

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

        $.ajax({
            url: "{{ route('upload_data_omset_preview') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                btn.prop('disabled', false).text('Upload & Preview');

                if (res.status === 'success') {
                    rawImportData = res.data;
                    $('#preview-section').removeClass('d-none');

                    if ($.fn.DataTable.isDataTable('#table-preview')) {
                        $('#table-preview').DataTable().clear().destroy();
                    }

                    tablePreview = $('#table-preview').DataTable({
                        data: res.data,
                        responsive: true,
                        columns: [{
                                data: 'tanggal'
                            },
                            {
                                data: 'noreg'
                            },
                            {
                                data: 'pasien'
                            },
                            {
                                data: 'hp'
                            },
                            {
                                data: 'tipe_omset'
                            },
                            {
                                data: 'bruto',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'disc',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'total',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'pay',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'jml_test'
                            },
                            {
                                data: 'pemeriksaan'
                            }
                        ]
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Upload & Preview');
                alert('Gagal membaca file: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan sistem'));
            }
        });
    });

    // ==========================================
    // 3. HANDLER IMPORT OMSET KE DATABASE
    // ==========================================
    $('#btn-import').on('click', function() {
        if (!rawImportData.length) {
            alert('Tidak ada data yang siap diimpor!');
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses Simpan...');

        $.ajax({
            url: "{{ route('upload_data_omset_store') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: JSON.stringify({
                data: rawImportData
            }),
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fas fa-file-import me-1"></i> Proses Import Ke Database');
                alert(res.message);

                $('#preview-section').addClass('d-none');
                $('#form-upload')[0].reset();
                if (tablePreview) {
                    tablePreview.clear().destroy();
                }
                rawImportData = [];
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-file-import me-1"></i> Proses Import Ke Database');
                alert('Gagal menyimpan data: ' + (xhr.responseJSON?.message || 'Error'));
            }
        });
    });
</script>
@endsection
