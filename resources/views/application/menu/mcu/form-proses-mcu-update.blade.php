<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Peserta MCU : <strong
                class="text-primary">{{ $data->mou_peserta_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <div class="card-body p-3">
        <div class="card border border-primary">
            <form class="row g-3 p-4" action="{{ route('medical_check_up_prosess_update_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">Nama Peserta</label>
                    <input class="form-control" id="inputAddress" type="text" name="nama"
                        value="{{ $data->mou_peserta_name }}" disabled />
                    <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="inputAddress">NIK</label>
                    <input class="form-control" id="inputAddress" type="text" name="peserta"
                        value="{{ $data->mou_peserta_nik }}" disabled />
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="inputAddress">NIP</label>
                    <input class="form-control" id="inputAddress" type="text" name="start"
                        value="{{ $data->mou_peserta_nip }}" disabled />
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="inputAddress">No Handphone</label>
                    <input class="form-control" id="inputAddress" type="text" name="nama"
                        value="{{ $data->mou_peserta_no_hp }}" disabled />
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">Email</label>
                    <input class="form-control" id="inputAddress" type="text" name="peserta"
                        value="{{ $data->mou_peserta_email }}" disabled />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">Departemen</label>
                    <input class="form-control" id="inputAddress" type="text" name="start"
                        value="{{ $data->mou_peserta_departemen }}" disabled />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">Lokasi Check In</label>
                    <select name="cabang" class="form-select choices-single-cabang" id="" required>
                        <option value="">Pilih Cabang</option>
                        @foreach ($cabang as $cabangs)
                            <option value="{{ $cabangs->master_cabang_code }}">{{ $cabangs->master_cabang_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 pt-3">
                    <button class="btn btn-primary btn-sm float-end" type="submit"><span
                            class="far fa-chart-bar"></span> Check
                        In</button>
                </div>
            </form>
            <div class="p-4 pt-0">
                <table id="data-v3s" class="table table-striped nowrap" style="width:100%">
                    <thead class="bg-200 text-700 fs--2">
                        <tr>
                            <th>No</th>
                            <th>Pemeriksaaan</th>
                        </tr>
                    </thead>
                    <tbody class="fs--2">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($pemeriksaan as $item)
                            <tr>
                                <td style="width: 5%;">{{ $no++ }}</td>
                                <td>{{ $item->master_pemeriksaan_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
{{-- <div class="card-body p-3 pt-0">
    <div class="card-header bg-primary">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Status Pemeriksaan</span></h3>
            </div>
            <div class="col-auto">

            </div>
        </div>
    </div>
    <div class="card-body border border-primary">
        <div class="row g-3">
            @foreach ($pemeriksaan as $item)
                <div class="col-md-4">
                    <label class="form-label text-warning"
                        for="inputAddress">{{ $item->master_pemeriksaan_name }}</label>
                    <div class="form-check">
                        <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}1" type="radio"
                            name="{{ $item->master_pemeriksaan_code }}" checked="checked" />
                        <label class="form-check-label mb-0" for="{{ $item->master_pemeriksaan_code }}1">Belum
                            Melakukan MCU</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}2" type="radio"
                            name="{{ $item->master_pemeriksaan_code }}" />
                        <label class="form-check-label mb-0" for="{{ $item->master_pemeriksaan_code }}2">Sudah
                            Melakukan MCU</label>
                    </div>
                </div>
                <div class="col-md-8">Deskripsi</label>
                    <textarea name="" class="form-control" id=""></textarea>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="card-body p-3 pt-0">
    <div class="card-header bg-primary">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Pengiriman Hasil</span></h3>
            </div>
            <div class="col-auto">

            </div>
        </div>
    </div>
    <div class="card-body border border-primary">


    </div>
</div>
<div class="card-body p-3 pt-0">
    <div class="card-header bg-primary">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Konsultasi Dokter</span></h3>
            </div>
            <div class="col-auto">

            </div>
        </div>
    </div>
    <div class="card-body border border-primary">


    </div>
</div>
<div class="card-body p-3 pt-0">
    <button class="btn btn-falcon-primary btn-sm">Simpan Data</button>
</div> --}}

</div>
<script>
    new DataTable('#data-v3s', {
        responsive: true
    });
</script>
<script>
    new window.Choices(document.querySelector(".choices-single-cabang"));
</script>
