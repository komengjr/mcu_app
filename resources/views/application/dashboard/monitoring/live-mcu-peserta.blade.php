<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white"><i class="fas fa-satellite-dish me-2"></i> Live Monitoring MCU Peserta</h4>
        <p class="fs--2 mb-0 text-white">Data diperbarui otomatis secara realtime (Update Terbaru di Atas)</p>
    </div>
    <div class="p-4">
        <!-- Live Status Card Header -->
        <div class="row g-3 mb-3">
            <div class="col-md-6 col-lg-4">
                <div class="card bg-soft-primary border border-primary">
                    <div class="card-body py-3">
                        <h6 class="text-primary fw-semi-bold mb-1">Peserta Sedang MCU</h6>
                        <h3 class="text-primary mb-0"><span id="live-total-count">0</span> Orang</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-8 text-end d-flex align-items-center justify-content-end">
                <!-- <span class="badge badge-soft-success fs-0 p-2 me-2">
                    <i class="fas fa-sync-alt fa-spin me-1"></i> Auto Refresh Live (3s)
                </span> -->
            </div>
        </div>

        <!-- Table Live Peserta -->
        <div class="card border">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="table-live-peserta" class="table table-striped table-bordered fs--1 mb-0 w-100">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th>No</th>
                                <th>Peserta</th>
                                <th>Cabang / Lokasi</th>
                                <th>Check-In / Update Terakhir</th>
                                <th>Progress MCU</th>
                                <th>Detail Pemeriksaan & Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var code = "{{ $code }}";

        fetchLiveMcuData();

        if (window.liveInterval) clearInterval(window.liveInterval);
        window.liveInterval = setInterval(function() {
            if ($('#table-live-peserta').length > 0 && $('#modal-monitoring').is(':visible')) {
                fetchLiveMcuData();
            } else {
                clearInterval(window.liveInterval);
            }
        }, 3000);

        function fetchLiveMcuData() {
            $.ajax({
                url: "{{ route('monitoring_mcu_live_mcu_peserta') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "type": "data"
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'success') {
                        $('#live-total-count').text(res.total_sedang_mcu);
                        renderLiveTable(res.data);
                    }
                }
            });
        }

        function renderLiveTable(data) {
            let rows = '';

            data.forEach((p, idx) => {
                let pemList = '<div class="d-flex flex-wrap gap-1">';

                p.list_pemeriksaan.forEach(pem => {
                    // Logika Warna Badge:
                    // Jika ada waktu selesainya -> bg-primary
                    // Jika tidak ada waktunya -> bg-dark (gelap)
                    let badgeClass = pem.waktu_selesai ? 'bg-primary' : 'bg-dark';

                    let icon = pem.waktu_selesai ?
                        'fa-check-circle' :
                        (pem.status === 0 ? 'fa-spinner fa-spin' : 'fa-minus-circle');

                    let jamTxt = pem.waktu_selesai ? ` <span class="fw-bold">(${pem.waktu_selesai})</span>` : '';

                    pemList += `<span class="badge ${badgeClass} fs--2 p-1 me-1 mb-1">
                            <i class="fas ${icon} me-1"></i>${pem.nama}${jamTxt}
                        </span>`;
                });

                pemList += '</div>';

                let progressColor = p.progress_percent === 100 ? 'bg-success' : 'bg-primary';

                rows += `
            <tr>
                <td class="text-center">${idx + 1}</td>
                <td>
                    <strong>${p.name}</strong><br>
                    <small class="text-muted">NIK: ${p.nik} (${p.jk})</small>
                </td>
                <td>${p.cabang}</td>
                <td>
                    <small>Check-in: ${p.waktu_checkin}</small><br>
                    <span class="badge bg-soft-info text-dark fs--2"><i class="fas fa-clock me-1"></i>${p.aktivitas_terakhir}</span>
                </td>
                <td style="min-width: 140px;">
                    <div class="d-flex justify-content-between fs--2 mb-1">
                        <span>${p.selesai_pemeriksaan}/${p.total_pemeriksaan} Selesai</span>
                        <span class="fw-bold">${p.progress_percent}%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar ${progressColor}" role="progressbar" style="width: ${p.progress_percent}%"></div>
                    </div>
                </td>
                <td>${pemList}</td>
            </tr>`;
            });

            if ($.fn.DataTable.isDataTable('#table-live-peserta')) {
                $('#table-live-peserta').DataTable().destroy();
            }
            $('#table-live-peserta tbody').html(rows);
            new DataTable('#table-live-peserta', {
                responsive: true,
                pageLength: 10,
                ordering: false, // Urutan tetap dari server (created_at terbaru di paling atas)
                stateSave: true
            });
        }
    })();
</script>
