@extends('layouts.marketing')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Master Data Staff Marketing</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStaff">
            + Tambah Staff
        </button>
    </div>

    <!-- Alert Notifikasi AJAX -->
    <div id="alertContainer"></div>

    <!-- Card Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Staff & Target Bulan Ini</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="tableMarketingStaff" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>Cabang</th>
                            <th>NIK</th>
                            <th>Nama Staff</th>
                            <th>Jabatan</th>
                            <th>Target Omset</th>
                            <th>Komisi (%)</th>
                            <th>Tier Insentif</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                        @php
                        $currentTarget = $staff->targets->first();
                        @endphp
                        <tr id="row-{{ $staff->id }}">
                            <td>
                                @if($staff->cabang)
                                <strong>{{ $staff->cabang->nama_cabang }}</strong><br>
                                <small class="badge bg-secondary">{{ $staff->cabang->kode_cabang }}</small>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $staff->nik }}</td>
                            <td>
                                <strong>{{ $staff->nama_lengkap }}</strong><br>
                                <small class="text-muted">{{ $staff->email }}</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ $staff->jabatan }}</span></td>
                            <td class="col-target-omset">
                                {{ $currentTarget ? 'Rp ' . number_format($currentTarget->target_omset, 0, ',', '.') : '-' }}
                            </td>
                            <td class="col-komisi">
                                {{ $currentTarget ? $currentTarget->persentase_komisi . '%' : '-' }}
                            </td>
                            <td class="col-tier">
                                @if($currentTarget)
                                <span class="badge bg-info text-dark">{{ $currentTarget->tier_insentif }}</span>
                                @else
                                <span class="badge bg-light text-dark">Belum Set</span>
                                @endif
                            </td>
                            <td>
                                @if($staff->status_aktif == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-success btn-atur-target"
                                    data-id="{{ $staff->id }}"
                                    data-nama="{{ $staff->nama_lengkap }}"
                                    data-bs-toggle="modal" data-bs-target="#modalAturTarget">
                                    Set Target
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Staff -->
<div class="modal fade" id="modalTambahStaff" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahStaff">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Staff Marketing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalErrorAlert" class="alert alert-danger d-none">
                        <ul class="mb-0" id="errorList"></ul>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cabang / Unit</label>
                            <select name="kode_cabang" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Cabang --</option>
                                @foreach($cabangs as $c)
                                <option value="{{ $c->kode_cabang }}">
                                    {{ $c->nama_cabang }} ({{ $c->kode_cabang }}) {{ $c->kota ? '- ' . $c->kota : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <select name="jabatan" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Jabatan --</option>
                                <option value="Direktur Marketing">Direktur Marketing</option>
                                <option value="Kepala Cabang">Kepala Cabang</option>
                                <option value="Manager Marketing">Manager Marketing</option>
                                <option value="Supervisor Marketing">Supervisor Marketing</option>
                                <option value="Marketing Dokter">Marketing Dokter</option>
                                <option value="Marketing Perusahaan">Marketing Perusahaan</option>
                                <option value="Marketing Komunikasi">Marketing Komunikasi</option>
                                <option value="Marketing Rujukan">Marketing Rujukan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanStaff" class="btn btn-primary">Simpan Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Atur Target Bulanan -->
<div class="modal fade" id="modalAturTarget" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAturTarget">
                @csrf
                <input type="hidden" name="marketing_staff_id" id="targetStaffId">
                <div class="modal-header">
                    <h5 class="modal-title">Set Target Bulanan: <span id="targetNamaStaff" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalTargetErrorAlert" class="alert alert-danger d-none">
                        <ul class="mb-0" id="errorTargetList"></ul>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-select" required>
                                @foreach([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $namaBulan)
                                <option value="{{ $num }}" {{ date('n') == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Target Omset (Rp)</label>
                            <input type="number" name="target_omset" class="form-control" step="1000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Komisi Insentif (%)</label>
                            <input type="number" name="persentase_komisi" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tier Insentif</label>
                            <select name="tier_insentif" class="form-select">
                                <option value="Tier 1">Tier 1</option>
                                <option value="Tier 2">Tier 2</option>
                                <option value="Tier 3">Tier 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanTarget" class="btn btn-success">Simpan Target</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- DATATABLES JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        let dataTable = $('#tableMarketingStaff').DataTable();

        // 1. Submit Tambah Staff via AJAX
        $(document).on('submit', '#formTambahStaff', function(e) {
            e.preventDefault();
            let form = $(this);
            let btnSimpan = $('#btnSimpanStaff');

            btnSimpan.prop('disabled', true).text('Menyimpan...');
            $('#modalErrorAlert').addClass('d-none');
            $('#errorList').empty();

            $.ajax({
                url: "{{ route('marketing-staff.store') }}",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let staff = response.data;

                        let cabangHtml = staff.cabang ?
                            `<strong>${staff.cabang.nama_cabang}</strong><br><small class="badge bg-secondary">${staff.cabang.kode_cabang}</small>` :
                            `<span class="text-muted">-</span>`;

                        let rowNode = dataTable.row.add([
                            cabangHtml,
                            staff.nik,
                            `<strong>${staff.nama_lengkap}</strong><br><small class="text-muted">${staff.email}</small>`,
                            `<span class="badge bg-secondary">${staff.jabatan}</span>`,
                            '-',
                            '-',
                            `<span class="badge bg-light text-dark">Belum Set</span>`,
                            `<span class="badge bg-success">Aktif</span>`,
                            `<button type="button" class="btn btn-sm btn-success btn-atur-target" data-id="${staff.id}" data-nama="${staff.nama_lengkap}" data-bs-toggle="modal" data-bs-target="#modalAturTarget">Set Target</button>`
                        ]).draw(false).node();

                        $(rowNode).attr('id', 'row-' + staff.id);

                        form[0].reset();
                        $('#modalTambahStaff').modal('hide');
                        showAlert(response.message);
                    }
                },
                error: function(xhr) {
                    handleError(xhr, '#modalErrorAlert', '#errorList');
                },
                complete: function() {
                    btnSimpan.prop('disabled', false).text('Simpan Staff');
                }
            });
        });

        // 2. Set Data Modal Target Bulanan
        $(document).on('click', '.btn-atur-target', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            $('#targetStaffId').val(id);
            $('#targetNamaStaff').text(nama);
        });

        // 3. Submit Target Bulanan via AJAX
        $(document).on('submit', '#formAturTarget', function(e) {
            e.preventDefault();
            let form = $(this);
            let btnSimpan = $('#btnSimpanTarget');
            let staffId = $('#targetStaffId').val();

            btnSimpan.prop('disabled', true).text('Menyimpan...');
            $('#modalTargetErrorAlert').addClass('d-none');
            $('#errorTargetList').empty();

            $.ajax({
                url: "{{ route('marketing-target.store') }}",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let target = response.data;
                        let targetOmsetFormatted = 'Rp ' + parseFloat(target.target_omset).toLocaleString('id-ID');

                        let currentMonth = new Date().getMonth() + 1;
                        if (parseInt(target.bulan) === currentMonth) {
                            let row = $('#row-' + staffId);
                            row.find('.col-target-omset').text(targetOmsetFormatted);
                            row.find('.col-komisi').text(target.persentase_komisi + '%');
                            row.find('.col-tier').html(`<span class="badge bg-info text-dark">${target.tier_insentif}</span>`);
                        }

                        form[0].reset();
                        $('#modalAturTarget').modal('hide');
                        showAlert(response.message);
                    }
                },
                error: function(xhr) {
                    handleError(xhr, '#modalTargetErrorAlert', '#errorTargetList');
                },
                complete: function() {
                    btnSimpan.prop('disabled', false).text('Simpan Target');
                }
            });
        });

        function showAlert(msg) {
            $('#alertContainer').html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `);
        }

        function handleError(xhr, alertBox, listContainer) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $(listContainer).append('<li>' + value[0] + '</li>');
                });
                $(alertBox).removeClass('d-none');
            } else {
                alert('Terjadi kesalahan sistem.');
            }
        }
    });
</script>
@endsection
