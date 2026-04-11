<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Add Aktifitas Notifikasi</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <form id="form-add-aktifitas" class="row g-3" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
                <label class="form-label" for="inputAddress">Tanggal Aktifitas <small class="text-danger">Wajib diisi</small></label>
                <input class="form-control" id="tgl_aktifitas" type="date" name="tgl_aktifitas" required />
            </div>
            <div class="col-md-4">
                <label class="form-label" for="inputAddress">Waktu Aktifitas <small class="text-danger">Wajib diisi</small></label>
                <input class="form-control" id="time_aktifitas" type="time" name="time_aktifitas" required />
            </div>
            <div class="col-md-4">
                <label class="form-label" for="inputAddress">Type Aktifitas <small class="text-danger">Wajib diisi</small></label>
                <select name="type_send" class="form-control" id="type_send">
                    <option value="">Pilih Type</option>
                    <option value="R">Replay</option>
                    <option value="S">Single</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="inputAddress">Isi Pesan<small class="text-danger">Wajib diisi</small></label>
                <textarea name="pesan" class="form-control" id="pesan" rows="4"></textarea>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer" id="loading-button">
    <button class="btn btn-primary" type="button" id="button-save-data-aktifitas"><span class="fas fa-save"></span> Simpan & Kirim</button>
</div>
