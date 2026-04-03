<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Order Pasien</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form id="form-add-pasien" class="row g-3 p-4" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Nama Lengkap</label>
            <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" placeholder="Jhon Doe Example"
                required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
            <input class="form-control" id="tgl_lahir" type="date" name="tgl_lahir"
                required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">NIK</label>
            <input class="form-control" id="inputAddress" type="text" name="no_induk" placeholder="61XXXXXXXXXXXXXX"
                required />
        </div>
    </form>
</div>
<div class="modal-footer" id="loading-button">
    <button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>
</div>
