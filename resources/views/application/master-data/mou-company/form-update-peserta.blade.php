<div class="card border">
    <form class="row g-3 p-4" action="{{ route('mou_company_update_peserta_mcu_save') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Nama Peserta</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="name" value="{{ $data->mou_peserta_name }}" />
            <input type="text" name="code"   value="{{ $data->mou_peserta_code }}" hidden>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">NIK</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="nik" value="{{ $data->mou_peserta_nik }}" />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">NIP</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="nip" value="{{ $data->mou_peserta_nip }}" />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Email</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="email" value="{{ $data->mou_peserta_email }}" />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">No Hp</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="no_hp" value="{{ $data->mou_peserta_no_hp }}" />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Departemen</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="departemen" value="{{ $data->mou_peserta_departemen }}" />
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">Jenis Kelamin</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="jk" value="{{ $data->mou_peserta_jk }}" />
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="ttl" value="{{ $data->mou_peserta_ttl }}" />
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>

    <script>
        new window.Choices(document.querySelector(".choices-single-jenis"));
        // new window.Choices(document.querySelector(".choices-single-lokasi"));
    </script>

</div>
