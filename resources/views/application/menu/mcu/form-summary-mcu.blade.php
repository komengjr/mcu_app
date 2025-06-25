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
            <form class="row g-3 p-2" action="{{ route('medical_check_up_summary_save_persentasi') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $code }}" hidden>
                @if ($data)
                    @if ($data->summary_cabang_pesentasi == null)
                        <div class="col-md-4">
                            <label class="form-label text-warning" for="inputAddress">Persentasi Hasil</label>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman1" type="radio" name="persentasi"
                                    value="0" required />
                                <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman2" type="radio" name="persentasi"
                                    value="1" required />
                                <label class="form-check-label mb-0" for="pengiriman2">Sudah Persentasi</label>
                            </div>
                        </div>
                        <div class="col-md-8">Dokumen</label>
                            <input type="file" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                        </div>
                    @else
                        <span class="badge bg-primary">Selesai</span>
                    @endif
                @else
                    <div class="col-md-4">
                        <label class="form-label text-warning" for="inputAddress">Persentasi Hasil</label>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman1" type="radio" name="persentasi"
                                value="0" required />
                            <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman2" type="radio" name="persentasi"
                                value="1" required />
                            <label class="form-check-label mb-0" for="pengiriman2">Sudah Persentasi</label>
                        </div>
                    </div>
                    <div class="col-md-8">Dokumen</label>
                        <input type="file" name="" id="" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                    </div>
                @endif
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
            <form class="row g-3 p-2" action="{{ route('medical_check_up_summary_save_executive') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $code }}" hidden>
                @if ($data)
                    @if ($data->summary_cabang_executive == null)
                        <div class="col-md-4">
                            <label class="form-label text-warning" for="inputAddress">Executive Hasil</label>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman1" type="radio" name="executive"
                                    value="0" required />
                                <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman2" type="radio" name="executive"
                                    value="1" required />
                                <label class="form-check-label mb-0" for="pengiriman2">Sudah dilakukan</label>
                            </div>
                        </div>
                        <div class="col-md-8">Dokumen</label>
                            <input type="file" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                        </div>
                    @else
                        <span class="badge bg-primary">Selesai</span>
                    @endif
                @else
                    <div class="col-md-4">
                        <label class="form-label text-warning" for="inputAddress">Executive Hasil</label>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman1" type="radio" name="executive"
                                value="0" required />
                            <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman2" type="radio" name="executive"
                                value="1" required />
                            <label class="form-check-label mb-0" for="pengiriman2">Sudah dilakukan</label>
                        </div>
                    </div>
                    <div class="col-md-8">Dokumen</label>
                        <input type="file" name="" id="" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                    </div>
                @endif
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
            <form class="row g-3 p-2" action="{{ route('medical_check_up_summary_save_healty_talk') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $code }}" hidden>
                @if ($data)
                    @if ($data->summary_cabang_ht == null)
                        <div class="col-md-4">
                            <label class="form-label text-warning" for="inputAddress">Healty Talk</label>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman1" type="radio" name="healty_talk"
                                    value="0" required />
                                <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman2" type="radio" name="healty_talk"
                                    value="1" required />
                                <label class="form-check-label mb-0" for="pengiriman2">Sudah dilakukan</label>
                            </div>
                        </div>
                        <div class="col-md-8">Dokumen</label>
                            <input type="file" name="" id="" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                        </div>
                    @else
                        <span class="badge bg-primary">Selesai</span>
                    @endif
                @else
                    <div class="col-md-4">
                        <label class="form-label text-warning" for="inputAddress">Healty Talk</label>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman1" type="radio" name="healty_talk"
                                value="0" required />
                            <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman2" type="radio" name="healty_talk"
                                value="1" required />
                            <label class="form-check-label mb-0" for="pengiriman2">Sudah dilakukan</label>
                        </div>
                    </div>
                    <div class="col-md-8">Dokumen</label>
                        <input type="file" name="" id="" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                    </div>
                @endif
            </form>
        </div>
    </div>


</div>

</div>
