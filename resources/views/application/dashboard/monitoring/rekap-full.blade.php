<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Rekap Full MC</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <div class="card mb-3">
            <div class="card-header bg-danger">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0"><span class="badge bg-danger">REKAP PROJECT</span></h4>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light border-top">
                <div class="row g-3 pb-3">
                    <div class="col-lg-4 col-xxl-4">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informasi Perusahaan</h6>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Code</p>
                                </div>
                                <div class="col">{{ $data->master_company_code }}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Nama</p>
                                </div>
                                <div class="col">{{ $data->master_company_name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Wilayah</p>
                                </div>
                                <div class="col">{{ $data->master_company_wilayah }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Email</p>
                                </div>
                                <div class="col">
                                    {{ $data->master_company_email }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-0">Phone</p>
                                </div>
                                <div class="col">
                                    {{ $data->master_company_phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informasi Project</h6>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Code</p>
                                </div>
                                <div class="col">{{ $data->company_mou_code }}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Nama Project</p>
                                </div>
                                <div class="col">
                                    {{ $data->company_mou_name }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-1">Total Peserta</p>
                                </div>
                                <div class="col">{{ $totalpeserta }} Peserta</div>
                            </div>
                            <div class="row">
                                <div class="col-5 col-sm-4">
                                    <p class="fw-semi-bold mb-0">Tanggal MCU</p>
                                </div>
                                <div class="col">
                                    {{ $data->company_mou_start }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-4">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold ls mb-3 text-uppercase">Status Peserta MCU</h6>

                            <div class="row">
                                <div class="col-8 col-sm-8">
                                    <p class="fw-semi-bold mb-1">Total Peserta</p>
                                </div>
                                <div class="col">{{ $totalpeserta }} Peserta</div>
                            </div>
                            <div class="row">
                                <div class="col-8 col-sm-8">
                                    <p class="fw-semi-bold mb-1">Sudah Melakukan MCU</p>
                                </div>
                                <div class="col">
                                    <p class="mb-1">{{ $totalmcu }} Peserta</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 col-sm-8">
                                    <p class="fw-semi-bold mb-1">Belum Melakukan MCU</p>
                                </div>
                                <div class="col">{{ $totalpeserta - $totalmcu }} Peserta</div>
                            </div>
                            <div class="row">
                                <div class="col-8 col-sm-8">
                                    <p class="fw-semi-bold mb-0">Persentase</p>
                                </div>
                                <div class="col">
                                    <p class="fw-semi-bold mb-0">{{ round(($totalmcu / $totalpeserta) * 100, 2) }} %
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="card border border-danger">
                            <div class="echart-pie-chart-example p-3" style="min-height: 360px;"
                                data-echart-responsive="true">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold text-uppercase">Informasi Cabang</h6>
                            <table id="table-cabang"
                                data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'
                                class="table table-bordered table-striped fs--1 mb-0">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="sort" data-sort="name">Nama Cabang</th>
                                        <th class="sort" data-sort="email">Peserta Check In</th>
                                        <th class="sort" data-sort="age">Executive</th>
                                        <th class="sort" data-sort="age">Persentasi</th>
                                        <th class="sort" data-sort="age">Healty Talk</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($cabang as $cabangs)
                                        <tr>
                                            <td class="name">{{ $cabangs->master_cabang_name }}</td>
                                            <td class="email">
                                                @php
                                                    $jumlah = DB::table('log_lokasi_pasien')
                                                        ->join(
                                                            'company_mou_peserta',
                                                            'company_mou_peserta.mou_peserta_code',
                                                            '=',
                                                            'log_lokasi_pasien.mou_peserta_code',
                                                        )
                                                        ->where(
                                                            'company_mou_peserta.company_mou_code',
                                                            $data->company_mou_code,
                                                        )
                                                        ->where(
                                                            'log_lokasi_pasien.lokasi_cabang',
                                                            $cabangs->master_cabang_code,
                                                        )
                                                        ->count();
                                                @endphp
                                                {{ $jumlah }} Peserta
                                            </td>
                                            @php
                                                $sumarry = DB::table('log_summary_cabang')
                                                    ->where('company_mou_code', $data->company_mou_code)
                                                    ->where('master_cabang_code', $cabangs->master_cabang_code)
                                                    ->first();
                                            @endphp
                                            <td class="age">
                                                @if ($sumarry)
                                                    @if ($sumarry->summary_cabang_executive == 1)
                                                        <span class="badge bg-primary">Done</span> <br>
                                                        {{ $sumarry->summary_cabang_executive_date }}
                                                    @elseif ($sumarry->summary_cabang_executive == 0)
                                                        <span class="badge bg-warning">Skip</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Belum</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sumarry)
                                                    @if ($sumarry->summary_cabang_pesentasi == 1)
                                                        <span class="badge bg-primary">Done</span> <br>
                                                        {{ $sumarry->summary_cabang_pesentasi_date }}
                                                    @elseif ($sumarry->summary_cabang_pesentasi == 0)
                                                        <span class="badge bg-warning">Skip</span>
                                                    @else
                                                        <span class="badge bg-danger">Belums</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Belum</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sumarry)
                                                    @if ($sumarry->summary_cabang_ht == 1)
                                                        <span class="badge bg-primary">Done</span> <br>
                                                        {{ $sumarry->summary_cabang_ht_date }}
                                                    @elseif ($sumarry->summary_cabang_ht == 0)
                                                        <span class="badge bg-warning">Skip</span>
                                                    @else
                                                        <span class="badge bg-danger">Belums</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Belum</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer border-top text-end">
                <a class="btn btn-falcon-default btn-sm ms-2" href="#!">Export PDF</a>
            </div>
        </div>
        <script>
            new DataTable('#table-cabang', {
                responsive: true,
                pageLength: 5,
            });
        </script>
        @foreach ($cab as $cabs)
            <div class="card mb-3">
                <div class="card-header bg-danger">

                    <h5 class="mb-0"><span class="badge bg-danger">Kota {{ $cabs->master_cabang_city }}</span></h5>

                </div>
                <div class="card-body border-top p-0 px-1">
                    @foreach ($cabang as $cabangs)
                        @if ($cabangs->master_cabang_city == $cabs->master_cabang_city)
                            @php
                                $no = 1;
                                $peserta = DB::table('log_lokasi_pasien')
                                    ->join(
                                        'company_mou_peserta',
                                        'company_mou_peserta.mou_peserta_code',
                                        '=',
                                        'log_lokasi_pasien.mou_peserta_code',
                                    )
                                    ->where('company_mou_peserta.company_mou_code', $data->company_mou_code)
                                    ->where('log_lokasi_pasien.lokasi_cabang', $cabangs->master_cabang_code)
                                    ->get();
                            @endphp
                            <div class="card-body p-2 px-1">
                                <div class="card p-3 border border-danger m-3">
                                    <h6 class="pt-3">{{ $cabangs->master_cabang_name }}</h6>
                                    <table id="data-{{ $cabangs->id_master_cabang }}"
                                        class="table table-striped nowrap" style="width:100%">
                                        <thead class="bg-200 text-700 fs--2">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peserta</th>
                                                <th>NIK</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Status Pemeriksaan</th>
                                                <th>Status Pengiriman Hasil</th>
                                                <th>Status Konsultasi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs--2">
                                            @foreach ($peserta as $pesertas)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $pesertas->mou_peserta_name }}</td>
                                                    <td>{{ $pesertas->mou_peserta_nik }}</td>
                                                    <td>{{ $pesertas->mou_peserta_jk }}</td>
                                                    <td>
                                                        @php
                                                            $pemeriksaan = DB::table('company_mou_agreement_sub')
                                                                ->join(
                                                                    'master_pemeriksaan',
                                                                    'master_pemeriksaan.master_pemeriksaan_code',
                                                                    '=',
                                                                    'company_mou_agreement_sub.master_pemeriksaan_code',
                                                                )
                                                                ->where(
                                                                    'company_mou_agreement_sub.mou_agreement_code',
                                                                    $pesertas->mou_agreement_code,
                                                                )
                                                                ->get();
                                                        @endphp
                                                        @foreach ($pemeriksaan as $pem)
                                                            @php
                                                                $check = DB::table('log_pemeriksaan_pasien')
                                                                    ->where(
                                                                        'master_pemeriksaan_code',
                                                                        $pem->master_pemeriksaan_code,
                                                                    )
                                                                    ->where(
                                                                        'mou_peserta_code',
                                                                        $pesertas->mou_peserta_code,
                                                                    )
                                                                    ->first();
                                                            @endphp
                                                            @if ($check)
                                                                @if ($check->log_pemeriksaan_status == 1)
                                                                    <li>{{ $pem->master_pemeriksaan_name }} <span
                                                                            class="fas fa-check-square text-success"></span>
                                                                    </li>
                                                                @else
                                                                    <li>{{ $pem->master_pemeriksaan_name }} <span
                                                                            class="fas fa-exclamation-circle text-warning"></span>
                                                                    </li>
                                                                @endif
                                                            @else
                                                                <li>{{ $pem->master_pemeriksaan_name }} <span
                                                                        class="fas fa-window-close text-danger"></span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pengiriman = DB::table('log_pengiriman_pasien')
                                                                ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                                                                ->first();
                                                        @endphp
                                                        @if ($pengiriman)
                                                            <span class="badge bg-primary">Selesai</span>
                                                        @else
                                                            <span class="badge bg-danger">Belum Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $konsul = DB::table('log_konsultasi_pasien')
                                                                ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                                                                ->first();
                                                        @endphp
                                                        @if ($konsul)
                                                            <span class="badge bg-primary">Selesai</span>
                                                        @else
                                                            <span class="badge bg-danger">Belum Selesai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <script>
                                        new DataTable('#data-{{ $cabangs->id_master_cabang }}', {
                                            responsive: true
                                        });
                                    </script>

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>
        @endforeach
        <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
        @php
            $id = 0;

        @endphp
        <script>
            function warna(id) {
                if (id == 0) {
                    return 'primary';
                } else if (id == 1) {
                    return 'danger';
                } else if (id == 2) {
                    return 'secondary';
                } else if (id == 3) {
                    return 'warning';
                } else if (id == 4) {
                    return 'success';
                } else if (id == 5) {
                    return 'info';
                } else if (id == 6) {
                    return 'dark';
                } else if (id == 7) {
                    return 'primary';
                } else if (id == 8) {
                    return 'danger';
                } else if (id == 9) {
                    return 'secondary';
                } else if (id == 10) {
                    return 'warning';
                } else if (id == 11) {
                    return 'success';
                } else if (id == 12) {
                    return 'info';
                } else if (id == 13) {
                    return 'light';
                } else if (id == 14) {
                    return 'dark';
                }
            }
            var echartsPieChartInit = function echartsPieChartInit() {
                var $pieChartEl = document.querySelector('.echart-pie-chart-example');

                if ($pieChartEl) {
                    // Get options from data attribute
                    var userOptions = utils.getData($pieChartEl, 'options');
                    var chart = window.echarts.init($pieChartEl);

                    var getDefaultOptions = function getDefaultOptions() {
                        return {
                            legend: {
                                left: 'left',
                                textStyle: {
                                    color: utils.getGrays()['600']
                                }
                            },
                            series: [{
                                type: 'pie',
                                radius: window.innerWidth < 530 ? '45%' : '60%',
                                label: {
                                    color: utils.getGrays()['700']
                                },
                                center: ['50%', '55%'],
                                data: [
                                    @foreach ($cabang as $cabangs)
                                        @php
                                            $total = DB::table('log_lokasi_pasien')->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')->where('company_mou_peserta.company_mou_code', $data->company_mou_code)->where('log_lokasi_pasien.lokasi_cabang', $cabangs->master_cabang_code)->count();
                                        @endphp {
                                            value: '{{ $total }}',
                                            name: '{{ $cabangs->master_cabang_name }}',
                                            itemStyle: {
                                                color: utils.getColor(warna('{{ $id++ }}'))
                                            }
                                        },
                                    @endforeach
                                ],
                                emphasis: {
                                    itemStyle: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: utils.rgbaColor(utils.getGrays()['600'], 0.5)
                                    }
                                }
                            }],
                            tooltip: {
                                trigger: 'item',
                                padding: [7, 10],
                                backgroundColor: utils.getGrays()['100'],
                                borderColor: utils.getGrays()['300'],
                                textStyle: {
                                    color: utils.getColors().dark
                                },
                                borderWidth: 1,
                                transitionDuration: 0,
                                axisPointer: {
                                    type: 'none'
                                }
                            }
                        };
                    };

                    echartSetOption(chart, userOptions, getDefaultOptions); //- set chart radius on window resize

                    utils.resize(function() {
                        if (window.innerWidth < 530) {
                            chart.setOption({
                                series: [{
                                    radius: '45%'
                                }]
                            });
                        } else {
                            chart.setOption({
                                series: [{
                                    radius: '60%'
                                }]
                            });
                        }
                    });
                }
            };

            docReady(echartsPieChartInit);
        </script>
    </div>

</div>
