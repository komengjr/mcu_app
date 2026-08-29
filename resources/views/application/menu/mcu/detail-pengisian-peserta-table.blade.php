@php
$sudahIsi = $peserta->where('is_completed', 1)->count();
$prosesIsi = $peserta->where('is_completed', 0)->whereNotNull('is_completed')->count();
$belumIsi = $peserta->whereNull('is_completed')->count();
@endphp

<!-- Box Ringkasan Statistics -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="d-flex gap-2 flex-wrap">
        <span class="badge bg-light text-700 border p-2 fs--1">Total: <b class="text-primary">{{ $peserta->count() }}</b></span>
        <span class="badge bg-light text-700 border p-2 fs--1">Selesai: <b class="text-success">{{ $sudahIsi }}</b></span>
        <span class="badge bg-light text-700 border p-2 fs--1">Draft: <b class="text-warning">{{ $prosesIsi }}</b></span>
        <span class="badge bg-light text-700 border p-2 fs--1">Belum Isi: <b class="text-danger">{{ $belumIsi }}</b></span>
    </div>
</div>

<!-- Tabel Data Peserta -->
<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered fs--1 mb-0" id="table-detail-peserta-mcu" style="width:100%">
        <thead class="bg-200 text-900">
            <tr>
                <th style="width: 35px;" class="text-center">No</th>
                <th>NIK</th>
                <th>NIP</th>
                <th>Nama Peserta</th>
                <th>Departemen</th>
                <th class="text-center">Tgl Pengisian</th>
                <th class="text-center" style="width: 110px;">Status</th>
                <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $p)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $p->mou_peserta_nik ?? '-' }}</td>
                <td>{{ $p->mou_peserta_nip ?? '-' }}</td>
                <td class="fw-semibold">{{ $p->mou_peserta_name }}</td>
                <td>{{ $p->mou_peserta_departemen ?? '-' }}</td>
                <td class="text-center">
                    {{ $p->tanggal_isi ? date('d/m/Y H:i', strtotime($p->tanggal_isi)) : '-' }}
                </td>
                <td class="text-center">
                    @if($p->is_completed === 1)
                    <span class="badge badge-soft-success rounded-pill px-2 py-1 fs--2">
                        <i class="fas fa-check-circle me-1"></i>Selesai
                    </span>
                    @elseif($p->is_completed === 0)
                    <span class="badge badge-soft-warning rounded-pill px-2 py-1 fs--2">
                        <i class="fas fa-clock me-1"></i>Draft
                    </span>
                    @else
                    <span class="badge badge-soft-danger rounded-pill px-2 py-1 fs--2">
                        <i class="fas fa-times-circle me-1"></i>Belum Isi
                    </span>
                    @endif
                </td>
                <td class="text-center">
                    @if($p->is_completed === 1)
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('medical_check_up_export_pdf_peserta', ['peserta_code' => $p->mou_peserta_code, 'id_mcu_form' => $idMcuForm]) }}"
                            class="btn btn-outline-danger p-1 px-2"
                            target="_blank"
                            title="Export Hasil Form PDF">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        <a href="{{ route('medical_check_up_export_excel_peserta', ['peserta_code' => $p->mou_peserta_code, 'id_mcu_form' => $idMcuForm]) }}"
                            class="btn btn-outline-success p-1 px-2"
                            target="_blank"
                            title="Export Hasil Form Excel">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </div>
                    @else
                    <span class="text-400 fs--2"><i>Belum ada data</i></span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        // Destroy instance lama jika ada (menghindari error Re-initialise DataTables saat AJAX reload)
        if ($.fn.DataTable.isDataTable('#table-detail-peserta-mcu')) {
            $('#table-detail-peserta-mcu').DataTable().destroy();
        }

        $('#table-detail-peserta-mcu').DataTable({
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Semua"]
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Tidak ada data peserta yang cocok",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ peserta",
                "infoEmpty": "Menampilkan 0 data",
                "infoFiltered": "(disaring dari _MAX_ total peserta)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "›",
                    "previous": "‹"
                }
            },
            "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 7]
                } // Matikan sorting pada kolom No & Aksi
            ]
        });
    });
</script>
