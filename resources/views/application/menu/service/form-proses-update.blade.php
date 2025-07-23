<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Peserta MCU : <strong
                class="text-primary">{{ $data->mou_peserta_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    @php
    $log = 0;
    @endphp
    <div class="card-body p-3">
        <div class="card border border-danger">
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

    <div class="card-body p-3">
        <div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs--1 mb-0 border">
                    <thead class="bg-200 text-900">
                        <tr>
                            <th class="sort" data-sort="name">Nama Pemeriksaan</th>
                            <th class="text-center" data-sort="email">Yes</th>
                            <th class="text-center" data-sort="email">No</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php $hitung = 0; ?>
                        @foreach ($pemeriksaan as $pem)
                        <?php
                        $ket = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                            ->where('mou_peserta_code', $data->mou_peserta_code)
                            ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                            ->first()
                        ?>
                        <tr>
                            <td class="name">
                                {{$pem->master_pemeriksaan_name}} <br>
                                @if ($ket)
                                <textarea name="" class="form-control" id="ket{{$pem->master_pemeriksaan_code}}">{{ $ket->log_pemeriksaan_deskripsi }}</textarea>
                                @else
                                <textarea name="" class="form-control" id="ket{{$pem->master_pemeriksaan_code}}"></textarea>
                                @endif
                            </td>
                            <td class="text-center">
                                <?php
                                $cek = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                    ->where('mou_peserta_code', $data->mou_peserta_code)
                                    ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                    ->where('log_pemeriksaan_pasien.log_pemeriksaan_status', 1)
                                    ->first()
                                ?>
                                @if ($cek)
                                <!-- <input class="form-check-input" name="pemeriksaan" id="pem{{$pem->master_pemeriksaan_code}}" type="checkbox" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" checked /> -->
                                <div class="form-check">
                                    <input class="form-check-input" id="pem{{$pem->master_pemeriksaan_code}}" type="radio" name="pem{{$pem->master_pemeriksaan_code}}" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" checked />
                                </div>
                                <?php $hitung = $hitung + 1; ?>
                                @else
                                <div class="form-check">
                                    <input class="form-check-input" id="pem{{$pem->master_pemeriksaan_code}}" type="radio" name="pem{{$pem->master_pemeriksaan_code}}" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" />
                                </div>
                                <!-- <input class="form-check-input" name="pemeriksaan" id="pem{{$pem->master_pemeriksaan_code}}" type="checkbox" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" /> -->
                                @endif
                            </td>
                            <td>
                                <?php
                                $cek1 = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                    ->where('mou_peserta_code', $data->mou_peserta_code)
                                    ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                    ->where('log_pemeriksaan_pasien.log_pemeriksaan_status', 0)
                                    ->first()
                                ?>
                                @if ($cek1)
                                <div class="form-check">
                                    <input class="form-check-input" id="pem{{$pem->master_pemeriksaan_code}}" type="radio" name="pem{{$pem->master_pemeriksaan_code}}" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" value="off" checked />
                                </div>
                                <?php $hitung = $hitung + 1; ?>
                                @else
                                <div class="form-check">
                                    <input class="form-check-input" id="pem{{$pem->master_pemeriksaan_code}}" type="radio" name="pem{{$pem->master_pemeriksaan_code}}" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" value="off" />
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- <div class="d-flex justify-content-center mt-3">
                                                            <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                                            <ul class="pagination mb-0"></ul>
                                                            <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                                                        </div> -->
        </div>
    </div>
</div>

