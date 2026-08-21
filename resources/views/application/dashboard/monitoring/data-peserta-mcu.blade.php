<style>
    /* Styling khusus Datatable Modal Detail MCU */
    #table-detail-peserta-mcu {
        border-collapse: separate !important;
        border-spacing: 0;
    }

    #table-detail-peserta-mcu thead th {
        background-color: #0c7bea !important;
        color: #f2f4f7 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #edf2f9 !important;
        padding: 12px;
    }

    #table-detail-peserta-mcu tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f9;
        font-size: 0.82rem;
    }

    #table-detail-peserta-mcu tbody tr:hover {
        background-color: rgba(44, 123, 229, 0.03) !important;
    }

    .modal-header-gradient {
        background: linear-gradient(135deg, #2c7be5 0%, #1a5bb8 100%);
    }
</style>

<div class="modal-body p-0 overflow-hidden">
    <!-- Header Modal Modern -->
    <div class="modal-header-gradient p-4 position-relative">
        <div class="d-flex align-items-center me-4">
            <div class="p-3 bg-white bg-opacity-10 rounded-3 text-dark me-3">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <div>
                <span class="badge bg-soft-light text-dark rounded-pill px-2 py-1 mb-1 fs--2 fw-semibold">
                    <i class="fas fa-file-medical me-1"></i> Daftar Peserta MOU
                </span>
                <h5 class="mb-0 text-white fw-bold fs-1" id="staticBackdropLabel">
                    {{ $data->master_company_name }}
                </h5>
                <p class="text-warning fs--1 mb-0">
                    <i class="fas fa-file-contract me-1"></i>{{ $data->company_mou_name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="p-3 p-md-4 bg-white">
        <div class="table-responsive">
            <table id="table-detail-peserta-mcu" class="table table-hover w-100 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th style="width: 15%">NIP / NIK</th>
                        <th style="width: 20%">Nama Peserta</th>
                        <th style="width: 15%">TTL</th>
                        <th class="text-center" style="width: 12%">Gender</th>
                        <th style="width: 13%">Departemen</th>
                        <th style="width: 20%">Status & Lokasi MCU</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#table-detail-peserta-mcu')) {
            $('#table-detail-peserta-mcu').DataTable().destroy();
        }

        var table = $('#table-detail-peserta-mcu').DataTable({
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                processing: '<div class="spinner-border text-primary spinner-border-sm" role="status"></div> <span class="ms-2">Memuat data...</span>',
                search: "_INPUT_",
                searchPlaceholder: "Cari NIP, NIK, Nama, Dept...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ peserta",
                infoEmpty: "Tidak ada data tersedia",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            },
            ajax: {
                url: "{{ route('monitoring_mcu_detail_table', ['id' => $code]) }}",
                type: "GET"
            },
            columns: [{
                    data: 'id',
                    className: 'text-center fw-bold text-600'
                },
                {
                    data: 'nip'
                },
                {
                    data: 'nama_peserta'
                },
                {
                    data: 'ttl'
                },
                {
                    data: 'jk',
                    className: 'text-center'
                },
                {
                    data: 'departemen'
                },
                {
                    data: 'status'
                }
            ]
        });
    });
</script>
