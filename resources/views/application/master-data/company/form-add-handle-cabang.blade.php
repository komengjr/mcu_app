<div class="card border">
    <div class="card-body">
        <form class="row" action="{{ route('master_company_data_location_company_save_handle') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <label class="form-label" for="inputAddress">Cari Cabang Pramita</label>
                <select name="cabang" class="form-control choices-single-jenis" id="">
                    <option value="">Pilih Cabang</option>
                    @foreach ($data as $datas)
                        <option value="{{ $datas->master_cabang_code }}">{{ $datas->master_cabang_name }}</option>
                    @endforeach
                </select>
                <input type="text" name="code" value="{{ $code }}" hidden>
            </div>
            <div class="col-md-12 pt-1">
                <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-jenis"));
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
