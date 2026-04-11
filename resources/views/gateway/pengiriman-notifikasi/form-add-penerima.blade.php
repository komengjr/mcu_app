<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Add Penerima Notifikasi</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <form id="form-add-penerima" class="row g-3" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <label class="form-label" for="inputAddress">Nama Lengkap <small class="text-danger">Wajib diisi</small></label>
                <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" placeholder="Jhon Doe Example" style="text-transform: uppercase;"
                    required />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputAddress">No Hp <small class="text-danger">Wajib diisi</small></label>
                <input class="form-control" id="no_hp" type="text" name="no_hp"
                    required />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputAddress">Jenis Kelamin <small class="text-danger">Wajib diisi</small></label>
                <select name="jk" class="form-control" id="jk">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer" id="loading-button">
    <button class="btn btn-primary" type="button" id="button-save-data-penerima"><span class="fas fa-save"></span> Simpan & Kirim</button>
</div>
