@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .metric-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .chart-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .badge-year1 {
        background-color: #ffc107;
        color: #000;
    }

    .badge-year2 {
        background-color: #0d6efd;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header & Filter Komparasi -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h4 class="font-weight-bold mb-1"><i class="fas fa-chart-line text-primary me-2"></i>Dashboard Monitoring Omset vs Target</h4>
            <p class="text-muted small mb-0">Visualisasi realisasi omset bulanan berbanding target cabang per tahun.</p>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0 align-items-center">
            <!-- Filter Cabang (Mengirimkan master_cabang_code) -->
            <select id="filter-cabang" class="form-select form-select-sm shadow-sm" style="min-width: 170px;">
                <option value="">-- Semua Cabang --</option>
                @foreach($listCabang as $cbg)
                <option value="{{ $cbg->master_cabang_code }}">{{ $cbg->master_cabang_name }}</option>
                @endforeach
            </select>

            <!-- Pembanding 1 (Warna Kuning) -->
            <div class="d-flex align-items-center bg-white p-1 rounded border shadow-sm">
                <span class="badge badge-year1 me-1"><i class="fas fa-square me-1"></i>Tahun 1</span>
                <select id="filter-tahun-1" class="form-select form-select-sm border-0 fw-bold" style="width: 110px;">
                    @foreach($listTahun as $thn)
                    <option value="{{ $thn }}" {{ $thn == (date('Y') - 1) ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pembanding 2 (Warna Biru) -->
            <div class="d-flex align-items-center bg-white p-1 rounded border shadow-sm">
                <span class="badge badge-year2 me-1"><i class="fas fa-square me-1"></i>Tahun 2</span>
                <select id="filter-tahun-2" class="form-select form-select-sm border-0 fw-bold text-primary" style="width: 120px;">
                    <option value="">-- Nonaktif --</option>
                    @foreach($listTahun as $thn)
                    <option value="{{ $thn }}" {{ $thn == date('Y') ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Summary Cards (Metrik Realisasi & Target) -->
    <div class="row g-3 mb-4">
        <!-- Realisasi Omset -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-primary bg-opacity-10 text-white me-3">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Realisasi Omset</span>
                        <h4 class="mb-0 font-weight-bold" id="card-total-omset">Rp 0</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Target -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-warning bg-opacity-10 text-white me-3">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Total Target</span>
                        <h4 class="mb-0 font-weight-bold" id="card-total-target">Rp 0</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- % Pencapaian -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-success bg-opacity-10 text-white me-3">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Pencapaian Target</span>
                        <h4 class="mb-0 font-weight-bold text-success" id="card-persen-pencapaian">0%</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-info bg-opacity-10 text-white me-3">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Total Transaksi</span>
                        <h4 class="mb-0 font-weight-bold" id="card-total-transaksi">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="row g-3 mb-4">
        <!-- Main Line Chart (Omset vs Target Bulanan) -->
        <div class="col-lg-8">
            <div class="card chart-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 font-weight-bold"><i class="fas fa-chart-area me-2 text-primary"></i>Tren Omset Bulanan vs Target</h6>
                    <span class="badge bg-light text-dark border" id="chart-year-badge">Loading...</span>
                </div>
                <div style="height: 340px; position: relative;">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart (Breakdown Tipe Omset) -->
        <div class="col-lg-4">
            <div class="card chart-card p-3">
                <h6 class="mb-3 font-weight-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>Proporsi Tipe Omset</h6>
                <div style="height: 340px; position: relative;" class="d-flex align-items-center justify-content-center">
                    <canvas id="tipeOmsetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="card chart-card p-3">
                <h6 class="mb-3 font-weight-bold"><i class="fas fa-trophy me-2 text-warning"></i>Top 5 Kelompok Pelanggan Terbesar</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kelompok Pelanggan</th>
                                <th class="text-end">Total Contribution</th>
                            </tr>
                        </thead>
                        <tbody id="top-kelompok-body">
                            <tr>
                                <td colspan="3" class="text-center text-muted">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let monthlyChart = null;
    let tipeChart = null;

    const COLOR_TAHUN_1 = '#ffc107'; // Kuning
    const COLOR_TAHUN_2 = '#0d6efd'; // Biru

    $(document).ready(function() {
        loadDashboardData();

        $('#filter-tahun-1, #filter-tahun-2, #filter-cabang').on('change', function() {
            loadDashboardData();
        });
    });

    function loadDashboardData() {
        let tahun1 = $('#filter-tahun-1').val();
        let tahun2 = $('#filter-tahun-2').val();
        let cabang = $('#filter-cabang').val();

        if (tahun1 && tahun2) {
            $('#chart-year-badge').html(`Komparasi: <b class="text-warning">${tahun1}</b> vs <b class="text-primary">${tahun2}</b>`);
        } else if (tahun1) {
            $('#chart-year-badge').html(`Tahun: <b class="text-warning">${tahun1}</b>`);
        }

        $.ajax({
            url: "{{ route('monitoring_omset_data') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                tahun_1: tahun1,
                tahun_2: tahun2,
                cabang: cabang
            },
            success: function(res) {
                if (res.status === 'success') {
                    // Update Summary Cards
                    $('#card-total-omset').text(res.summary.total_omset);
                    $('#card-total-target').text(res.summary.total_target);
                    $('#card-persen-pencapaian').text(res.summary.persen_pencapaian);
                    $('#card-total-transaksi').text(res.summary.total_transaksi);

                    // Render Grafik & Tabel
                    renderMonthlyChart(res.chart_monthly, tahun1, tahun2);
                    renderTipeChart(res.chart_tipe);
                    renderTopKelompok(res.top_kelompok);
                }
            },
            error: function() {
                alert('Gagal mengambil data dashboard!');
            }
        });
    }

    // Grafik Garis: Garis Solid = Realisasi Omset, Garis Putus-Putus = Target Bulanan
    function renderMonthlyChart(chartData, thn1, thn2) {
        const ctx = document.getElementById('monthlyTrendChart').getContext('2d');

        if (monthlyChart) {
            monthlyChart.destroy();
        }

        let datasets = [];

        // 1. Omset Realisasi Tahun 1 (Garis Kuning Solid)
        if (chartData.omset_tahun_1) {
            datasets.push({
                label: 'Omset ' + thn1,
                data: chartData.omset_tahun_1,
                borderColor: COLOR_TAHUN_1,
                backgroundColor: COLOR_TAHUN_1,
                borderWidth: 3,
                tension: 0.3,
                fill: false,
                pointRadius: 4
            });
        }

        // 2. Target Bulanan Tahun 1 (Garis Kuning Putus-Putus)
        if (chartData.target_tahun_1) {
            datasets.push({
                label: 'Target ' + thn1,
                data: chartData.target_tahun_1,
                borderColor: COLOR_TAHUN_1,
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 2,
                fill: false
            });
        }

        // 3. Omset Realisasi Tahun 2 (Garis Biru Solid)
        if (thn2 && chartData.omset_tahun_2) {
            datasets.push({
                label: 'Omset ' + thn2,
                data: chartData.omset_tahun_2,
                borderColor: COLOR_TAHUN_2,
                backgroundColor: COLOR_TAHUN_2,
                borderWidth: 3,
                tension: 0.3,
                fill: false,
                pointRadius: 4
            });
        }

        // 4. Target Bulanan Tahun 2 (Garis Biru Putus-Putus)
        if (thn2 && chartData.target_tahun_2) {
            datasets.push({
                label: 'Target ' + thn2,
                data: chartData.target_tahun_2,
                borderColor: COLOR_TAHUN_2,
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 2,
                fill: false
            });
        }

        monthlyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                }
            }
        });
    }

    // Doughnut Chart
    function renderTipeChart(data) {
        const ctx = document.getElementById('tipeOmsetChart').getContext('2d');

        if (tipeChart) {
            tipeChart.destroy();
        }

        tipeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#0dcaf0',
                        '#6c757d',
                        '#d63384'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Tabel Top 5 Kelompok Pelanggan
    function renderTopKelompok(list) {
        let html = '';
        if (!list || list.length === 0) {
            html = '<tr><td colspan="3" class="text-center text-muted">Tidak ada data</td></tr>';
        } else {
            list.forEach((item, index) => {
                html += `
                    <tr>
                        <td class="fw-bold">${index + 1}</td>
                        <td>${item.kel_pelanggan ?? '-'}</td>
                        <td class="text-end font-weight-bold text-success">
                            Rp ${Number(item.total).toLocaleString('id-ID')}
                        </td>
                    </tr>
                `;
            });
        }
        $('#top-kelompok-body').html(html);
    }
</script>
@endsection
