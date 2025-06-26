<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Cari Data Project</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" id="form-rekap-mcu">
        @csrf

        <div class="col-12">
            <label class="form-label" for="inputAddress">List Project</label>
            <select name="perusahaan" class="form-control choices-single-jenis border border-danger" id="">
                <option value="">Pilih Perusahaan</option>
                @foreach ($data as $datas)
                    <option value="{{$datas->company_mou_code  }}">{{$datas->master_company_name }} - {{$datas->company_mou_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-danger float-end" type="button" data-bs-dismiss="modal" id="button-detail-rekap-project"><span class="fas fa-save"></span> Detail</button>
        </div>
    </form>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-jenis"));
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
