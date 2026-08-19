@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* Gradient Header Modern */
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

    /* Styling Header Tabel & Border */
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

    .table-custom tbody tr {
        transition: all 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* Mengatur padding filter & pagination DataTables agar tetap rapi meski padding tabel 0 */
    div.dt-container div.dt-layout-row {
        padding-left: 1rem;
        padding-right: 1rem;
    }
</style>
@endsection

@section('content')
<!-- Header Card Berwarna Modern -->
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
                                <h2 class="text-white fw-bold mb-0">Upload Hasil Pemeriksaan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-white text-danger fs--1 px-3 py-2 rounded-2 shadow-sm">
                            <i class="fas fa-vials me-1"></i> Monitoring Realtime
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Data Card -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom p-3">
        <div class="row align-items-center justify-content-between">
            <div class="col">
                <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-list text-danger me-2"></i>Daftar Hasil Pasien</h5>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-outline-danger rounded-2 px-3 shadow-sm dropdown-toggle" id="btnGroupVerticalDrop2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bars me-1"></i> Menu Master
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="btnGroupVerticalDrop2">
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-mcu" id="button-import-pasien-lama" data-code="123">
                            <i class="far fa-edit me-2 text-primary"></i> Import Pasien Lama
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container tanpa Padding Kiri & Kanan (px-0) agar Full Width -->
    <div class="card-body px-0 py-3">
        <div class="table-responsive">
            <table id="example" class="table table-custom align-middle fs--1 w-100 mb-0">
                <thead>
                    <tr>
                        <th width="3%" class="ps-3">No</th>
                        <th width="15%">Rujukan</th>
                        <th width="18%">Nama Pasien / No Reg</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="9%">Tgl Lahir</th>
                        <th width="18%">Pemeriksaan</th>
                        <th width="12%">Pengambilan Sample</th>
                        <th width="9%">Proses Sample</th>
                        <th width="8%" class="text-center">Status</th>
                        <th width="11%" class="text-center pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loaded via AJAX DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-mcu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div id="menu-mcu"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true,
            ajax: {
                url: "{{ route('master_upload_hasil_pemeriksaan_get_data') }}",
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
                    data: 'rujukan'
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

        // Event Edit Pasien Modal Loader
        $(document).on("click", "#button-edit-pasien", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-mcu').html(
                '<div class="text-center my-5"><div class="spinner-border text-danger" role="status"></div><p class="mt-2 text-muted">Memuat Form Edit...</p></div>'
            );
            $.ajax({
                url: "{{ route('master_upload_hasil_pemeriksaan_edit_pasien') }}",
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
                $('#menu-mcu').html('<div class="alert alert-danger m-3">Gagal memuat form edit.</div>');
            });
        });

        // Event Submit Update Pasien via AJAX
        $(document).on("submit", "#form-edit-pasien", function(e) {
            e.preventDefault();
            let btn = $('#btn-save-edit-pasien');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            $.ajax({
                url: "{{ route('master_upload_hasil_pemeriksaan_update_pasien') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                    if (res.status === 1) {
                        $('#modal-mcu').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#example').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                }
            });
        });
    });
</script>

<script>
    $(document).on("click", "#button-import-pasien-lama", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html(
            '<div class="text-center my-5"><div class="spinner-border text-danger" role="status"></div></div>'
        );
        $.ajax({
            url: "{{ route('master_upload_hasil_import_pasien_lama') }}",
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
            $('#menu-mcu').html('<div class="alert alert-danger m-3">Terjadi Kesalahan.</div>');
        });
    });

    $(document).on("click", "#button-detail-order-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html(
            '<div class="text-center my-5"><div class="spinner-border text-danger" role="status"></div></div>'
        );
        $.ajax({
            url: "{{ route('master_upload_hasil_pemeriksaan_detail') }}",
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
            $('#menu-mcu').html('<div class="alert alert-danger m-3">Terjadi Kesalahan.</div>');
        });
    });

    $(document).on("click", "#button-verif-test-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");
        $('#menu-verifikasi-test-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_upload_hasil_pemeriksaan_detail_verif') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-verifikasi-test-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-verifikasi-test-pemeriksaan').html('eror');
        });
    });

    $(document).on("click", "#button-unverif-test-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");
        $('#menu-verifikasi-test-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_upload_hasil_pemeriksaan_detail_unverif') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-verifikasi-test-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-verifikasi-test-pemeriksaan').html('eror');
        });
    });

    $(document).on("click", "#button-proses-data-pasien", function(e) {
        e.preventDefault();
        $('#loading-button').html(
            '<button class="btn btn-primary" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>'
        );
        const no_reg = document.getElementById('no_reg').value;

        if (no_reg == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No Registrasi Harus diisi",
                footer: "<a href=\"#\">Why do I have this issue?</a>"
            });
            $('#loading-button').html(
                '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
            );
        } else {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Apakah Kamu yakin Untuk Simpan?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "YA, Simpan",
                cancelButtonText: "Tidak, Batal!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = $("#form-proses-pasien").serialize();
                    $.ajax({
                        url: "{{ route('master_upload_hasil_pemeriksaan_detail_proses') }}",
                        type: "POST",
                        cache: false,
                        data: data,
                        dataType: 'html',
                    }).done(function(data) {
                        if (data == 1) {
                            // 1. Tutup modal secara otomatis
                            $('#modal-mcu').modal('hide');

                            // 2. Tampilkan notifikasi sukses (otomatis hilang dalam 1.5 detik)
                            Swal.fire({
                                icon: "success",
                                title: "Sukses!",
                                text: "Your Data has Been Success.",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // 3. Refresh data tabel DataTables
                            $('#example').DataTable().ajax.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Cancelled",
                                text: "Failed",
                                icon: "error"
                            });
                            $('#loading-button').html(
                                '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                            );
                        }

                    }).fail(function() {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Failed",
                            icon: "error"
                        });
                        $('#loading-button').html(
                            '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                        );
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Failed",
                        icon: "error"
                    });
                    $('#loading-button').html(
                        '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                    );
                }
            });
        }
    });
</script>
@endsection
