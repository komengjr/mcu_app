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
    <td class="pos-terakhir-cell">
        <span class="badge bg-light text-dark border">{{ $p->nama_pos_pemeriksaan ?? 'Pendaftaran' }}</span>
    </td>
    <td class="status-cell">
        @if($p->status_antrian == 'Dipanggil')
        <span class="badge bg-warning text-dark">
            <i class="fas fa-volume-up me-1"></i>Dipanggil ({{ $p->panggilan_ke }}x)
        </span>
        @elseif($p->status_antrian == 'Selesai')
        <span class="badge bg-success">
            <i class="fas fa-check-circle me-1"></i>Selesai
        </span>
        @else
        <span class="badge bg-secondary">Menunggu</span>
        @endif
    </td>
    <td class="text-center aksi-cell">
        <div class="btn-group btn-group-sm" role="group">
            @if($p->status_antrian != 'Selesai')
            <button type="button"
                class="btn btn-danger btn-panggil-aksi fw-bold"
                data-peserta="{{ $p->mou_peserta_code }}"
                data-nomor="{{ $p->nomor_antrian }}"
                data-nama="{{ $p->mou_peserta_name }}">
                <i class="fas fa-bullhorn me-1"></i> {{ $p->status_antrian == 'Dipanggil' ? 'Panggil Ulang' : 'Panggil' }}
            </button>

            <button type="button"
                class="btn btn-success btn-selesai-aksi fw-bold"
                data-peserta="{{ $p->mou_peserta_code }}"
                data-nomor="{{ $p->nomor_antrian }}">
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
