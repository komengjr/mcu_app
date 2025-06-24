<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Summary MCU : <strong class="text-primary">-</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <div class="card-body p-3 pt-0">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Persentasi Hasil</span></h3>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <div class="card-body border border-primary">
            <form class="row g-3 p-2" action="{{ route('menu_service_proses_pengiriman_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                {{-- <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden> --}}
                <div class="col-md-4">
                    <label class="form-label text-warning" for="inputAddress">Persentasi Hasil</label>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman1" type="radio" name="pengiriman" value="0"
                            required />
                        <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman2" type="radio" name="pengiriman" value="1"
                            required />
                        <label class="form-check-label mb-0" for="pengiriman2">Sudah Persentasi</label>
                    </div>
                </div>
                <div class="col-md-8">Dokumen</label>
                    <input type="file" name="" id="" class="form-control">
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-3 pt-0">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Executive Hasil</span></h3>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <div class="card-body border border-primary">
            <form class="row g-3 p-2" action="{{ route('menu_service_proses_pengiriman_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                {{-- <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden> --}}
                <div class="col-md-4">
                    <label class="form-label text-warning" for="inputAddress">Executive Hasil</label>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman1" type="radio" name="pengiriman" value="0"
                            required />
                        <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman2" type="radio" name="pengiriman" value="1"
                            required />
                        <label class="form-check-label mb-0" for="pengiriman2">Sudah dilakukan</label>
                    </div>
                </div>
                <div class="col-md-8">Dokumen</label>
                    <input type="file" name="" id="" class="form-control">
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-3 pt-0">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Healty Talk</span></h3>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <div class="card-body border border-primary">
            <form class="row g-3 p-2" action="{{ route('menu_service_proses_pengiriman_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                {{-- <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden> --}}
                <div class="col-md-4">
                    <label class="form-label text-warning" for="inputAddress">Healty Talk</label>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman1" type="radio" name="pengiriman" value="0"
                            required />
                        <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman2" type="radio" name="pengiriman" value="1"
                            required />
                        <label class="form-check-label mb-0" for="pengiriman2">Sudah dilakukan</label>
                    </div>
                </div>
                <div class="col-md-8">Dokumen</label>
                    <input type="file" name="" id="" class="form-control">
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>


</div>

</div>
