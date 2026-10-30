@extends('layouts.marketing')

@section('content')

<!-- Header Dashboard -->
<div class="d-sm-flex align-items-center justify-content-between bg-white p-3 p-md-4 shadow-sm rounded mb-3" style="border-left: 4px solid #4e73df;">
    <div class="mb-3 mb-sm-0">
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
            <i class="fas fa-building text-primary me-2"></i>Master Data Cabang Marketing
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small bg-transparent p-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Marketing</a></li>
                <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Data Cabang</li>
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-primary shadow-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahCabang">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Tambah Cabang Baru
        </button>
    </div>
</div>

<!-- Alert Notifikasi -->
<div id="alertContainer"></div>

<!-- Filter Pencarian -->
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label text-muted small mb-1">Cari Nama / Kode Cabang</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchCabang" class="form-control" placeholder="Ketik nama atau kode cabang...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small mb-1">Filter Status</label>
                <select id="searchStatus" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Data Cabang Cards -->
<div class="row g-3" id="cabangCardContainer">
    @php
    // Mengurutkan: Cabang Aktif di atas, Nonaktif di bawah
    $activeCabangs = $cabangs->where('status', 'Aktif');$inactiveCabangs = $cabangs->where('status', '!=', 'Aktif');$sortedCabangs = $activeCabangs->merge($inactiveCabangs);
    @endphp

    @foreach($sortedCabangs as$cabang)
    @php
    $isAktif =$cabang->status == 'Aktif';
    // Mengambil jumlah staff (bisa dari withCount 'staffs' / 'marketingStaff' atau 'staffs_count')
    $totalStaff =$cabang->staffs_count ?? ($cabang->staffs ? $cabang->staffs->count() : 0);
    @endphp

    <div class="col-md-6 col-lg-4 mb-4 cabang-card"
        data-nama="{{ strtolower($cabang->nama_cabang) }}"
        data-kode="{{ strtolower($cabang->kode_cabang) }}"
        data-status="{{ $cabang->status }}"
        id="card-{{ $cabang->id }}">

        <div class="card shadow h-100 {{ $isAktif ? 'border-left-primary' : 'border-left-secondary bg-light' }}"
            style="{{ !$isAktif ? 'opacity: 0.65; filter: grayscale(80%);' : '' }}">

            <div class="card-body">
                <!-- Header Card: Icon & Nama Cabang -->
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex justify-content-center align-items-center me-3 {{ $isAktif ? 'bg-primary text-white' : 'bg-secondary text-light' }}" style="width: 50px; height: 50px;">
                        <i class="fas fa-store fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0 font-weight-bold {{ $isAktif ? 'text-gray-800' : 'text-muted' }}">{{ $cabang->nama_cabang }}</h5>
                        <small class="badge bg-dark mt-1">{{ $cabang->kode_cabang }}</small>
                    </div>
                </div>

                <div class="mb-3">
                    @if($isAktif)
                    <span class="badge bg-success">Aktif</span>
                    @else
                    <span class="badge bg-danger">Nonaktif</span>
                    @endif
                    @if($cabang->entitas)
                    <span class="badge bg-info text-dark">{{ $cabang->entitas }}</span>
                    @endif
                </div>

                <hr>


                @php
                $isAktif = $cabang->status == 'Aktif';
                // Panggil $cabang->staff_count hasil dari withCount('staff')
                $totalStaff = $cabang->staff_count ?? 0;
                @endphp

                <!-- Komponen Card Cabang -->
                <div class="row text-sm mb-2">
                    <div class="col-4 text-muted"><i class="fas fa-users me-1"></i> Jml Staff:</div>
                    <div class="col-8 font-weight-bold text-primary">
                        <span class="badge bg-primary rounded-pill px-2 py-1">{{ $totalStaff }} Orang</span>
                    </div>
                </div>
                <div class="row text-sm mb-2">
                    <div class="col-4 text-muted"><i class="fas fa-city me-1"></i> Kota:</div>
                    <div class="col-8 font-weight-bold">{{ $cabang->kota ?: '-' }}</div>
                </div>
                <div class="row text-sm mb-2">
                    <div class="col-4 text-muted"><i class="fas fa-phone me-1"></i> Telp:</div>
                    <div class="col-8 font-weight-bold">{{ $cabang->no_telepon ?: '-' }}</div>
                </div>
                <div class="row text-sm mb-2">
                    <div class="col-4 text-muted"><i class="fas fa-map-marker-alt me-1"></i> Alamat:</div>
                    <div class="col-8">
                        <span class="d-inline-block text-truncate w-100" title="{{ $cabang->alamat }}">
                            {{ $cabang->alamat ?: '-' }}
                        </span>
                    </div>
                </div>
                @if($cabang->latitude &&$cabang->longitude)
                <div class="row text-sm mt-2">
                    <div class="col-12">
                        <a href="https://maps.google.com/?q={{ $cabang->latitude }},{{$cabang->longitude }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-map-marked-alt me-1"></i> Lihat di Peta
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Card Footer Aksi -->
            <div class="card-footer {{ $isAktif ? 'bg-white' : 'bg-transparent' }} border-top-0 pt-0">
                <div class="d-flex justify-content-end gap-2 mt-auto">
                    <button type="button" class="btn btn-sm btn-outline-warning btn-edit-cabang" data-id="{{ $cabang->id }}" {{ !$isAktif ? 'disabled' : '' }}>
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Tambah Cabang -->
<div class="modal fade" id="modalTambahCabang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahCabang">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Cabang Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalErrorAlert" class="alert alert-danger d-none">
                        <ul class="mb-0" id="errorList"></ul>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Cabang <span class="text-danger">*</span></label>
                            <input type="text" name="kode_cabang" class="form-control" placeholder="Contoh: CBG-JKT" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Cabang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_cabang" class="form-control" placeholder="Contoh: Cabang Jakarta Pusat" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Entitas / Badan Usaha</label>
                            <input type="text" name="entitas" class="form-control" placeholder="Contoh: PT. Makmur Jaya">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota</label>
                            <input type="text" name="kota" class="form-control" placeholder="Contoh: Jakarta">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" placeholder="Contoh: 021-88997766">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap cabang..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Latitude <small class="text-muted">(Opsional)</small></label>
                            <input type="text" name="latitude" class="form-control" placeholder="-6.2088">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude <small class="text-muted">(Opsional)</small></label>
                            <input type="text" name="longitude" class="form-control" placeholder="106.8456">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanCabang" class="btn btn-primary px-4">Simpan Cabang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    $(document).ready(function() {

        // --- FUNGSI FILTER PENCARIAN CABANG ---
        function filterCabangCards() {
            let keyword = $('#searchCabang').val().toLowerCase();
            let filterStatus = $('#searchStatus').val();

            $('.cabang-card').each(function() {
                let nama = $(this).data('nama');
                let kode = $(this).data('kode');
                let status = $(this).data('status');

                let cocokKeyword = nama.includes(keyword) || kode.includes(keyword);
                let cocokStatus = filterStatus === "" || status === filterStatus;

                if (cocokKeyword && cocokStatus) {
                    $(this).fadeIn(300);
                } else {
                    $(this).hide();
                }
            });
        }

        $('#searchCabang').on('keyup', filterCabangCards);
        $('#searchStatus').on('change', filterCabangCards);

        // --- SUBMIT TAMBAH CABANG VIA AJAX ---
        $(document).on('submit', '#formTambahCabang', function(e) {
            e.preventDefault();
            let form = $(this);
            let btnSimpan = $('#btnSimpanCabang');

            btnSimpan.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $('#modalErrorAlert').addClass('d-none');
            $('#errorList').empty();

            $.ajax({
                url: "{{ route('marketing-cabang.store') }}",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let cabang = response.data;

                        let kota = cabang.kota ? cabang.kota : '-';
                        let no_telepon = cabang.no_telepon ? cabang.no_telepon : '-';
                        let alamat = cabang.alamat ? cabang.alamat : '-';
                        let entitasBadge = cabang.entitas ? `<span class="badge bg-info text-dark">${cabang.entitas}</span>` : '';

                        let mapButton = (cabang.latitude && cabang.longitude) ? `
                            <div class="row text-sm mt-2">
                                <div class="col-12">
                                    <a href="https://maps.google.com/?q=${cabang.latitude},${cabang.longitude}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fas fa-map-marked-alt me-1"></i> Lihat di Peta
                                    </a>
                                </div>
                            </div>` : '';

                        let cardHtml = `
                        <div class="col-md-6 col-lg-4 mb-4 cabang-card" style="display:none;" data-nama="${cabang.nama_cabang.toLowerCase()}" data-kode="${cabang.kode_cabang.toLowerCase()}" data-status="${cabang.status}" id="card-${cabang.id}">
                            <div class="card shadow h-100 border-left-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center me-3 bg-primary text-white" style="width: 50px; height: 50px;">
                                            <i class="fas fa-store fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-0 font-weight-bold text-gray-800">${cabang.nama_cabang}</h5>
                                            <small class="badge bg-dark mt-1">${cabang.kode_cabang}</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-success">Aktif</span>
                                        ${entitasBadge}
                                    </div>
                                    <hr>
                                    <div class="row text-sm mb-2">
                                        <div class="col-4 text-muted"><i class="fas fa-users me-1"></i> Jml Staff:</div>
                                        <div class="col-8 font-weight-bold text-primary">
                                            <span class="badge bg-primary rounded-pill px-2 py-1">0 Orang</span>
                                        </div>
                                    </div>
                                    <div class="row text-sm mb-2">
                                        <div class="col-4 text-muted"><i class="fas fa-city me-1"></i> Kota:</div>
                                        <div class="col-8 font-weight-bold">${kota}</div>
                                    </div>
                                    <div class="row text-sm mb-2">
                                        <div class="col-4 text-muted"><i class="fas fa-phone me-1"></i> Telp:</div>
                                        <div class="col-8 font-weight-bold">${no_telepon}</div>
                                    </div>
                                    <div class="row text-sm mb-2">
                                        <div class="col-4 text-muted"><i class="fas fa-map-marker-alt me-1"></i> Alamat:</div>
                                        <div class="col-8">
                                            <span class="d-inline-block text-truncate w-100" title="${alamat}">${alamat}</span>
                                        </div>
                                    </div>
                                    ${mapButton}
                                </div>
                                <div class="card-footer bg-white border-top-0 pt-0">
                                    <div class="d-flex justify-content-end gap-2 mt-auto">
                                        <button type="button" class="btn btn-sm btn-outline-warning btn-edit-cabang" data-id="${cabang.id}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        let newElement = $(cardHtml).prependTo('#cabangCardContainer');
                        newElement.fadeIn(500);

                        form[0].reset();
                        $('#modalTambahCabang').modal('hide');
                        showAlert('Cabang berhasil ditambahkan!');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('#errorList').empty();
                        $.each(errors, function(key, value) {
                            $('#errorList').append('<li>' + value[0] + '</li>');
                        });
                        $('#modalErrorAlert').removeClass('d-none');
                    } else {
                        alert('Terjadi kesalahan sistem.');
                    }
                },
                complete: function() {
                    btnSimpan.prop('disabled', false).html('Simpan Cabang');
                }
            });
        });

        // --- FUNGSI ALERT ---
        function showAlert(msg) {
            $('#alertContainer').html(`
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-1"></i> ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `);
        }
    });
</script>
@endsection
