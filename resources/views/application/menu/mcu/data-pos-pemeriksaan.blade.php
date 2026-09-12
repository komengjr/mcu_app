<div class="modal-header bg-primary text-white">
    <h5 class="modal-title text-white fw-bold">
        <i class="fas fa-clinic-medical me-2"></i> Pilih Pos Pemeriksaan
    </h5>
    <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
</div>

<div class="modal-body p-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle fs--1 mb-0">
            <thead class="bg-light text-center">
                <tr>
                    <th width="60">No</th>
                    <th>Kode Pos</th>
                    <th>Nama Pos Pemeriksaan</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posPemeriksaan as $index => $pos)
                <tr>
                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                    <td class="text-center"><code>{{ $pos->master_pemeriksaan_code }}</code></td>
                    <td class="fw-semibold text-dark">{{ $pos->master_pemeriksaan_name }}</td>
                    <td class="text-center">
                        <a href="{{ url('v3/operator/' . $cabang . '/' . $companyMouCode . '/' . $pos->master_pemeriksaan_code) }}"
                            target="_blank"
                            class="btn btn-sm btn-success rounded-pill px-3">
                            <i class="fas fa-external-link-alt me-1"></i> Buka Pos
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                        <i class="fas fa-info-circle me-1"></i> Tidak ada pos pemeriksaan yang terdaftar pada MOU ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer bg-light py-2">
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
</div>
