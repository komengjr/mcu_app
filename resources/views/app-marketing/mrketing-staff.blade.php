@extends('layouts.marketing')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between bg-white p-3 p-md-4 shadow-sm rounded mb-3" style="border-left: 4px solid #4e73df;">
    <!-- Bagian Judul dan Breadcrumb -->
    <div class="mb-3 mb-sm-0">
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
            <i class="fas fa-users-cog text-primary me-2"></i>Master Data Staff Marketing
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small bg-transparent p-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Marketing</a></li>
                <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Data Staff</li>
            </ol>
        </nav>
    </div>

    <!-- Bagian Tombol Aksi -->
    <div>
        <button type="button" class="btn btn-primary shadow-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahStaff">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Tambah Staff Baru
        </button>
    </div>
</div>

<!-- Alert Notifikasi AJAX -->
<div id="alertContainer"></div>

<!-- Filter Pencarian -->
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Cari Nama Staff</label>
                <input type="text" id="searchNama" class="form-control" placeholder="Ketik nama staff...">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Filter Cabang</label>
                <select id="searchCabang" class="form-select">
                    <option value="">Semua Cabang</option>
                    @foreach($cabangs as$c)
                    <option value="{{ $c->nama_cabang }}">{{ $c->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Filter Jabatan</label>
                <select id="searchJabatan" class="form-select">
                    <option value="">Semua Jabatan</option>
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
        </div>
    </div>
</div>

<!-- Data Staff Cards -->
<div class="row g-3" id="staffCardContainer">
    @php
    $activeStaffs = $staffs->where('status_aktif', 'Aktif');$inactiveStaffs = $staffs->where('status_aktif', '!=', 'Aktif');$sortedStaffs = $activeStaffs->merge($inactiveStaffs);
    @endphp

    @foreach($sortedStaffs as$staff)
    @php
    $latestPenilaian = $staff->penilaians ? $staff->penilaians->first() : null;
    $cabangName = $staff->cabang ? $staff->cabang->nama_cabang : '';
    $isAktif =$staff->status_aktif == 'Aktif';
    @endphp

    <div class="col-md-6 col-lg-4 mb-4 staff-card"
        data-nama="{{ strtolower($staff->nama_lengkap) }}"
        data-cabang="{{ $cabangName }}"
        data-jabatan="{{ $staff->jabatan }}"
        id="card-{{ $staff->id }}">

        <div class="card shadow h-100 {{ $isAktif ? 'border-left-primary' : 'border-left-secondary bg-light' }}"
            style="{{ !$isAktif ? 'opacity: 0.65; filter: grayscale(80%);' : '' }}">

            <div class="card-body">
                <!-- Header Card: Avatar & Nama -->
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->nama_lengkap) }}&background=random&color=fff" class="rounded-circle me-3" width="60" height="60" alt="Avatar">
                    <div>
                        <h5 class="card-title mb-0 font-weight-bold {{ $isAktif ? 'text-gray-800' : 'text-muted' }}">{{ $staff->nama_lengkap }}</h5>
                        <small class="text-muted">{{ $staff->nik }}</small>
                    </div>
                </div>

                <!-- Badges Jabatan & Status -->
                <div class="mb-3">
                    <span class="badge {{ $isAktif ? 'bg-primary' : 'bg-secondary' }}">{{ $staff->jabatan }}</span>
                    @if($isAktif)
                    <span class="badge bg-success">Aktif</span>
                    @else
                    <span class="badge bg-danger">Nonaktif</span>
                    @endif
                </div>

                <hr>

                <!-- Detail Data Staf -->
                <div class="row text-sm mb-2">
                    <div class="col-5 text-muted">Cabang:</div>
                    <div class="col-7 font-weight-bold">
                        @if($staff->cabang)
                        {{ $staff->cabang->nama_cabang }} <br><small class="text-muted">({{ $staff->cabang->kode_cabang }})</small>
                        @else
                        -
                        @endif
                    </div>
                </div>
                <div class="row text-sm mb-2">
                    <div class="col-5 text-muted">Email:</div>
                    <div class="col-7 font-weight-bold text-truncate" title="{{ $staff->email }}">{{ $staff->email }}</div>
                </div>

                <!-- Point Penilaian KPI -->
                <div class="row text-sm mb-2">
                    <div class="col-5 text-muted">Skor KPI:</div>
                    <div class="col-7 font-weight-bold {{ $latestPenilaian && $latestPenilaian->total_skor_akhir >= 75 ? 'text-success' : ($latestPenilaian ? 'text-danger' : 'text-muted') }}">
                        {{ $latestPenilaian ? number_format($latestPenilaian->total_skor_akhir, 2) . '%' : '-' }}
                    </div>
                </div>
                <div class="row text-sm mb-1">
                    <div class="col-5 text-muted">Predikat:</div>
                    <div class="col-7 font-weight-bold">
                        @if($latestPenilaian)
                        @php
                        $badgeColor = 'bg-danger';
                        if ($latestPenilaian->predikat == 'Sangat Baik')$badgeColor = 'bg-success';
                        elseif ($latestPenilaian->predikat == 'Baik')$badgeColor = 'bg-primary';
                        elseif ($latestPenilaian->predikat == 'Cukup')$badgeColor = 'bg-warning text-dark';
                        @endphp
                        <span class="badge {{ $badgeColor }}">{{ $latestPenilaian->predikat }}</span>
                        @else
                        <span class="badge bg-light text-dark border">Belum Evaluasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Tambah Staff -->
