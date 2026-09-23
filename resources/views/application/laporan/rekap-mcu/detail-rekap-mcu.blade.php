<style>
    .cursor-pointer:hover {
        cursor: pointer;
        color: #dc3545;
    }
</style>

<div class="card mb-3">
    <!-- Header Card -->
    <div class="card-header bg-danger">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="mb-0"><span class="badge bg-danger">REKAP PROJECT</span></h4>
            </div>
            <div class="col-auto">
                <a class="btn btn-falcon-danger btn-sm" href="#!" id="button-cari-project" data-bs-toggle="modal" data-bs-target="#modal-laporan-lg">
                    <span class="fas fa-search"></span> Cari Data Project
                </a>
            </div>
        </div>
    </div>

    <!-- Body Informasi Utama & Chart -->
    <div class="card-body bg-light border-top">
        <div class="row g-3 pb-3">
            <!-- Informasi Perusahaan -->
            <div class="col-lg-4">
                <div class="card p-4 border border-danger h-100">
                    <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informasi Perusahaan</h6>
                    <div class="row"><div class="col-5 fw-semi-bold mb-1">Nama</div><div class="col">{{ $data->master_company_name }}</div></div>
                    <div class="row"><div class="col-5 fw-semi-bold mb-1">Wilayah</div><div class="col">{{ $data->master_company_wilayah }}</div></div>
                    <div class="row"><div class="col-5 fw-semi-bold mb-1">Email</div><div class="col">{{ $data->master_company_email }}</div></div>
                    <div class="row"><div class="col-5 fw-semi-bold mb-0">Phone</div><div class="col">{{ $data->master_company_phone }}</div></div>
                </div>
            </div>
            <!-- Informasi Project -->
            <div class="col-lg-4">
                <div class="card p-4 border border-danger h-100">
                    <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informasi Project</h6>
                    <div class="row"><div class="col-5 fw-semi-bold mb-1">Nama Project</div><div class="col">{{ $data->company_mou_name }}</div></div>
                    <div class="row"><div class="col-5 fw-semi-bold mb-1">Total Peserta</div><div class="col">{{ $totalpeserta }} Peserta</div></div>
                    <div class="row"><div class="col-5 fw-semi-bold mb-0">Tanggal MCU</div><div class="col">{{ $data->company_mou_start }}</div></div>
                </div>
            </div>
            <!-- Status Peserta MCU -->
            <div class="col-lg-4">
                <div class="card p-4 border border-danger h-100">
                    <h6 class="fw-semi-bold ls mb-3 text-uppercase">Status Peserta MCU</h6>
                    <div class="row"><div class="col-8 fw-semi-bold mb-1">Total Peserta</div><div class="col">{{ $totalpeserta }}</div></div>
                    <div class="row"><div class="col-8 fw-semi-bold mb-1">Sudah MCU</div><div class="col">{{ $totalmcu }}</div></div>
                    <div class="row"><div class="col-8 fw-semi-bold mb-1">Belum MCU</div><div class="col">{{ $totalpeserta - $totalmcu }}</div></div>
                    <div class="row"><div class="col-8 fw-semi-bold mb-0">Persentase</div><div class="col fw-semi-bold">{{ $totalpeserta > 0 ? round(($totalmcu / $totalpeserta) * 100, 2) : 0 }} %</div></div>
                </div>
            </div>
        </div>

        <!-- Tabel Cabang & Pie Chart -->
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card p-2 border border-danger">
                    <h6 class="fw-semi-bold text-uppercase mb-2">Informasi Cabang / Wilayah</h6>
                    <table id="table-cabang" class="table table-bordered table-striped fs--1 mb-0" style="width:100%">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>Wilayah</th>
                                <th>Total Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group as $groups)
                                <tr>
                                    <td>{{ $groups->group_cabang_name }}</td>
                                    <td>
                                        @php
                                            $jumlahCabang = $allPeserta->where('group_cabang_code', $groups->group_cabang_code)->count();
                                        @endphp
                                        {{ $jumlahCabang }} Peserta
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card border border-danger">
                    <div class="echart-pie-chart-example p-3" style="min-height: 360px;" data-echart-responsive="true"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Tombol Export -->
    <div class="card-footer border-top text-end">
        <button class="btn btn-falcon-danger" data-bs-toggle="modal" data-bs-target="#modal-mcu" id="button-detail-full-peserta" data-code="{{ $data->company_mou_code }}">Export data</button>
        <a class="btn btn-falcon-default btn-sm ms-2" href="#!" data-bs-toggle="modal" data-bs-target="#modal-mcu" id="button-detail-rekap-kehadiran-peserta" data-code="{{ $data->company_mou_code }}">Export Kehadiran PDF</a>
    </div>
