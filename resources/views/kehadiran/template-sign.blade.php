<div class="row">
    @csrf
    <div class="col-md-12">
        <label class="form-label" for="card-email">Lokasi MCU</label>
        <input class="form-control form-control-lg text-center" type="text" value="{{ $cabang->master_cabang_name }}"
            disabled />
    </div>
    <div class="col-md-6">
        <label class="form-label" for="card-email">Nama Pegawai</label>
        <input class="form-control form-control-lg text-center" type="text" value="{{ $data->mou_peserta_name }}"
            disabled />
    </div>
    <div class="col-md-6">
        <label class="form-label" for="card-email">Tanggal Lahir</label>
        <input class="form-control form-control-lg text-center" type="text" value="{{ $data->mou_peserta_ttl }}"
            disabled />
    </div>
    <div class="col-12 pt-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="card-register-checkbox" />
            <label class="form-check-label" for="card-register-checkbox">
                I accept the <a href="javascript:void(0);" id="show-terms" class="text-danger">terms</a> and <a href="javascript:void(0);" id="show-privacy" class="text-danger">privacy policy</a>
            </label>
        </div>
    </div>
    <div class="col-md-12 pt-1">
        <a href="{{ route('sign-data-baru',['id'=>$token]) }}" id="btn-setuju" class="btn btn-danger d-block w-100 disabled" style="pointer-events: none;">Setuju</a>
    </div>
</div>
