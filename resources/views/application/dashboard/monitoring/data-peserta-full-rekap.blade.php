<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data Peserta MCU<strong>{{ $data->master_company_name }} -
                {{ $data->company_mou_name }}</strong></h4>
        <p class="text-white fs--2 mb-0">Support by <a class="fw-semi-bold text-white" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <table id="example" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>NO</th>
                    <th>NIP</th>
                    <th>NAMA PESERTA</th>
                    <th>JENIS KELAMIN</th>
                    <th>DEPARTEMEN</th>
                    <th>WILAYAH</th>
                    <th>LOKASI MCU</th>
                    @foreach ($pem as $pems)
                    <th>{{$pems->master_pemeriksaan_name}}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($peserta as $pes)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pes->mou_peserta_nip }}</td>
                    <td>{{ $pes->mou_peserta_name }}</td>
                    <td>{{ $pes->mou_peserta_jk }}</td>
                    <td>{{ $pes->mou_peserta_departemen }}</td>
                    <?php
                    $lokasi = DB::table('log_lokasi_pasien')
                        ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                        ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                        ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
                        ->where('log_lokasi_pasien.mou_peserta_code', $pes->mou_peserta_code)->first();
                    ?>
                    @if ($lokasi)
                    <td>{{ $lokasi->group_cabang_name }}</td>
                    <td>{{ $lokasi->master_cabang_name }}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
                    @foreach ($pem as $pems)
                    <?php
                    $status = DB::table('log_pemeriksaan_pasien')
                        ->where('mou_peserta_code', $pes->mou_peserta_code)
                        ->where('master_pemeriksaan_code', $pems->master_pemeriksaan_code)->first();
                    ?>
                    <th class="text-center fs--1">
                        @if ($status)
                        @if ($status->log_pemeriksaan_status == 1)
                        <span style="color: green;" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Melakukan">✅</span>
                        @else
                        <span class="text-warning" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{$status->log_pemeriksaan_deskripsi}}">!</span>
                        @endif
                        @else
                        <span class="text-danger" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Melakukan">x</span>
                        @endif
                    </th>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#example', {
        responsive: true,

        layout: {
            topStart: {
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: 'Export Excel',
                    title: 'Data MCU {{ $data->master_company_name }} - {{ $data->company_mou_name }}'
                }],
            }
        }
    });
</script>
