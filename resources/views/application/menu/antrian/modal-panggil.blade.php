<div class="modal-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
    <h5 class="modal-title text-white fw-bold mb-0 d-flex align-items-center">
        <i class="fas fa-bullhorn me-2"></i>Panggil & Kelola Antrian Peserta MCU
    </h5>

    <!-- TOMBOL REFRESH ANTRIAN -->

</div>

<div class="modal-body p-4">
    <!-- Bio MOU & Pilihan Pos -->
    <button type="button" id="btn_refresh_antrian" class="btn btn-sm btn-warning text-white fw-bold">
        <i class="fas fa-sync-alt me-1 icon-refresh"></i> Refresh Antrian
    </button>
    <hr>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card bg-light border-0 p-3 rounded-3">
                <small class="text-muted fw-bold">PROJECT / AGREEMENT</small>
                <h6 class="fw-bold text-primary mb-0">{{ $mou->company_mou_name }}</h6>
                <small class="text-secondary">Kode: {{ $mou->company_mou_code }}</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-light border-0 p-3 rounded-3">
                <label for="select_pos_pemeriksaan" class="form-label fw-bold text-dark fs--1 mb-1">
                    <i class="fas fa-clinic-medical text-danger me-1"></i> Pilih Pos / Poli Pemeriksaan Saat Ini:
                </label>
                <select id="select_pos_pemeriksaan" class="form-select form-select-sm fw-bold border-primary">
                    <option value="Registrasi / Pendaftaran 1">Registrasi / Pendaftaran ( 1 )</option>
                    <option value="Registrasi / Pendaftaran 2">Registrasi / Pendaftaran ( 2 )</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Tabel Daftar Antrian Peserta -->
    <div class="table-responsive">

        <table id="table_panggil_antrian" class="table table-hover table-striped align-middle w-100">
            <thead class="table-dark">
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Peserta</th>
                    <th>NIP / Dept</th>
                    <th>Pos Terakhir</th>
                    <th>Status</th>
                    <th width="28%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertaList as $p)
                <tr class="antrian-row">
                    <td>
                        <span class="badge bg-primary fs-0 px-2 py-1">{{ $p->nomor_antrian }}</span>
                    </td>
                    <td class="fw-bold text-dark">{{ $p->mou_peserta_name }}</td>
                    <td>
                        <small class="d-block text-dark fw-semibold">{{ $p->mou_peserta_nip ?? '-' }}</small>
                        <small class="text-muted">{{ $p->mou_peserta_departemen ?? '-' }}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border badge-pos-text">{{ $p->nama_pos_pemeriksaan ?? 'Pendaftaran' }}</span>
                    </td>
                    <td>
                        @if($p->status_antrian == 'Dipanggil')
                        <span class="badge bg-warning text-dark"><i class="fas fa-volume-up me-1"></i>Dipanggil ({{ $p->panggilan_ke }}x)</span>
                        @elseif($p->status_antrian == 'Selesai')
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Selesai</span>
                        @else
                        <span class="badge bg-secondary">Menunggu</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">

                            @if($p->status_antrian != 'Selesai')
                            <!-- Tombol Panggil -->
                            <button type="button"
                                class="btn btn-danger btn-panggil-aksi fw-bold"
                                data-peserta="{{ $p->mou_peserta_code }}"
                                data-nomor="{{ $p->nomor_antrian }}"
                                data-nama="{{ $p->mou_peserta_name }}"
                                data-pos-terakhir="{{ $p->nama_pos_pemeriksaan }}"
                                data-status="{{ $p->status_antrian }}">
                                <i class="fas fa-bullhorn me-1"></i>
                                <span class="text-btn-panggil">{{ $p->status_antrian == 'Dipanggil' ? 'Panggil Ulang' : 'Panggil' }}</span>
                            </button>

                            <!-- Tombol Selesai (Di-handle dinamis via JS) -->
                            <button type="button"
                                class="btn btn-success btn-selesai-aksi fw-bold"
                                data-peserta="{{ $p->mou_peserta_code }}"
                                data-nomor="{{ $p->nomor_antrian }}"
                                data-pos-terakhir="{{ $p->nama_pos_pemeriksaan }}"
                                data-status="{{ $p->status_antrian }}">
                                <i class="fas fa-check me-1"></i> Selesai
                            </button>
                            @else
                            <span class="badge bg-light text-success border border-success p-2">
                                <i class="fas fa-check-double me-1"></i> Pemeriksaan Selesai
                            </span>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada peserta yang check-in/memiliki antrian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer bg-light p-3 d-flex justify-content-between">
    <a href="{{ url('v3/display/' . Auth::user()->access_cabang . '/' . $mou->company_mou_code) }}"
        target="_blank"
        class="btn btn-outline-primary btn-sm fw-bold">
        <i class="fas fa-external-link-alt me-1"></i> Buka TV Display (Tab Baru)
    </a>
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
</div>

