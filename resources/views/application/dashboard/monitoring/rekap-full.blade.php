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
                            <div class="echart-pie-chart-example p-3" style="min-height: 360px;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card p-2 border border-danger">
                            <h6 class="fw-semi-bold text-uppercase">Informasi Cabang</h6>
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
        var rekapInterval = null;

        // Fetch pertama kali
        fetchRekapRealtime(activeCode);

        // Timer Polling setiap 5 detik
        if (window.rekapInterval) clearInterval(window.rekapInterval);
        window.rekapInterval = setInterval(function() {
            if ($('#container-group-peserta').length > 0 && $('#modal-monitoring').is(':visible')) {
                fetchRekapRealtime(activeCode);
            } else {
                clearInterval(window.rekapInterval);
            }
        }, 5000);

        function fetchRekapRealtime(code) {
            $.ajax({
                url: "{{ route('monitoring_mcu_rekap_full') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "type": "data" // Memberi tahu controller bahwa ini adalah request JSON
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'success') {
                        let d = res.data;
                        // Header Text
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
                        // Render komponen
                        renderTableCabang(d.cabang);
                        renderGroupsPeserta(d.groups);
                        renderChart(d.groupChart);
                    }
                }
            });
        }

        function renderTableCabang(cabangList) {
            let rows = '';
            cabangList.forEach(c => {
                rows += `
                    <tr>
                        <td>${c.group_cabang_name}</td>
                        <td>${c.master_cabang_name}</td>
                        <td>${c.total_checkin} Peserta</td>
                        <td>${getBadge(c.summary_cabang_executive)}</td>
                        <td>${getBadge(c.summary_cabang_pesentasi)}</td>
                        <td>${getBadge(c.summary_cabang_ht)}</td>
                    </tr>`;
            });

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

        function renderGroupsPeserta(groups) {
            let html = '';
            groups.forEach(group => {
                html += `
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0 text-warning">Wilayah ${group.group_cabang_name}</h5>
                    </div>
                    <div class="card-body border-top p-0 px-1">`;

                group.cabang_list.forEach(cabang => {
                    html += `
                        <div class="card-body py-2 px-1">
                            <div class="card px-3 border">
                                <h6 class="pt-3">${cabang.master_cabang_name}</h6>
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
                        </div>`;
                });

                html += `</div></div>`;
            });

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

        function renderChart(chartData) {
            var $pieChartEl = document.querySelector('.echart-pie-chart-example');
            if ($pieChartEl) {
                var existingChart = window.echarts.getInstanceByDom($pieChartEl);
                if (existingChart) existingChart.dispose();

                var chart = window.echarts.init($pieChartEl);
                var colors = ['#2c7be5', '#e63757', '#6e84a3', '#f5803e', '#00d27a', '#27bcfd', '#39afd1'];

                var seriesData = chartData.map((g, i) => ({
                    value: g.total,
                    name: g.group_cabang_name,
                    itemStyle: {
                        color: colors[i % colors.length]
                    }
                }));

                chart.setOption({
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        left: 'left'
                    },
                    series: [{
                        type: 'pie',
                        radius: window.innerWidth < 530 ? '45%' : '60%',
                        center: ['50%', '55%'],
                        data: seriesData
                    }]
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
