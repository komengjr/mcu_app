<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Rekap Full MCU</h4>
        <p class="fs--2 mb-0 text-white">Support by Transforma</p>
    </div>
    <div class="p-4">
        <div class="card mb-3">
            <div class="card-header bg-danger">
                <h4 class="mb-0 text-white"><span class="badge bg-danger">REKAP PROJECT</span></h4>
            </div>
            <div class="card-body bg-light border-top">
                <div class="row g-3 pb-3">
                    <div class="col-lg-4">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informasi Perusahaan</h6>
                            <p class="mb-1"><strong>Nama:</strong> <span id="txt-company-name">-</span></p>
                            <p class="mb-1"><strong>Wilayah:</strong> <span id="txt-company-wilayah">-</span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="txt-company-email">-</span></p>
                            <p class="mb-0"><strong>Phone:</strong> <span id="txt-company-phone">-</span></p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informasi Project</h6>
                            <p class="mb-1"><strong>Nama Project:</strong> <span id="txt-mou-name">-</span></p>
                            <p class="mb-1"><strong>Total Peserta:</strong> <span id="txt-total-peserta-1">0</span> Peserta</p>
                            <p class="mb-0"><strong>Tanggal MCU:</strong> <span id="txt-mou-start">-</span></p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card p-4 border border-danger">
                            <h6 class="fw-semi-bold ls mb-3 text-uppercase">Status Peserta MCU</h6>
                            <p class="mb-1"><strong>Total Peserta:</strong> <span id="txt-total-peserta-2">0</span> Peserta</p>
                            <p class="mb-1"><strong>Sudah MCU:</strong> <span id="txt-total-mcu">0</span> Peserta</p>
                            <p class="mb-1"><strong>Belum MCU:</strong> <span id="txt-sisa-mcu">0</span> Peserta</p>
                            <p class="mb-0"><strong>Persentase:</strong> <span id="txt-persentase">0</span> %</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="card border border-danger">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 text-700 fw-bold"><i class="fas fa-chart-bar me-1"></i> Grafik Jumlah Peserta per Wilayah</h6>
                            </div>
                            <!-- Container Chart -->
                            <div class="echart-pie-chart-example p-3" style="min-height: 380px;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card p-2 border border-danger">
                            <h6 class="fw-semi-bold text-uppercase mb-2">Informasi Cabang</h6>
                            <table id="table-cabang" class="table table-bordered table-striped fs--1 mb-0 w-100">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th>Wilayah</th>
                                        <th>Nama Cabang</th>
                                        <th>Peserta Check In</th>
                                        <th>Executive</th>
                                        <th>Persentasi</th>
                                        <th>Healthy Talk</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container Accordion Group Peserta -->
        <div id="container-group-peserta">
            <div class="text-center py-4">
                <div class="spinner-border text-danger" role="status"></div>
                <p class="mt-2 text-600">Memuat data realtime...</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
