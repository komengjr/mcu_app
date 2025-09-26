<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Peserta MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-3">
        <div class="card border">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-sm-auto mb-2 mb-sm-0">
                        <select name="paket_mcu" id="paket_mcu" class="form-control">
                            <option value=""></option>
                            @foreach ($paket as $pakets)
                                <option value="{{ $pakets->mou_agreement_code }}">{{ $pakets->mou_agreement_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-auto">

                        <button class="btn btn-danger btn-sm" id="button-adjust-paket-mcu"
                            data-code="{{ $data->company_mou_code }}">Adjust Paket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content p-3 pt-0" id="menu-nik-nip">
        <table id="data-v4" class="table table-striped nowrap border" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK</th>
                    <th>Jenis Kelamin</th>
                    <th>NIP</th>
                    <th>Departemen</th>
                    <th>Paket</th>

                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                    $no = 1;
                @endphp
                @foreach ($peserta as $pesertas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pesertas->mou_peserta_name }}</td>
                        <td>{{ $pesertas->mou_peserta_nik }}</td>

                        <td>
                            @if ($pesertas->mou_peserta_jk == 'L')
                                Laki - Laki
                            @else
                                Perempuan
                            @endif
                        </td>
                        <td>{{ $pesertas->mou_peserta_nip }}</td>
                        <td>{{ $pesertas->mou_peserta_departemen }}</td>
                        <td>
                            @php
                                $paket = DB::table('company_mou_agreement')
                                    ->where('mou_agreement_code', $pesertas->mou_agreement_code)
                                    ->first();
                            @endphp
                            @if ($paket)
                                {{ $paket->mou_agreement_name }}
                            @else
                                <span class="badge bg-danger">Belum Memilih Paket</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-v4', {
        responsive: true
    });
</script>
