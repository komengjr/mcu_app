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
      <div class="col-md-12 pt-3">
          <a href="{{ route('sign-data-baru',['id'=>$token]) }}" class="btn btn-danger d-block w-100 " type="submit" name="submit">Setuju</a>
      </div>
</div>