</div>

<!-- BAGIAN DATA PESERTA LENGKAP (Dibuat Collapse / Accordion per Wilayah agar Ringan) -->
@foreach ($group as $groups)
    <div class="card mb-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#collapse-group-{{ $groups->group_cabang_code }}" style="cursor: pointer;">
            <h5 class="mb-0 text-warning">Wilayah: {{ $groups->group_cabang_name }}</h5>
            <span class="fas fa-chevron-down fs--1"></span>
        </div>

        <div class="collapse" id="collapse-group-{{ $groups->group_cabang_code }}">
            <div class="card-body border-top p-2">
                @php
                    $data_mcu = $allPeserta->where('group_cabang_code', $groups->group_cabang_code)->unique('master_cabang_code');
                @endphp

                @foreach ($data_mcu as $data_mcus)
                    <div class="card mb-3 border">
                        <div class="card-header bg-200 py-2">
                            <h6 class="mb-0">Cabang: {{ $data_mcus->master_cabang_name }}</h6>
                        </div>
                        <div class="card-body p-2">
                            <table id="table-peserta-{{ $data_mcus->id_master_cabang }}" class="table table-striped table-bordered nowrap fs--2" style="width:100%">
                                <thead class="bg-200 text-700">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peserta</th>
                                        <th>NIK</th>
                                        <th>JK</th>
                                        <th>Status Pengiriman</th>
                                        <th>Status Konsultasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $pesertaCabang = $allPeserta->where('master_cabang_code', $data_mcus->master_cabang_code);
                                    @endphp
                                    @foreach ($pesertaCabang as $pesertas)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $pesertas->mou_peserta_name }}</td>
                                            <td>{{ $pesertas->mou_peserta_nik }}</td>
                                            <td>{{ $pesertas->mou_peserta_jk }}</td>
                                            <td>
                                                @if (isset($pengirimanMap[$pesertas->mou_peserta_code]))
                                                    <span class="badge bg-primary">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Belum Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($konsultasiMap[$pesertas->mou_peserta_code]))
                                                    <span class="badge bg-primary">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Belum Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Inisialisasi DataTable per cabang secara aman -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            if (!$.fn.DataTable.isDataTable('#table-peserta-{{ $data_mcus->id_master_cabang }}')) {
                                $('#table-peserta-{{ $data_mcus->id_master_cabang }}').DataTable({
                                    responsive: true,
                                    pageLength: 10
                                });
                            }
                        });
                    </script>
                @endforeach
            </div>
        </div>
    </div>
@endforeach

<!-- Script Inisialisasi Utama -->
<script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
<script>
    // DataTable Utama Cabang
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#table-cabang')) {
            $('#table-cabang').DataTable({
                responsive: true,
                pageLength: 5,
                lengthChange: false
            });
        }
    });

    // Chart ECharts Bar (Grafik Batang)
    var echartsBarChartInit = function () {
        var $barChartEl = document.querySelector('.echart-pie-chart-example'); // Class container tetap sama agar tidak perlu merubah HTML card
        if ($barChartEl) {
            var chart = window.echarts.init($barChartEl);
            var option = {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                grid: {
                    top: '15%',
                    bottom: '15%',
                    left: '10%',
                    right: '5%'
                },
                xAxis: {
                    type: 'category',
                    data: [
                        @foreach ($group as $groups)
                            '{{ $groups->group_cabang_name }}',
                        @endforeach
                    ],
                    axisLabel: {
                        interval: 0,
                        rotate: 30 // Miringkan teks jika nama wilayah panjang
                    }
                },
                yAxis: {
                    type: 'value',
                    name: 'Jumlah Peserta'
                },
                series: [{
                    data: [
                        @foreach ($group as $groups)
                            @php
                                $totalGroup = $allPeserta->where('group_cabang_code', $groups->group_cabang_code)->count();
                            @endphp
                            '{{ $totalGroup }}',
                        @endforeach
                    ],
                    type: 'bar',
                    itemStyle: {
                        color: '#dc3545' // Warna merah menyesuaikan tema template Falcon (danger)
                    },
                    barWidth: '50%'
                }]
            };
            chart.setOption(option);

            // Responsive chart saat ukuran window berubah
            window.addEventListener('resize', function () {
                chart.resize();
            });
        }
    };

    echartsBarChartInit();
</script>
