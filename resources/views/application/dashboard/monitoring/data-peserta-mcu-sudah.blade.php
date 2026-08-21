<style>
    /* Styling Khusus Modal List Sudah MCU */
    .modal-header-success-gradient {
        background: linear-gradient(135deg, #00d27a 0%, #119859 100%);
    }

    #data-v3 {
        border-collapse: separate !important;
        border-spacing: 0;
    }

    #data-v3 thead th {
        background-color: #f8f9fa !important;
        color: #4b566b !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #edf2f9 !important;
        padding: 12px;
    }

    #data-v3 tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f9;
        font-size: 0.82rem;
    }

    #data-v3 tbody tr:hover {
        background-color: rgba(0, 210, 122, 0.04) !important;
    }
</style>

<div class="modal-body p-0 overflow-hidden">
    <!-- Header Modal Modern Green Gradient -->
    <div class="modal-header-success-gradient p-4 position-relative">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center me-3">
                <div class="p-3 bg-white bg-opacity-20 rounded-3 text-success me-3">
                    <i class="fas fa-user-check fa-2x"></i>
                </div>
                <div>
                    <span class="badge bg-white text-success rounded-pill px-2.5 py-1 mb-1 fs--2 fw-bold shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Status: Sudah MCU
                    </span>
                    <h5 class="mb-0 text-white fw-bold fs-1" id="staticBackdropLabel">
                        {{ $data->master_company_name }}
                    </h5>
                    <p class="text-white-50 fs--1 mb-0">
                        <i class="fas fa-file-contract me-1"></i>{{ $data->company_mou_name }}
                    </p>
                </div>
            </div>
            <div class="text-end d-none d-md-block">
                <!-- <p class="text-white-50 fs--2 mb-0">Support by</p>
                <span class="fw-bold text-white fs--1">Transforma</span> -->
            </div>
        </div>
    </div>

    <!-- Tab & Table Content -->
    <div class="p-3 p-md-4 bg-white">
        <!-- Status Indicator Bar -->
        <div class="d-flex align-items-center justify-content-between mb-3 bg-soft-success p-2.5 rounded-3 border border-success border-opacity-25">
            <div class="d-flex align-items-center">
                <span class="badge bg-success rounded-pill m-2"><i class="fas fa-check"></i></span>
                <span class="fs--1 text-success fw-bold">Daftar Karyawan yang Telah Melakukan Pemeriksaan MCU</span>
            </div>
        </div>

        <div class="table-responsive p-0 m-0">
            <table id="data-v3" class="table table-hover w-100 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th style="width: 15%">NIP / NIK</th>
                        <th style="width: 25%">Nama Peserta</th>
                        <th class="text-center" style="width: 15%">Gender</th>
                        <th style="width: 18%">Departemen</th>
                        <th style="width: 22%">Lokasi & Waktu MCU</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($peserta as $pesertas)
                    @php
                    $lokasi = DB::table('log_lokasi_pasien')
                    ->select('master_cabang.master_cabang_name', 'master_cabang.master_cabang_city', 'log_lokasi_pasien.created_at')
                    ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                    ->where('log_lokasi_pasien.mou_peserta_code', $pesertas->mou_peserta_code)
                    ->first();
                    @endphp

                    @if ($lokasi)
                    <tr>
                        <td class="text-center fw-bold text-600">{{ $no++ }}</td>
                        <td>
                            <div class="fw-bold text-dark font-monospace fs--1">
                                {{ $pesertas->mou_peserta_nip ?? '-' }}
                            </div>
                            @if (!empty($pesertas->mou_peserta_nik))
                            <div class="text-400 fs--2" title="NIK">
                                <i class="fas fa-id-card me-1"></i>{{ $pesertas->mou_peserta_nik }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $pesertas->mou_peserta_name }}</div>
                        </td>
                        <td class="text-center">
                            @if ($pesertas->mou_peserta_jk == 'L' || strtoupper($pesertas->mou_peserta_jk) == 'LAKI-LAKI')
                            <span class="badge bg-soft-info text-info rounded-pill px-2 py-1">
                                <i class="fas fa-mars me-1"></i>Laki-laki
                            </span>
                            @else
                            <span class="badge bg-soft-danger text-danger rounded-pill px-2 py-1">
                                <i class="fas fa-venus me-1"></i>Perempuan
                            </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-soft-primary text-primary fs--2">
                                <i class="fas fa-briefcase me-1"></i>{{ $pesertas->mou_peserta_departemen ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column align-items-start">
                                <span class="text-800 fw-bold fs--1 mb-1">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $lokasi->master_cabang_name }}
                                </span>
                                <small class="text-500 fs--2">
                                    <i class="fas fa-clock text-primary me-1"></i>{{ date('d M Y, H:i', strtotime($lokasi->created_at)) }} WIB
                                </small>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#data-v3')) {
            $('#data-v3').DataTable().destroy();
        }

        new DataTable('#data-v3', {
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Peserta...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ peserta",
                infoEmpty: "Tidak ada data peserta",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });
    });
</script>
