<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Peserta MCU : <strong
                class="text-primary">{{ $data->mou_peserta_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <div class="card-body p-3">
        <div class="card border border-primary">
            <div class="row g-3 p-4">

                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">Nama Peserta</label>
                    <input class="form-control" id="inputAddress" type="text" name="nama"
                        value="{{ $data->mou_peserta_name }}" disabled />
                    <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">NIK</label>
                    <input class="form-control" id="inputAddress" type="text" name="peserta"
                        value="{{ $data->mou_peserta_nik }}" disabled />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="inputAddress">NIP</label>
                    <input class="form-control" id="inputAddress" type="text" name="start"
                        value="{{ $data->mou_peserta_nip }}" disabled />
                </div>
                <div class="col-md-4">
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

            </div>
        </div>
    </div>
</div>
<div class="card-body p-3 pt-0">
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
        <form class="row g-3 p-2" action="{{ route('menu_service_proses_pemeriksaan_save') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden>
            @php
                $no = 0;
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pemeriksaan</th>
                        <th>Belum</th>
                        <th>Sudah</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemeriksaan as $item)
                        @php
                            $check = DB::table('log_pemeriksaan_pasien')
                                ->where('mou_peserta_code', $data->mou_peserta_code)
                                ->where('master_pemeriksaan_code', $item->master_pemeriksaan_code)
                                ->first();
                        @endphp

                        @if (!$check)
                            <tr>
                                <td>
                                    <label class="form-label text-warning"
                                        for="inputAddress">{{ $item->master_pemeriksaan_name }}</label>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}1"
                                            type="radio" name="{{ $item->master_pemeriksaan_code }}"
                                            value="0" />
                                        <label class="form-check-label mb-0"
                                            for="{{ $item->master_pemeriksaan_code }}1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}2"
                                            type="radio" name="{{ $item->master_pemeriksaan_code }}"
                                            value="1" />
                                        <label class="form-check-label mb-0"
                                            for="{{ $item->master_pemeriksaan_code }}2"></label>
                                    </div>
                                </td>
                                <td>
                                    <textarea name="desc{{ $item->master_pemeriksaan_code }}" class="form-control" id="{{ $no++ }}"></textarea>
                                </td>
                            </tr>
                        @elseif ($check->log_pemeriksaan_status == 0)
                            <tr>
                                <td>
                                    <label class="form-label text-warning"
                                        for="inputAddress">{{ $item->master_pemeriksaan_name }}</label>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}1"
                                            type="radio" name="{{ $item->master_pemeriksaan_code }}"
                                            checked="chacked" value="0" />
                                        <label class="form-check-label mb-0"
                                            for="{{ $item->master_pemeriksaan_code }}1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}2"
                                            type="radio" name="{{ $item->master_pemeriksaan_code }}"
                                            value="1" />
                                        <label class="form-check-label mb-0"
                                            for="{{ $item->master_pemeriksaan_code }}2"></label>
                                    </div>
                                </td>
                                <td>
                                    <textarea name="desc{{ $item->master_pemeriksaan_code }}" class="form-control" id="{{ $no++ }}">{{ $check->log_pemeriksaan_deskripsi }}</textarea>
                                </td>
                            </tr>
                        @endif

                        {{-- @if (!$check)
                            <div class="col-md-4">
                                <label class="form-label text-warning"
                                    for="inputAddress">{{ $item->master_pemeriksaan_name }}</label>
                                <div class="form-check">
                                    <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}1"
                                        type="radio" name="{{ $item->master_pemeriksaan_code }}" checked="checked"
                                        value="0" />
                                    <label class="form-check-label mb-0"
                                        for="{{ $item->master_pemeriksaan_code }}1">Belum
                                        Melakukan MCU</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="{{ $item->master_pemeriksaan_code }}2"
                                        type="radio" name="{{ $item->master_pemeriksaan_code }}" value="1" />
                                    <label class="form-check-label mb-0"
                                        for="{{ $item->master_pemeriksaan_code }}2">Sudah
                                        Melakukan MCU</label>
                                </div>
                            </div>
                            <div class="col-md-8">Deskripsi</label>
                                <textarea name="desc{{ $item->master_pemeriksaan_code }}" class="form-control" id="{{ $no++ }}"></textarea>
                            </div>
                        @endif --}}
                    @endforeach
                </tbody>
            </table>
            @if ($no == 0)
                <div class="col-md-12">
                    <button class="btn btn-success btn-sm float-end disabled">Proses Selesai</button>
                </div>
            @else
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
                <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Pengiriman Hasil</span></h3>
            </div>
            <div class="col-auto">

            </div>
        </div>
    </div>
    <div class="card-body border border-primary">
        @php
            $pengiriman = DB::table('log_pengiriman_pasien')
                ->where('mou_peserta_code', $data->mou_peserta_code)
                ->first();
        @endphp
        @if ($pengiriman)
            <div class="row g-3 p-2">
                <div class="col-md-12">
                    <button class="btn btn-success btn-sm float-end disabled">Proses Selesai</button>
                </div>
            </div>
        @else
            <form class="row g-3 p-2" action="{{ route('menu_service_proses_pengiriman_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden>
                <div class="col-md-4">
                    <label class="form-label text-warning" for="inputAddress">Pengiriman Hasil</label>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman1" type="radio" name="pengiriman"
                            value="0" required />
                        <label class="form-check-label mb-0" for="pengiriman1">Belum Terikirim</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="pengiriman2" type="radio" name="pengiriman"
                            value="1" required />
                        <label class="form-check-label mb-0" for="pengiriman2">Sudah Terkirim</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <label> Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_kirim" id="" required>
                    <label> Waktu</label>
                    <input type="time" class="form-control" name="time_kirim" id="" required>
                </div>
                <div class="col-md-5">Deskripsi</label>
                    <textarea name="desc_pengiriman" class="form-control" id=""></textarea>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                </div>
            </form>
        @endif
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
        @php
            $konsul = DB::table('log_konsultasi_pasien')->where('mou_peserta_code', $data->mou_peserta_code)->first();
        @endphp
        @if ($konsul)
            <div class="row g-3 p-2">
                <div class="col-md-12">
                    <button class="btn btn-success btn-sm float-end disabled">Proses Selesai</button>
                </div>
            </div>
        @else
            <form class="row g-3 p-2" action="{{ route('menu_service_proses_konsultasi_save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $data->mou_peserta_code }}" hidden>
                <div class="col-md-4">
                    <label class="form-label text-warning" for="inputAddress">Konsultasi</label>
                    <div class="form-check">
                        <input class="form-check-input" id="konsul-dokter1" type="radio" name="konsul_dokter"
                            value="0" required />
                        <label class="form-check-label mb-0" for="konsul-dokter1">Belum Konsultasi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="konsul-dokter2" type="radio" name="konsul_dokter"
                            value="1" required />
                        <label class="form-check-label mb-0" for="konsul-dokter2">Sudah Konsultasi</label>
                    </div>
                </div>
                <div class="col-md-8">Deskripsi</label>
                    <textarea name="desc_konsul" class="form-control" id=""></textarea>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                </div>
            </form>
        @endif
    </div>
</div>


<div class="card-body p-3 pt-0">
    <button class="btn btn-falcon-primary btn-sm" id="button-penyelesaian-peserta-mcu"
        data-code="{{ $data->mou_peserta_code }}">Penyelesaian Proses MCU</button>
</div>

</div>
