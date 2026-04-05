<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Order Pasien</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <form id="form-add-pasien" class="row g-3" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <label class="form-label" for="inputAddress">Nama Lengkap <small class="text-danger">Wajib diisi</small></label>
                <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" placeholder="Jhon Doe Example"
                    required />
                <input type="text" name="token_registrasi" value="{{ $token }}" id="token_registrasi" hidden>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputAddress">Tanggal Lahir <small class="text-danger">Wajib diisi</small></label>
                <input class="form-control" id="tgl_lahir" type="date" name="tgl_lahir"
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
            <div class="col-md-12">
                <label class="form-label" for="inputAddress">NIK</label>
                <input class="form-control" id="inputAddress" type="text" name="no_induk" placeholder="61XXXXXXXXXXXXXX"
                    required />
            </div>
        </form>
        <hr>
        <h4><span class="badge bg-dark">Pemeriksaan</span></h4>
        <form id="form-pemeriksaan-pasien" class="row g-3 py-3">
            <div class="col-md-8">
                <select name="data_pemeriksaan" class="form-control choices-single-pemeriksaan" id="data_pemeriksaan">
                    <option value="">Pilih Pemeriksaan</option>
                    @foreach ($pemeriksaan as $pem)
                    <option value="{{ $pem->master_pemeriksaan_code }}">{{ $pem->master_pemeriksaan_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary btn-sm" type="button" id="button-pilih-pemeriksaan-pasien">Pilih</button>
            </div>
        </form>
        <div id="table-pemeriksaan-pasien">
            <table id="data-pemeriksaan" class="table table-striped fs--2" style="width:100%">
                <thead class="bg-200 text-700">
                    <tr>
                        <th>No</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer" id="loading-button">
    <button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>
</div>
<script>
    new DataTable('#data-pemeriksaan', {
        responsive: true
    });
    new window.Choices(document.querySelector(".choices-single-pemeriksaan"));
</script>