<div class="modal fade" id="modalTambahStaff" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahStaff">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Tambah Staff Marketing</h5>
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
                                @foreach($cabangs as$c)
                                <option value="{{ $c->kode_cabang }}">
                                    {{ $c->nama_cabang }} ({{$c->kode_cabang }}) {{ $c->kota ? '- ' . $c->kota : '' }}
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
@endsection

@section('base.js')
<script>
    $(document).ready(function() {

        // --- FUNGSI FILTER PENCARIAN (NAMA, CABANG, JABATAN) ---
        function filterStaffCards() {
            let filterNama = $('#searchNama').val().toLowerCase();
            let filterCabang = $('#searchCabang').val();
            let filterJabatan = $('#searchJabatan').val();

            $('.staff-card').each(function() {
                let namaStaff = $(this).data('nama');
                let cabangStaff = $(this).data('cabang');
                let jabatanStaff = $(this).data('jabatan');

                let cocokNama = namaStaff.includes(filterNama);
                let cocokCabang = filterCabang === "" || cabangStaff === filterCabang;
                let cocokJabatan = filterJabatan === "" || jabatanStaff === filterJabatan;

                if (cocokNama && cocokCabang && cocokJabatan) {
                    $(this).fadeIn(300);
                } else {
                    $(this).hide();
                }
            });
        }

        $('#searchNama').on('keyup', filterStaffCards);
        $('#searchCabang, #searchJabatan').on('change', filterStaffCards);


        // --- SUBMIT TAMBAH STAFF VIA AJAX ---
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

                        let namaCabang = staff.cabang ? staff.cabang.nama_cabang : '';
                        let infoCabang = staff.cabang ? `${staff.cabang.nama_cabang} <br><small class="text-muted">(${staff.cabang.kode_cabang})</small>` : '-';
                        let avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(staff.nama_lengkap)}&background=random&color=fff`;

                        let cardHtml = `
                        <div class="col-md-6 col-lg-4 mb-4 staff-card" style="display:none;" data-nama="${staff.nama_lengkap.toLowerCase()}" data-cabang="${namaCabang}" data-jabatan="${staff.jabatan}" id="card-${staff.id}">
                            <div class="card shadow h-100 border-left-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="${avatarUrl}" class="rounded-circle me-3" width="60" height="60" alt="Avatar">
                                        <div>
                                            <h5 class="card-title mb-0 font-weight-bold text-gray-800">${staff.nama_lengkap}</h5>
                                            <small class="text-muted">${staff.nik}</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-primary">${staff.jabatan}</span>
                                        <span class="badge bg-success">Aktif</span>
                                    </div>
                                    <hr>
                                    <div class="row text-sm mb-2">
                                        <div class="col-5 text-muted">Cabang:</div>
                                        <div class="col-7 font-weight-bold">${infoCabang}</div>
                                    </div>
                                    <div class="row text-sm mb-2">
                                        <div class="col-5 text-muted">Email:</div>
                                        <div class="col-7 font-weight-bold text-truncate" title="${staff.email}">${staff.email}</div>
                                    </div>
                                    <div class="row text-sm mb-2">
                                        <div class="col-5 text-muted">Skor KPI:</div>
                                        <div class="col-7 font-weight-bold text-muted">-</div>
                                    </div>
                                    <div class="row text-sm mb-1">
                                        <div class="col-5 text-muted">Predikat:</div>
                                        <div class="col-7 font-weight-bold">
                                            <span class="badge bg-light text-dark border">Belum Evaluasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        let newElement = $(cardHtml).prependTo('#staffCardContainer');
                        newElement.fadeIn(500);

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

        // --- FUNGSI ALERT & ERROR HANDLER ---
        function showAlert(msg) {
            $('#alertContainer').html(`
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
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
