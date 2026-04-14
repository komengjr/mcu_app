<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Import Excel</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <form class="row g-3 p-4" action="{{ route('master_upload_hasil_import_pasien_lama_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Pilih Rujukan</label>
            <select name="nama_rujukan" class="form-control choices-single-rujukan" id="nama_rujukan">
                <option value="">Pilih Rujukan</option>
                @foreach ($user as $users)
                <option value="{{ $users->userid }}">{{ $users->fullname }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Pilih File</label>
            <input class="form-control form-control-lg" id="file" type="file" name="file" placeholder="120"
                required />
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Import</button>
        </div>
    </form>

</div>
<div class="modal-footer" id="loading-button">
    <button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>
</div>
