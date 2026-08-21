<div class="modal-header bg-danger text-white">
    <h5 class="modal-title text-white" id="modalUploadLogoLabel">Upload Logo Perusahaan</h5>
</div>
<form id="form-upload-logo" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="master_company_code" value="{{ $company->master_company_code }}">

    <div class="modal-body p-4">
        <div class="text-center mb-3">
            <p class="fw-bold mb-1">{{ $company->master_company_name }}</p>
            <span class="badge bg-secondary">{{ $company->master_company_code }}</span>
        </div>

        <div class="text-center mb-3">
            <label class="form-label d-block fw-medium">Logo Saat Ini:</label>
            @if($company->master_company_logo && file_exists(public_path('uploads/company_logo/' . $company->master_company_logo)))
            <img src="{{ asset('uploads/company_logo/' . $company->master_company_logo) }}" alt="Logo Company" class="img-thumbnail" style="max-height: 120px;">
            @else
            <div class="p-3 bg-light text-muted border rounded">Belum ada logo</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="master_company_logo" class="form-label fw-bold">Pilih File Logo Baru <span class="text-danger">*</span></label>
            <input class="form-control" type="file" id="master_company_logo" name="master_company_logo" accept="image/png, image/jpeg, image/jpg, image/svg+xml" required>
            <small class="text-muted">Format yang didukung: JPG, JPEG, PNG, SVG (Max: 2MB)</small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger btn-sm">
            <span class="fas fa-upload me-1"></span> Upload Logo
        </button>
    </div>
</form>
