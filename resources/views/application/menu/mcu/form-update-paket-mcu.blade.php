<form class="row g-3 p-4" action="{{ route('medical_check_up_prosess_update_save') }}" method="post"
    enctype="multipart/form-data">
    @csrf
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
    <div class="col-md-12">
        <div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs--1 mb-0">
                    <thead class="bg-200 text-900">
                        <tr>
                            <th class="sort" data-sort="name">Nama Paket</th>
                            <th class="sort" data-sort="email">Detail Pemeriksaan</th>
                            <th class="sort float-end" data-sort="age">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($paket as $pac)
                        <tr>
                            <td class="name">{{ $pac->mou_agreement_name }}</td>
                            <td class="email">
                                <?php
                                $detail = DB::table('company_mou_agreement_sub')->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
                                    ->where('company_mou_agreement_sub.mou_agreement_code', $pac->mou_agreement_code)->get();
                                ?>
                                @foreach ($detail as $det)
                                <li>{{ $det->master_pemeriksaan_name }}</li>
                                @endforeach
                            </td>
                            <td class="age"><button class="btn btn-warning btn-sm float-end" id="button-fix-pilih-paket-mcu" data-code="{{ $data->mou_peserta_code }}" data-paket="{{ $pac->mou_agreement_code }}">Pilih Paket</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
