@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* Custom Styling Header & Soft Badges */
    .bg-gradient-danger-custom {
        background: linear-gradient(135deg, #e63757 0%, #b80924 100%);
    }

    .bg-soft-primary {
        background-color: #e0f2fe !important;
    }

    .bg-soft-danger {
        background-color: #ffe5e7 !important;
    }

    .bg-soft-success {
        background-color: #dcfce7 !important;
    }

    .bg-soft-info {
        background-color: #e0e7ff !important;
    }

    .bg-soft-warning {
        background-color: #fef3c7 !important;
    }

    .bg-soft-dark {
        background-color: #f1f5f9 !important;
    }

    /* Custom Table Style */
    .table-custom thead th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }

    .table-custom tbody tr:hover {
        background-color: #f8fafc !important;
    }

    /* Mengatur jarak kontrol DataTables agar tetap rapi walau padding tabel 0 */
    div.dt-container div.dt-layout-row {
        padding-left: 1rem;
        padding-right: 1rem;
    }
</style>
@endsection

@section('content')
<!-- Header Banner Modern -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 bg-gradient-danger-custom text-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-white bg-opacity-20 rounded-3 me-3">
                                <img src="{{ asset('img/company.png') }}" alt="Logo" width="45" />
                            </div>
                            <div>
                                <h6 class="text-white-50 text-uppercase fw-semibold mb-0 fs--1">Management System</h6>
                                <h2 class="text-white fw-bold mb-0">Medical Monitoring Hasil</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-white text-danger fs--1 px-3 py-2 rounded-2 shadow-sm">
                            <i class="fas fa-notes-medical me-1"></i> Registrasi & Monitoring
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom p-3">
        <div class="row align-items-center justify-content-between">
            <div class="col">
                <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-list text-danger me-2"></i>List Pasien</h5>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-danger rounded-1 me-2 px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-registrasi-pasien" data-code="123">
                        <i class="far fa-edit me-1"></i> Registrasi Pasien
                    </button>
                    <button class="btn btn-sm btn-outline-danger rounded-1 px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-order-kurir" data-code="123">
                        <i class="fas fa-qrcode me-1"></i> Order Kurir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Container Tabel dengan px-0 agar Tampilan Full Width / Luas -->
    <div class="card-body px-0 py-3">
        <div class="table-responsive">
            <table id="example" class="table table-custom align-middle fs--1 w-100 mb-0">
                <thead>
                    <tr>
                        <th width="3%" class="ps-3">No</th>
                        <th width="16%">Nama Pasien / No Reg</th>
                        <th width="10%">JK</th>
                        <th width="9%">Tgl Lahir</th>
                        <th width="11%">Tgl Order</th>
                        <th width="18%">Pemeriksaan</th>
                        <th width="13%">Pengambilan Sample</th>
                        <th width="10%">Proses Sample</th>
                        <th width="9%" class="text-center">Status</th>
                        <th width="8%" class="text-center pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Load Data via AJAX DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-mcu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-mcu-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu-xl"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable Client-side AJAX
        var table = $('#example').DataTable({
            responsive: true,
            ajax: {
                url: "{{ route('registrasi_pasien_get_data') }}", // Ganti sesuai nama route method getData controller Anda
                type: "GET",
                dataSrc: "data"
            },
            language: {
                processing: '<div class="spinner-border text-danger my-3" role="status"><span class="visually-hidden">Loading...</span></div>'
            },
            columns: [{
                    data: 'no',
                    className: 'ps-3'
                },
                {
                    data: 'nama_reg'
                },
                {
                    data: 'jk'
                },
                {
                    data: 'tgl_lahir'
                },
                {
                    data: 'tgl_order'
                },
                {
                    data: 'pemeriksaan'
                },
                {
                    data: 'sample'
                },
                {
                    data: 'proses'
                },
                {
                    data: 'status',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    className: 'text-center pe-3',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

        // 1. Modal Registrasi Pasien
        $(document).on("click", "#button-registrasi-pasien", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-mcu-xl').html(
                '<div class="text-center my-5"><div class="spinner-border text-danger" role="status"></div><p class="mt-2 text-muted">Memuat Form...</p></div>'
            );
            $.ajax({
                url: "{{ route('registrasi_pasien_add_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function() {
                $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Terjadi Kesalahan saat memuat form.</div>');
            });
        });

        // 2. Modal Order Kurir
        $(document).on("click", "#button-order-kurir", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-mcu-xl').html(
                '<div class="text-center my-5"><div class="spinner-border text-danger" role="status"></div><p class="mt-2 text-muted">Memuat Form...</p></div>'
            );
            $.ajax({
                url: "{{ route('monitoring_hasil_order_kurir') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function() {
                $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Terjadi Kesalahan saat memuat form.</div>');
            });
        });

        // 3. Modal Detail Order Pasien
        $(document).on("click", "#button-detail-order-pasien", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-mcu').html(
                '<div class="text-center my-5"><div class="spinner-border text-danger" role="status"></div><p class="mt-2 text-muted">Memuat Detail Pasien...</p></div>'
            );
            $.ajax({
                url: "{{ route('monitoring_hasil_detail_pasien') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-mcu').html(data);
            }).fail(function() {
                $('#menu-mcu').html('<div class="alert alert-danger m-3">Terjadi Kesalahan saat memuat detail.</div>');
            });
        });

        // 4. Action Pilih & Remove Pemeriksaan
        $(document).on("click", "#button-pilih-pemeriksaan-pasien", function(e) {
            e.preventDefault();
            var data_registrasi = document.getElementById('token_registrasi').value;
            var data_pemeriksaan = document.getElementById('data_pemeriksaan').value;
            const nama = document.getElementById('nama_lengkap').value;
            const tgl_lahir = document.getElementById('tgl_lahir').value;
            const jk = document.getElementById('jk').value;

            if (nama == "" || tgl_lahir == "" || jk == "" || data_pemeriksaan == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Nama, Jenis Kelamin, dan Tanggal Lahir Isi Terlebih dahulu",
                });
            } else {
                $('#table-pemeriksaan-pasien').html(
                    '<div class="text-center my-3"><div class="spinner-border text-primary spinner-border-sm" role="status"></div> Loading...</div>'
                );
                $.ajax({
                    url: "{{ route('monitoring_hasil_save_pemeriksaan') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "data_registrasi": data_registrasi,
                        "data_pemeriksaan": data_pemeriksaan
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#table-pemeriksaan-pasien').html(data);
                }).fail(function() {
                    $('#table-pemeriksaan-pasien').html('<div class="text-danger p-2">Gagal memuat item pemeriksaan.</div>');
                });
            }
        });

        $(document).on("click", "#button-remove-pemeriksaan_pasien", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            var reg = $(this).data("reg");
            $('#table-pemeriksaan-pasien').html(
                '<div class="text-center my-3"><div class="spinner-border text-primary spinner-border-sm" role="status"></div> Removing...</div>'
            );
            $.ajax({
                url: "{{ route('monitoring_hasil_remove_pemeriksaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "reg": reg
                },
                dataType: 'html',
            }).done(function(data) {
                $('#table-pemeriksaan-pasien').html(data);
            }).fail(function() {
                $('#table-pemeriksaan-pasien').html('<div class="text-danger p-2">Gagal menghapus item.</div>');
            });
        });

        // 5. Save Data Pasien Submit & Auto Close Modal
        $(document).on("click", "#button-save-data-pasien", function(e) {
            e.preventDefault();
            $('#loading-button').html(
                '<button class="btn btn-primary" type="button" disabled=""><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...</button>'
            );

            const nama = document.getElementById('nama_lengkap').value;
            const tgl_lahir = document.getElementById('tgl_lahir').value;
            const jk = document.getElementById('jk').value;
            const nama_rujukan = document.getElementById('nama_rujukan').value;

            if (nama == "" || tgl_lahir == "" || jk == "" || nama_rujukan == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Nama, Jenis Kelamin, Tanggal Lahir, dan Nama Perujuk Tidak boleh kosong"
                });
                $('#loading-button').html(
                    '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save me-1"></span> Simpan & Kirim</button>'
                );
            } else {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success me-2",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: true
                });

                swalWithBootstrapButtons.fire({
                    title: "Apakah Kamu yakin Untuk Simpan?",
                    text: "Data registrasi pasien akan disimpan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "YA, Simpan",
                    cancelButtonText: "Tidak, Batal!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $("#form-add-pasien").serialize();
                        $.ajax({
                            url: "{{ route('registrasi_pasien_save_data') }}",
                            type: "POST",
                            cache: false,
                            data: data,
                            dataType: 'html',
                        }).done(function(data) {
                            if (data == 1) {
                                // Close modal secara otomatis
                                $('#modal-mcu-xl').modal('hide');

                                Swal.fire({
                                    icon: "success",
                                    title: "Sukses!",
                                    text: "Your data has been Success.",
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Reload tabel DataTables tanpa merefresh halaman
                                table.ajax.reload();
                            } else {
                                swalWithBootstrapButtons.fire({
                                    title: "Gagal Menyimpan",
                                    text: "Pastikan Data Pemeriksaan Sudah terisi jangan sampai kosong yaa",
                                    icon: "error"
                                });
                                $('#loading-button').html(
                                    '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save me-1"></span> Simpan & Kirim</button>'
                                );
                            }
                        }).fail(function() {
                            swalWithBootstrapButtons.fire({
                                title: "Cancelled",
                                text: "Failed to save data",
                                icon: "error"
                            });
                            $('#loading-button').html(
                                '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save me-1"></span> Simpan & Kirim</button>'
                            );
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        $('#loading-button').html(
                            '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save me-1"></span> Simpan & Kirim</button>'
                        );
                    }
                });
            }
        });
    });
</script>
@endsection
