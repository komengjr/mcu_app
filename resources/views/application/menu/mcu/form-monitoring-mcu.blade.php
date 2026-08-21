<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1" id="staticBackdropLabel">Daftar Monitoring MCU Cabang</h4>
            <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
        </div>
        <span class="badge bg-primary fs--1 me-3">Total Data: {{ count($peserta) }}</span>
    </div>

    <div id="report-kehadiran-mcu" class="p-3">
        <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
            <table id="data-moinitoring" class="table table-striped table-hover fs--2 border" style="width:100%">
                <thead class="bg-200 text-900 sticky-top" style="z-index: 2;">
                    <tr>
                        <th class="text-center align-middle" style="width: 30px;">NO</th>
                        <th class="align-middle">NIP</th>
                        <th class="align-middle" style="min-width: 140px;">NAMA PESERTA</th>
                        <th class="text-center align-middle">JK</th>
                        <th class="align-middle">DEPARTEMEN</th>
                        <th class="align-middle">WILAYAH</th>
                        <th class="align-middle">LOKASI MCU</th>
                        @foreach ($pem as $pems)
                        <th class="text-center align-middle px-2" style="white-space: nowrap;">
                            {{ $pems->master_pemeriksaan_name }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @foreach ($peserta as $index => $pes)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $pes->mou_peserta_nip ?? '-' }}</td>
                        <td class="fw-bold">{{ $pes->mou_peserta_name }}</td>
                        <td class="text-center">{{ $pes->mou_peserta_jk }}</td>
                        <td>{{ $pes->mou_peserta_departemen ?? '-' }}</td>
                        <td>{{ $pes->group_cabang_name ?? '-' }}</td>
                        <td>{{ $pes->master_cabang_name ?? '-' }}</td>

                        @foreach ($pem as $pems)
                        @php
                        $key = $pes->mou_peserta_code . '_' . $pems->master_pemeriksaan_code;
                        $status = $statusMap[$key] ?? null;
                        @endphp
                        <td class="text-center align-middle">
                            @if ($status)
                            @if ($status->log_pemeriksaan_status == 1)
                            <span style="color: green; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah Melakukan">✅</span>
                            @else
                            <span style="color: blue; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $status->log_pemeriksaan_deskripsi ?? 'Proses' }}">⚠️</span>
                            @endif
                            @else
                            <span style="color: red; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Belum Melakukan">❌</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Init Tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Config DataTable super cepat untuk ribuan baris
        $('#data-moinitoring').DataTable({
            responsive: false,
            deferRender: true,
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Semua"]
            ],
            layout: {
                topStart: {
                    buttons: [{
                            extend: 'excelHtml5',
                            className: 'btn btn-sm btn-success rounded-pill me-1',
                            text: 'Export Excel',
                            title: 'Data MCU {{ $data->master_company_name ?? '
                            ' }} - {{ $data->company_mou_name ?? '
                            ' }}'
                        },
                        {
                            extend: 'pdfHtml5',
                            className: 'btn btn-sm btn-danger rounded-pill',
                            orientation: 'landscape',
                            pageSize: 'A3',
                            text: 'Export PDF',
                            title: 'Data MCU {{ $data->master_company_name ?? '
                            ' }} - {{ $data->company_mou_name ?? '
                            ' }}'
                        }
                    ]
                }
            }
        });
    });
</script>