<script>
    $(document).ready(function() {
        const mouCode = "{{ $code }}";
        const storageKey = 'selected_pos_mcu_' + mouCode;

        // 1. Restore nilai pilihan dropdown dari localStorage
        let savedPos = localStorage.getItem(storageKey);
        if (savedPos) {
            $('#select_pos_pemeriksaan').val(savedPos);
        }

        // 2. Logika validasi tombol Panggil & Tombol Selesai berdasarkan Pos yang dipilih
        function validateButtonsByPos() {
            let currentSelectedPos = $('#select_pos_pemeriksaan').val();

            // Loop untuk Tombol Panggil
            $('.btn-panggil-aksi').each(function() {
                let btn = $(this);
                let posTerakhir = btn.data('pos-terakhir');
                let status = btn.data('status');

                if (status === 'Dipanggil' && posTerakhir) {
                    if (posTerakhir !== currentSelectedPos) {
                        btn.prop('disabled', true);
                        btn.addClass('btn-secondary').removeClass('btn-danger');
                        btn.attr('title', 'Sedang dipanggil di ' + posTerakhir);
                        btn.find('.text-btn-panggil').text('Dipanggil di ' + (posTerakhir.includes('1') ? 'Pendaftaran 1' : 'Pendaftaran 2'));
                    } else {
                        btn.prop('disabled', false);
                        btn.addClass('btn-danger').removeClass('btn-secondary');
                        btn.removeAttr('title');
                        btn.find('.text-btn-panggil').text('Panggil Ulang');
                    }
                } else {
                    btn.prop('disabled', false);
                    btn.addClass('btn-danger').removeClass('btn-secondary');
                    btn.find('.text-btn-panggil').text('Panggil');
                }
            });

            // Loop untuk Tombol Selesai (Hanya aktif jika dipanggil oleh pos yang sama)
            $('.btn-selesai-aksi').each(function() {
                let btnSelesai = $(this);
                let posTerakhir = btnSelesai.data('pos-terakhir');
                let status = btnSelesai.data('status');

                // Jika statusnya dipanggil tetapi bukan oleh pos saat ini, Sembunyikan/Disable tombol Selesai
                if (status === 'Dipanggil' && posTerakhir && posTerakhir !== currentSelectedPos) {
                    btnSelesai.hide(); // Sembunyikan tombol agar tidak bisa diklik pos lain
                } else {
                    btnSelesai.show(); // Tampilkan jika pos-nya sesuai atau statusnya masih Menunggu/baru akan di-panggil
                }
            });
        }

        validateButtonsByPos();

        // 3. Simpan state dropdown & validasi tombol saat dropdown diganti
        $('#select_pos_pemeriksaan').off('change').on('change', function() {
            let val = $(this).val();
            localStorage.setItem(storageKey, val);
            validateButtonsByPos();
        });

        // 4. ACTION REFRESH MODAL DATA
        $('#btn_refresh_antrian').off('click').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let icon = btn.find('.icon-refresh');

            icon.addClass('fa-spin');
            btn.prop('disabled', true);

            $('#button-panggil-antrian-peserta-mcu[data-code="' + mouCode + '"]').trigger('click');
        });

        // 5. Eksekusi Panggil
        $('.btn-panggil-aksi').off('click').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let pesertaCode = btn.data('peserta');
            let posPemeriksaan = $('#select_pos_pemeriksaan').val();

            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('medical_check_up_proses_panggil_antrian') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "company_mou_code": mouCode,
                    "mou_peserta_code": pesertaCode,
                    "nama_pos_pemeriksaan": posPemeriksaan
                },
                success: function(res) {
                    btn.prop('disabled', false);
                    if (res.status === 'success') {
                        $('#button-panggil-antrian-peserta-mcu[data-code="' + mouCode + '"]').trigger('click');
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    btn.prop('disabled', false);
                }
            });
        });

        // 6. Eksekusi Selesaikan Pasien
        $('.btn-selesai-aksi').off('click').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let pesertaCode = btn.data('peserta');
            let posPemeriksaan = $('#select_pos_pemeriksaan').val();

            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('medical_check_up_selesaikan_pasien') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "company_mou_code": mouCode,
                    "mou_peserta_code": pesertaCode,
                    "nama_pos_pemeriksaan": posPemeriksaan
                },
                success: function(res) {
                    btn.prop('disabled', false);
                    if (res.status === 'success') {
                        $('#button-panggil-antrian-peserta-mcu[data-code="' + mouCode + '"]').trigger('click');
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    btn.prop('disabled', false);
                }
            });
        });
    });
</script>
