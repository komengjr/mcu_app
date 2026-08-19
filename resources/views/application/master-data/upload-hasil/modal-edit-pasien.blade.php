<div class="modal-header bg-danger text-white rounded-top-3">
    <h5 class="modal-title text-white fw-bold"><i class="fas fa-user-edit me-2"></i>Edit Data Pasien</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="form-edit-pasien">
    @csrf
    <input type="hidden" name="monitoring_hasil_pasien_code" value="{{ $pasien->monitoring_hasil_pasien_code }}">

    <div class="modal-body p-4">
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">No. Registrasi</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-hashtag text-danger"></i></span>
                <input type="text" class="form-control" name="monitoring_hasil_pasien_reg" value="{{ $pasien->monitoring_hasil_pasien_reg }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Nama Pasien</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-user text-danger"></i></span>
                <input type="text" class="form-control" name="monitoring_hasil_pasien_nama" value="{{ $pasien->monitoring_hasil_pasien_nama }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-dark">Jenis Kelamin</label>
                <select class="form-select" name="monitoring_hasil_pasien_jk">
                    <option value="L" {{ $pasien->monitoring_hasil_pasien_jk == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="P" {{ $pasien->monitoring_hasil_pasien_jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-dark">Tanggal Lahir</label>
                <input type="date" class="form-control" name="monitoring_hasil_pasien_tgl_lahir" value="{{ $pasien->monitoring_hasil_pasien_tgl_lahir }}">
            </div>
        </div>
    </div>

    <div class="modal-footer bg-light rounded-bottom-3">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Batal</button>
        <button type="submit" class="btn btn-danger btn-sm shadow-sm" id="btn-save-edit-pasien"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
    </div>
</form>
