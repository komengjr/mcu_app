<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Add Perusahaan</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('mou_company_update_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-6">
            <label class="form-label" for="inputAddress">MOU</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="nama"
                value="{{ $data->company_mou_name }}" required />
                <input type="text" name="code" value="{{ $data->company_mou_code }}" id="" hidden>
        </div>

        <div class="col-6">
            <label class="form-label" for="inputAddress">Jumlah Peserta</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="peserta" value="{{ $data->company_mou_peserta }}"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Waktu Mulai</label>
            <input class="form-control form-control-lg" id="inputAddress" type="date" name="start" value="{{ $data->company_mou_start }}" required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Waktu Berakhir</label>
            <input class="form-control form-control-lg" id="inputAddress" type="date" name="end" value="{{ $data->company_mou_end }}" required />
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Update MOU</button>
        </div>
    </form>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-jenis"));
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
