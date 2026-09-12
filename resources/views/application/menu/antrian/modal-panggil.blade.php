<div class="modal-header bg-primary text-white p-3">
    <h5 class="modal-title text-white fw-bold mb-0">
        <i class="fas fa-bullhorn me-2"></i>Panggil & Kelola Antrian Peserta MCU
    </h5>
    <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
</div>

<div class="modal-body p-4">
    <!-- Bio MOU & Pilihan Pos -->
    <div class="row g-3 mb-4">
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
                <tr>
                    <td>
                        <span class="badge bg-primary fs-0 px-2 py-1">{{ $p->nomor_antrian }}</span>
                    </td>
                    <td class="fw-bold text-dark">{{ $p->mou_peserta_name }}</td>
                    <td>
                        <small class="d-block text-dark fw-semibold">{{ $p->mou_peserta_nip ?? '-' }}</small>
                        <small class="text-muted">{{ $p->mou_peserta_departemen ?? '-' }}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $p->nama_pos_pemeriksaan ?? 'Pendaftaran' }}</span>
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

                            <!-- Tombol Panggil / Panggil Ulang (HANYA MUNCUL JIKA BELUM SELESAI) -->
                            @if($p->status_antrian != 'Selesai')
                            <button type="button"
                                class="btn btn-danger btn-panggil-aksi fw-bold"
                                data-peserta="{{ $p->mou_peserta_code }}"
                                data-nomor="{{ $p->nomor_antrian }}"
                                data-nama="{{ $p->mou_peserta_name }}">
                                <i class="fas fa-bullhorn me-1"></i> {{ $p->status_antrian == 'Dipanggil' ? 'Panggil Ulang' : 'Panggil' }}
                            </button>

                            <!-- Tombol Selesai Pasien -->
                            <button type="button"
                                class="btn btn-success btn-selesai-aksi fw-bold"
                                data-peserta="{{ $p->mou_peserta_code }}"
                                data-nomor="{{ $p->nomor_antrian }}">
                                <i class="fas fa-check me-1"></i> Selesai
                            </button>
                            @else
                            <!-- Badge Keterangan Pasien Selesai -->
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

<div class="modal-footer bg-light p-3">
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
</div>

<script>
    $(document).ready(function() {
        const mouCode = "{{ $code }}";

        // 1. Eksekusi Panggil
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
                        // Refresh modal content
                        $('#button-panggil-antrian-peserta-mcu[data-code="' + mouCode + '"]').trigger('click');
                    } else {
                        alert(res.message);
                    }
                }
            });
        });

        // 2. Eksekusi Selesaikan Pasien
        $('.btn-selesai-aksi').off('click').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let pesertaCode = btn.data('peserta');

            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('medical_check_up_selesaikan_pasien') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "company_mou_code": mouCode,
                    "mou_peserta_code": pesertaCode
                },
                success: function(res) {
                    btn.prop('disabled', false);
                    if (res.status === 'success') {
                        // Refresh modal content
                        $('#button-panggil-antrian-peserta-mcu[data-code="' + mouCode + '"]').trigger('click');
                    } else {
                        alert(res.message);
                    }
                }
            });
        });
    });
</script>
