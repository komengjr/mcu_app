<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data Peserta MCU : <strong>{{ $data->master_company_name }} -
                {{ $data->company_mou_name }}</strong></h4>
        <p class="text-white fs--2 mb-0">Support by <a class="fw-semi-bold text-white" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <span class="badge bg-danger">Belum MCU</span>
        <table id="data-v3" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Departemen</th>

                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                    $no = 1;
                @endphp
                @foreach ($peserta as $pesertas)
                    @php
                        $log = DB::table('log_lokasi_pasien')
                            ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                            ->first();
                    @endphp
                    @if (!$log)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pesertas->mou_peserta_nip }}</td>
                            <td>{{ $pesertas->mou_peserta_name }}</td>
                            <td>
                                @if ($pesertas->mou_peserta_jk == 'L')
                                    Laki - Laki
                                @else
                                    Perempuan
                                @endif
                            </td>
                            <td>{{ $pesertas->mou_peserta_departemen }}</td>

                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-v3', {
        responsive: true
    });
</script>
