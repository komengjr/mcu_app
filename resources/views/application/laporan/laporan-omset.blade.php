@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Filter Laporan Omset</h6>
        </div>
        <div class="card-body">
            <form id="form-filter">
                @csrf
                <div class="row g-3">
                    <!-- Filter Tanggal Mulai -->
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" id="filter-tgl-mulai" class="form-control" value="{{ date('Y-m-01') }}">
                    </div>

                    <!-- Filter Tanggal Selesai -->
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Tanggal Selesai</label>
                        <input type="date" name="tgl_akhir" id="filter-tgl-akhir" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Filter Cabang -->
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Cabang</label>
                        <select name="cabang" id="filter-cabang" class="form-select choices-select">
                            <option value="">-- ALL / Semua Cabang --</option>
                            @foreach($listCabang as $cbg)
                            <option value="{{ $cbg->master_cabang_code }}">
                                {{ $cbg->master_cabang_name }} ({{ $cbg->master_cabang_code }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Kelompok Pelanggan -->
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Kelompok Pelanggan</label>
                        <select name="kel_pelanggan" id="filter-kelompok" class="form-select choices-select">
                            <option value="">-- ALL / Semua Kelompok --</option>
                            @foreach($listKelompok as $kelompok)
                            <option value="{{ $kelompok }}">{{ $kelompok }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Button Preview -->
                    <div class="col-12 text-end">
                        <button type="button" id="btn-preview-filter" class="btn btn-primary px-4">
                            <i class="fas fa-search me-1"></i> Preview
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Data Table Result Section -->
    <div class="card d-none" id="result-section">
        <div class="card-header pb-0">
            <h6>Data Laporan Omset</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-laporan" class="table table-striped table-bordered dt-responsive w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Cabang</th>
                            <th>Tanggal</th>
                            <th>NoReg</th>
                            <th>Pasien</th>
                            <th>Kel. Pelanggan</th>
                            <th>Tipe Omset</th>
                            <th>Bruto</th>
                            <th>Disc</th>
                            <th>Total</th>
                            <th>Pay</th>
                            <th>Jml Test</th>
                            <th>Pemeriksaan</th>
                        </tr>
                    </thead>
                    <tbody class="fs--2"></tbody>
                    <!-- BARIS TOTAL GAYA LAPORAN KEUANGAN -->
                    <tfoot class="table-secondary font-weight-bold fs--2">
                        <tr>
                            <th colspan="6" class="text-end">TOTAL KESELURUHAN:</th>
                            <th id="total-bruto" class="text-end">Rp 0.00</th>
                            <th id="total-disc" class="text-end">Rp 0.00</th>
                            <th id="total-grand" class="text-end">Rp 0.00</th>
                            <th id="total-pay" class="text-end">Rp 0.00</th>
                            <th id="total-jml-test" class="text-center">0</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

<script>
    let tableReport = null;

    document.addEventListener('DOMContentLoaded', function() {
        const choicesElements = document.querySelectorAll('.choices-select');
        choicesElements.forEach(el => new Choices(el, {
            removeItemButton: true,
            shouldSort: false
        }));
    });

    // Helper untuk format rupiah di footer
    function formatRupiah(amount) {
        return 'Rp ' + Number(amount).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Handle Event Klik Button Preview Filter
    $('#btn-preview-filter').on('click', function(e) {
        e.preventDefault();

        let tglMulaiVal = $('#filter-tgl-mulai').val();
        let tglAkhirVal = $('#filter-tgl-akhir').val();
        let cabangVal = $('#filter-cabang').val();
        let kelompokVal = $('#filter-kelompok').val();

        // Validasi range tanggal jika diisi salah satu
        if (tglMulaiVal && tglAkhirVal && tglMulaiVal > tglAkhirVal) {
            alert('Tanggal Mulai tidak boleh lebih besar dari Tanggal Selesai!');
            return;
        }

        let btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        $.ajax({
            url: "{{ route('laporan_data_kehadiran_filter') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                tgl_mulai: tglMulaiVal,
                tgl_akhir: tglAkhirVal,
                cabang: cabangVal,
                kel_pelanggan: kelompokVal
            },
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fas fa-search me-1"></i> Preview');

                if (res.status === 'success') {
                    $('#result-section').removeClass('d-none');

                    if ($.fn.DataTable.isDataTable('#table-laporan')) {
                        $('#table-laporan').DataTable().clear().destroy();
                    }

                    tableReport = $('#table-laporan').DataTable({
                        data: res.data,
                        responsive: true,
                        columns: [{
                                data: 'cabang',
                                defaultContent: '-'
                            },
                            {
                                data: 'tanggal',
                                render: function(data) {
                                    return data ? data.substring(0, 10) : '-';
                                }
                            },
                            {
                                data: 'noreg',
                                defaultContent: '-'
                            },
                            {
                                data: 'pasien',
                                defaultContent: '-'
                            },
                            {
                                data: 'kel_pelanggan',
                                defaultContent: '-'
                            },
                            {
                                data: 'tipe_omset',
                                defaultContent: '-'
                            },
                            {
                                data: 'bruto',
                                className: 'text-end',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'disc',
                                className: 'text-end',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'total',
                                className: 'text-end',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'pay',
                                className: 'text-end',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
                            },
                            {
                                data: 'jml_test',
                                className: 'text-center',
                                defaultContent: '0'
                            },
                            {
                                data: 'pemeriksaan',
                                defaultContent: '-'
                            }
                        ],
                        footerCallback: function(row, data, start, end, display) {
                            let api = this.api();

                            let parseNum = function(i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ? i : 0;
                            };

                            let totalBruto = api.column(6, {
                                    page: 'all'
                                }).data()
                                .reduce((a, b) => parseNum(a) + parseNum(b), 0);

                            let totalDisc = api.column(7, {
                                    page: 'all'
                                }).data()
                                .reduce((a, b) => parseNum(a) + parseNum(b), 0);

                            let totalGrand = api.column(8, {
                                    page: 'all'
                                }).data()
                                .reduce((a, b) => parseNum(a) + parseNum(b), 0);

                            let totalPay = api.column(9, {
                                    page: 'all'
                                }).data()
                                .reduce((a, b) => parseNum(a) + parseNum(b), 0);

                            let totalTest = api.column(10, {
                                    page: 'all'
                                }).data()
                                .reduce((a, b) => parseNum(a) + parseNum(b), 0);

                            $('#total-bruto').html(formatRupiah(totalBruto));
                            $('#total-disc').html(formatRupiah(totalDisc));
                            $('#total-grand').html(formatRupiah(totalGrand));
                            $('#total-pay').html(formatRupiah(totalPay));
                            $('#total-jml-test').html(totalTest.toLocaleString('en-US'));
                        }
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-search me-1"></i> Preview');
                alert('Gagal mengambil data laporan: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    });
</script>
@endsection
