<div class="modal-header bg-light">
    <h5 class="modal-title text-dark"><i class="fas fa-user-plus me-2 text-primary"></i>Tambah Peserta MCU Baru</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form id="form-tambah-peserta-mcu">
    @csrf
    <input type="hidden" name="company_mou_code" value="{{ $mou_code }}">

    <div class="modal-body px-4 py-3">
        <!-- Warning Alert -->
        <div class="alert alert-warning d-flex align-items-center mb-4 border-warning shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle fa-2x me-3 text-warning"></i>
            <div>
                <strong>Perhatian!</strong><br>
                Harap pastikan sebelum mendaftarkan peserta, cari dan cek terlebih dahulu nama serta NIP peserta di sistem agar tidak terjadi penggandaan (double) data.
            </div>
        </div>

        <!-- Pilih Paket MCU (Agreement Name) -->
        <div class="mb-3">
            <label class="form-label fw-bold">Pilih Paket MCU <span class="text-danger">*</span></label>
            <select name="mou_agreement_code" class="form-select" required>
                <option value="">-- Pilih Paket MCU --</option>
                @foreach($paket_mcu as $paket)
                <option value="{{ $paket->mou_agreement_code }}">{{ $paket->mou_agreement_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Form Rows (Standard Vertical Layout) -->
        <div class="mb-3">
            <label class="form-label fw-bold">NIP / ID Karyawan <span class="text-danger">*</span></label>
            <input type="text" name="mou_peserta_nip" class="form-control" required placeholder="Contoh: EMP-001">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">NIK (KTP) <span class="text-danger">*</span></label>
            <input type="text" name="mou_peserta_nik" class="form-control" maxlength="16" required placeholder="Masukkan 16 digit NIK">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="mou_peserta_name" class="form-control" required placeholder="Masukkan nama lengkap peserta">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="mou_peserta_jk" class="form-select" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Tanggal Lahir (TTL) <span class="text-danger">*</span></label>
                <input type="date" name="mou_peserta_ttl" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Departemen <span class="text-danger">*</span></label>
            <input type="text" name="mou_peserta_departemen" class="form-control" required placeholder="Contoh: HRD / IT / Operasional">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">No. HP / WhatsApp</label>
                <input type="text" name="mou_peserta_no_hp" class="form-control" placeholder="08XXXXXXXXXX">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="mou_peserta_email" class="form-control" placeholder="email@domain.com">
            </div>
        </div>
    </div>

    <div class="modal-footer bg-light px-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-primary" id="btn-simpan-peserta">
            <i class="fas fa-save me-1"></i> Simpan Data Peserta
        </button>
    </div>
</form>
