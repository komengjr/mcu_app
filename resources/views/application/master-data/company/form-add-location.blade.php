<div class="card border">
    <div class="card-body">
        <form class="row" action="{{ route('master_company_data_location_company_save') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <label class="form-label" for="inputAddress">Nama Lokasi Perusahan</label>
                <input class="form-control form-control-lg" id="inputAddress" type="text" name="name" placeholder="PT Sinar Matahari"
                    required />
                    <input type="text" name="code" value="{{ $code }}" hidden>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="inputAddress">Alamat Perusahaan</label>
                <input class="form-control form-control-lg" id="inputAddress" type="text" name="alamat" placeholder="Pontianak"
                    required />
            </div>
            <div class="col-md-12 pt-3">
                <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
            </div>
        </form>
    </div>
</div>
