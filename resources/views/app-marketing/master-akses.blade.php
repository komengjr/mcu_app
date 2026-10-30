@extends('layouts.marketing')

@section('content')

<!-- Header -->
<div class="d-sm-flex align-items-center justify-content-between bg-white p-3 p-md-4 shadow-sm rounded mb-4" style="border-left: 4px solid #4e73df;">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
            <i class="fas fa-user-shield text-primary me-2"></i>Master Akses & Akun Login Marketing
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small bg-transparent p-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Marketing</a></li>
                <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Master Akses</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Nav Tabs -->
<ul class="nav nav-tabs font-weight-bold mb-4" id="aksesTab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="cabang-tab" data-bs-toggle="tab" data-bs-target="#cabangTabContent" type="button">
            <i class="fas fa-building me-1"></i> Buat Akun & Akses Cabang Karyawan
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="hierarki-tab" data-bs-toggle="tab" data-bs-target="#hierarkiTabContent" type="button">
            <i class="fas fa-sitemap me-1"></i> Aturan Hierarki Penilaian KPI
        </button>
    </li>
</ul>

<div class="tab-content" id="aksesTabContent">

    <!-- TAB 1: DUA PANEL (PILIH CABANG -> DAFTAR KARYAWAN & SETTING AKUN) -->
    <div class="tab-pane fade show active" id="cabangTabContent">
        <div class="row">
            <!-- Dropdown Pilih Cabang -->
            <div class="col-md-12 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <label class="form-label font-weight-bold text-primary">Pilih Cabang untuk Kelola Karyawan & Akun Login:</label>
                        <select id="selectCabangMain" class="form-select form-select-lg">
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($cabangs as$c)
                            <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }} ({{$c->kode_cabang }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabel List Karyawan di Cabang -->
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary" id="titleKaryawanCabang">Daftar Karyawan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Username Login</th>
                                        <th>Access Code</th>
                                        <th class="text-center">Status Akun</th>
                                        <th class="text-center" style="width: 160px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableKaryawanBody">
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Silakan pilih cabang terlebih dahulu.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: ATURAN HIERARKI PENILAIAN -->
    <div class="tab-pane fade" id="hierarkiTabContent">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow border-left-success">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Tambah Aturan Penilai</h6>
                    </div>
                    <div class="card-body">
                        <form id="formHierarki">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Jabatan Penilai (Atasan)</label>
                                <select name="jabatan_penilai" class="form-select" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($listJabatan as$j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Menilai Jabatan (Bawahan)</label>
                                <select name="jabatan_dinilai" class="form-select" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($listJabatan as$j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100" id="btnSimpanHierarki">
                                <i class="fas fa-plus me-1"></i> Tambah Aturan Hierarki
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow border-left-success">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-success">Matriks Evaluasi KPI Marketing</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jabatan Penilai (Atasan)</th>
                                        <th class="text-center" style="width: 50px;"><i class="fas fa-arrow-right"></i></th>
                                        <th>Jabatan yang Dinilai (Bawahan)</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hierarkis as$h)
                                    <tr>
                                        <td><strong class="text-primary">{{ $h->jabatan_penilai }}</strong></td>
                                        <td class="text-center"><i class="fas fa-chevron-right text-muted"></i></td>
                                        <td><span class="badge bg-secondary">{{ $h->jabatan_dinilai }}</span></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-hierarki" data-id="{{ $h->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada matriks hierarki penilaian.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal Setting / Create Akun User Login -->
<!-- Modal Setting / Create Akun User Login -->
<div class="modal fade" id="modalUserAkun" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formUserAkun">
                @csrf
                <input type="hidden" name="marketing_staff_id" id="modalStaffId">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-user-key me-1"></i> Setup Akun Login & Hak Akses Peran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama Staf:</strong> <span id="modalNamaStaff" class="text-primary font-weight-bold"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Jabatan:</strong> <span id="modalJabatanStaff" class="badge bg-secondary"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Username Login</label>
                            <input type="text" name="username" id="modalUsername" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="******">
                        </div>

                        <!-- Dropdown Dinamis dari Tabel Master Access -->
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Master Access (Level Akses)</label>
                            <select name="access_code" id="modalAccessCode" class="form-select" required>
                                <option value="">-- Pilih Level Akses --</option>
                                @foreach($masterAccesses as $ma)
                                <option value="{{ $ma->master_access_code }}">
                                    {{ $ma->master_access_name }} ({{ $ma->master_access_code }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Access Role Login</label>
                            <select name="access_login" id="modalAccessLogin" class="form-select" required>
                                <option value="Marketing">Marketing</option>
                                <option value="Admin">Admin</option>
                                <option value="Superadmin">Superadmin</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label font-weight-bold">Otoritas Cabang yang Dikelola (Multi-Cabang)</label>
                            <p class="text-muted small mb-2">Centang cabang tambahan yang boleh diakses/dinilai oleh akun ini (Direktur/Kepala Cabang/Manager):</p>
                            <div class="border rounded p-3 bg-light" style="max-height: 180px; overflow-y: auto;">
                                @foreach($cabangs as $c)
                                <div class="form-check mb-1">
                                    <input class="form-check-input chk-modal-cabang" type="checkbox" name="kode_cabangs[]" value="{{ $c->kode_cabang }}" id="m_cb_{{ $c->kode_cabang }}">
                                    <label class="form-check-label" for="m_cb_{{ $c->kode_cabang }}">
                                        {{ $c->nama_cabang }} ({{ $c->kode_cabang }})
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanUserAkun" class="btn btn-primary px-4">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    $(document).ready(function() {
        let currentStaffList = [];

        // When Branch Selected -> Fetch Staff & Account Info
        $('#selectCabangMain').on('change', function() {
            let kodeCabang = $(this).val();

            if (!kodeCabang) {
                $('#tableKaryawanBody').html('<tr><td colspan="7" class="text-center text-muted py-4">Silakan pilih cabang terlebih dahulu.</td></tr>');
                return;
            }

            $('#titleKaryawanCabang').text('Daftar Karyawan Cabang: ' + kodeCabang);
            $('#tableKaryawanBody').html('<tr><td colspan="7" class="text-center py-4"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data karyawan...</td></tr>');

            let getStaffUrl = "{{ url($akses . '/marketing/menu-marketing/master-akses/get-staff-by-cabang') }}/" + kodeCabang;

            $.ajax({
                url: getStaffUrl,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        currentStaffList = res.staffs;
                        let rows = '';

                        if (res.staffs.length === 0) {
                            rows = '<tr><td colspan="7" class="text-center text-muted py-4">Tidak ada karyawan terdaftar di cabang ini.</td></tr>';
                        } else {
                            $.each(res.staffs, function(i, s) {
                                let statusAkun = s.has_account ?
                                    '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Aktif</span>' :
                                    '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle me-1"></i> Belum Ada</span>';

                                let btnLabel = s.has_account ? 'Edit Akun' : 'Buat Akun';
                                let btnClass = s.has_account ? 'btn-outline-primary' : 'btn-success';

                                rows += `
                                <tr>
                                    <td><strong>${s.nik}</strong></td>
                                    <td>${s.nama_lengkap}</td>
                                    <td><span class="badge bg-secondary">${s.jabatan}</span></td>
                                    <td>${s.username ? '<code>' + s.username + '</code>' : '-'}</td>
                                    <td>${s.access_code ? '<span class="badge bg-info text-dark">' + s.access_code + '</span>' : '-'}</td>
                                    <td class="text-center">${statusAkun}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm ${btnClass} btn-open-modal-user" data-index="${i}">
                                            <i class="fas fa-user-cog me-1"></i> ${btnLabel}
                                        </button>
                                    </td>
                                </tr>`;
                            });
                        }
                        $('#tableKaryawanBody').html(rows);
                    }
                },
                error: function() {
                    $('#tableKaryawanBody').html('<tr><td colspan="7" class="text-center text-danger py-4">Gagal memuat data dari server.</td></tr>');
                }
            });
        });

        // Open Modal Setup User Akun
        $(document).on('click', '.btn-open-modal-user', function() {
            let idx = $(this).data('index');
            let staff = currentStaffList[idx];

            $('#modalStaffId').val(staff.id);
            $('#modalNamaStaff').text(staff.nama_lengkap);
            $('#modalJabatanStaff').text(staff.jabatan);

            $('#modalUsername').val(staff.username || staff.nik);
            $('#modalAccessCode').val(staff.access_code || staff.nik);

            // Checkbox multi cabang
            $('.chk-modal-cabang').prop('checked', false);
            $.each(staff.akses_cabangs, function(i, kc) {
                $('#m_cb_' + kc).prop('checked', true);
            });
            // Cabang utama selalu checked
            $('#m_cb_' + staff.kode_cabang).prop('checked', true);

            $('#modalUserAkun').modal('show');
        });

        // Submit User Akun Form
        $('#formUserAkun').on('submit', function(e) {
            e.preventDefault();
            let btn = $('#btnSimpanUserAkun');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: "{{ route('marketing_akses.store_user', ['akses' => $akses]) }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        $('#modalUserAkun').modal('hide');
                        alert(res.message);
                        $('#selectCabangMain').trigger('change');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        alert(xhr.responseJSON.message || 'Harap isi semua bidang wajib.');
                    } else {
                        alert('Gagal menyimpan akun.');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('Simpan Akun');
                }
            });
        });

        // Submit Form Hierarki Penilaian
        $('#formHierarki').on('submit', function(e) {
            e.preventDefault();
            let btn = $('#btnSimpanHierarki');
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('marketing_akses.store_hierarki', ['akses' => $akses]) }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        alert(res.message);
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Gagal menyimpan hierarki.');
                },
                complete: function() {
                    btn.prop('disabled', false);
                }
            });
        });

        // Hapus Hierarki
        $(document).on('click', '.btn-hapus-hierarki', function() {
            if (confirm('Hapus aturan hierarki ini?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url($akses . '/marketing/menu-marketing/master-akses/delete-hierarki') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