<script>
    (function() {
        var activeCode = "{{ $code }}";

        fetchRekapRealtime(activeCode);

        function fetchRekapRealtime(code) {
            $.ajax({
                url: "{{ route('monitoring_mcu_rekap_full') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "type": "data"
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'success') {
                        let d = res.data;
                        $('#txt-company-name').text(d.company.master_company_name);
                        $('#txt-company-wilayah').text(d.company.master_company_wilayah || '-');
                        $('#txt-company-email').text(d.company.master_company_email || '-');
                        $('#txt-company-phone').text(d.company.master_company_phone || '-');
                        $('#txt-mou-name').text(d.company.company_mou_name);
                        $('#txt-mou-start').text(d.company.company_mou_start);
                        $('#txt-total-peserta-1, #txt-total-peserta-2').text(d.totalpeserta);
                        $('#txt-total-mcu').text(d.totalmcu);
                        $('#txt-sisa-mcu').text(d.sisa_mcu);
                        $('#txt-persentase').text(d.persentase);

                        renderTableCabang(d.cabang);
                        renderGroupsPeserta(d.groups);
                        renderChart(d.groupChart);
                    }
                }
            });
        }

        function renderTableCabang(cabangList) {
            // Cek apakah ada minimal satu data yang bernilai aktif/melakukan (bukan null, kosong, atau 'belum')
            let hasExecutive = cabangList.some(c => c.summary_cabang_executive !== null && c.summary_cabang_executive !== '' && c.summary_cabang_executive !== undefined);
            let hasPersentasi = cabangList.some(c => c.summary_cabang_pesentasi !== null && c.summary_cabang_pesentasi !== '' && c.summary_cabang_pesentasi !== undefined);
            let hasHealthyTalk = cabangList.some(c => c.summary_cabang_ht !== null && c.summary_cabang_ht !== '' && c.summary_cabang_ht !== undefined);

            // 1. Render Header Tabel secara Dinamis
            let headerHtml = `
                <tr>
                    <th>Wilayah</th>
                    <th>Nama Cabang</th>
                    <th>Peserta Check In</th>
                    ${hasExecutive ? '<th>Executive</th>' : ''}
                    ${hasPersentasi ? '<th>Persentasi</th>' : ''}
                    ${hasHealthyTalk ? '<th>Healthy Talk</th>' : ''}
                </tr>`;
            $('#table-cabang thead').html(headerHtml);

            // 2. Render Isi Baris Data secara Dinamis sesuai kolom yang aktif
            let rows = '';
            cabangList.forEach(c => {
                rows += `
                    <tr>
                        <td>${c.group_cabang_name}</td>
                        <td>${c.master_cabang_name}</td>
                        <td>${c.total_checkin} Peserta</td>
                        ${hasExecutive ? `<td>${getBadge(c.summary_cabang_executive)}</td>` : ''}
                        ${hasPersentasi ? `<td>${getBadge(c.summary_cabang_pesentasi)}</td>` : ''}
                        ${hasHealthyTalk ? `<td>${getBadge(c.summary_cabang_ht)}</td>` : ''}
                    </tr>`;
            });

            // 3. Re-inisialisasi DataTable
            if ($.fn.DataTable.isDataTable('#table-cabang')) {
                $('#table-cabang').DataTable().destroy();
            }
            $('#table-cabang tbody').html(rows);
            new DataTable('#table-cabang', {
                responsive: true,
                pageLength: 5,
                stateSave: true
            });
        }

        // Fungsi helper untuk badge status
        function getBadge(val) {
            if (val === 1 || val === '1') return '<span class="badge bg-primary">Done</span>';
            if (val === 0 || val === '0') return '<span class="badge bg-warning">Skip</span>';
            if (val && val !== '') return `<span class="badge bg-info">${val}</span>`;
            return '<span class="text-muted">-</span>';
        }

        function renderGroupsPeserta(groups) {
            let html = '<div class="accordion" id="accordionGroupPeserta">';

            groups.forEach((group, gIdx) => {
                let accordionId = `collapse-group-${gIdx}`;
                let headingId = `heading-group-${gIdx}`;

                html += `
                <div class="accordion-item border border-danger mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="${headingId}">
                        <button class="accordion-button bg-soft-danger text-danger fw-bold py-3 collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#${accordionId}"
                                aria-expanded="false"
                                aria-controls="${accordionId}">
                            <i class="fas fa-map-marker-alt me-2"></i> Wilayah ${group.group_cabang_name}
                        </button>
                    </h2>
                    <div id="${accordionId}"
                         class="accordion-collapse collapse"
                         aria-labelledby="${headingId}"
                         data-bs-parent="#accordionGroupPeserta">
                        <div class="accordion-body p-3 bg-light">`;

                group.cabang_list.forEach(cabang => {
                    html += `
                        <div class="card mb-3 border shadow-sm">
                            <div class="card-header bg-200 py-2">
                                <h6 class="mb-0 fw-bold text-700"><i class="fas fa-building me-1"></i> ${cabang.master_cabang_name}</h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table id="data-${cabang.id_master_cabang}" class="table table-striped nowrap border w-100">
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
                                        <tbody class="fs--2">`;

                    cabang.peserta.forEach((p, idx) => {
                        let pemList = '<ul class="ps-3 mb-0">';
                        p.list_pemeriksaan.forEach(pem => {
                            let icon = pem.status === 1 ?
                                '<span class="fas fa-check-square text-success"></span>' :
                                (pem.status === 0 ? '<span class="fas fa-exclamation-circle text-warning"></span>' : '<span class="fas fa-window-close text-danger"></span>');
                            pemList += `<li>${pem.nama} ${icon}</li>`;
                        });
                        pemList += '</ul>';

                        html += `
                            <tr>
                                <td>${idx + 1}</td>
                                <td>${p.mou_peserta_name}</td>
                                <td>${p.mou_peserta_nik}</td>
                                <td>${p.mou_peserta_jk}</td>
                                <td>${pemList}</td>
                                <td>${p.is_pengiriman ? '<span class="badge bg-primary">Selesai</span>' : '<span class="badge bg-danger">Belum Selesai</span>'}</td>
                                <td>${p.is_konsul ? '<span class="badge bg-primary">Selesai</span>' : '<span class="badge bg-danger">Belum Selesai</span>'}</td>
                            </tr>`;
                    });

                    html += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;
                });

                html += `
                        </div>
                    </div>
                </div>`;
            });

            html += '</div>';

            $('#container-group-peserta').html(html);

            groups.forEach(group => {
                group.cabang_list.forEach(cabang => {
                    let id = `#data-${cabang.id_master_cabang}`;
                    if ($.fn.DataTable.isDataTable(id)) {
                        $(id).DataTable().destroy();
                    }
                    new DataTable(id, {
                        responsive: true,
                        stateSave: true
                    });
                });
            });
        }

        // Render Modern Bar Chart (Grafik Batang)
        // Render Modern Bar Chart dengan Warna Berbeda Tiap Wilayah
        function renderChart(chartData) {
            var $chartEl = document.querySelector('.echart-pie-chart-example');
            if ($chartEl) {
                var existingChart = window.echarts.getInstanceByDom($chartEl);
                if (existingChart) existingChart.dispose();

                var chart = window.echarts.init($chartEl);

                var categories = chartData.map(g => g.group_cabang_name);
                var values = chartData.map(g => g.total);

                // Daftar palet warna modern yang berbeda untuk setiap batang
                var colorPalette = [
                    ['#2c7be5', '#66b0ff'], // Biru
                    ['#e63757', '#f2788f'], // Merah
                    ['#00d27a', '#3ee99b'], // Hijau
                    ['#f5803e', '#f9ab7c'], // Oranye
                    ['#6e84a3', '#9dafcb'], // Abu-abu / Slate
                    ['#27bcfd', '#6cd4fd'], // Cyan
                    ['#727cf5', '#9b9ff9']  // Indigo
                ];

                var seriesData = chartData.map((g, i) => {
                    var colors = colorPalette[i % colorPalette.length];
                    return {
                        value: g.total,
                        itemStyle: {
                            color: new window.echarts.graphic.LinearGradient(0, 0, 0, 1, [
                                { offset: 0, color: colors[0] }, // Warna atas
                                { offset: 1, color: colors[1] }  // Warna bawah (gradasi)
                            ]),
                            borderRadius: [6, 6, 0, 0] // Sudut atas melengkung
                        }
                    };
                });

                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        },
                        formatter: function(params) {
                            return params[0].name + '<br/>Jumlah Peserta: <b>' + params[0].value + '</b>';
                        }
                    },
                    grid: {
                        top: '15%',
                        bottom: '20%',
                        left: '10%',
                        right: '5%'
                    },
                    xAxis: {
                        type: 'category',
                        data: categories,
                        axisLabel: {
                            interval: 0,
                            rotate: categories.length > 4 ? 25 : 0,
                            textStyle: {
                                fontSize: 11
                            }
                        },
                        axisTick: {
                            alignWithLabel: true
                        }
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Jumlah Peserta',
                        nameTextStyle: {
                            padding: [0, 0, 0, 30]
                        }
                    },
                    series: [{
                        data: seriesData,
                        type: 'bar',
                        barWidth: '45%',
                        label: {
                            show: true,
                            position: 'top',
                            formatter: '{c}',
                            fontSize: 11,
                            fontWeight: 'bold',
                            color: '#5e6e82'
                        }
                    }]
                };

                chart.setOption(option);

                window.addEventListener('resize', function () {
                    chart.resize();
                });
            }
        }

        function getBadge(val) {
            if (val === 1) return '<span class="badge bg-primary">Done</span>';
            if (val === 0) return '<span class="badge bg-warning">Skip</span>';
            return '<span class="badge bg-danger">Belum</span>';
        }
    })();
</script>
