<table id="example" class="table table-striped" style="width:100%">
    <thead class="bg-200 text-700 fs--2">
        <tr>
            <th>NO</th>
            <th>NIP</th>
            <th>NAMA PESERTA</th>
            <th>JENIS KELAMIN</th>
            <th>DEPARTEMEN</th>
            <th>WILAYAH</th>
            <th>LOKASI MCU </th>
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
            <td>{{ $pes->group_cabang_name }}</td>
            <td>{{ $pes->master_cabang_name }}</td>
            @foreach ($pem as $pems)
            <?php
            $status = DB::table('log_pemeriksaan_pasien')
                ->where('mou_peserta_code', $pes->mou_peserta_code)
                ->where('master_pemeriksaan_code', $pems->master_pemeriksaan_code)->first();
            ?>
            <th class="text-center fs--1">
                @if ($status)
                @if ($status->log_pemeriksaan_status == 1)
                <span style="color: green;" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa">Y</span>
                @else
                <span class="text-warning" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{$status->log_pemeriksaan_deskripsi}}">!</span><span> : {{$status->log_pemeriksaan_deskripsi}}</span>
                @endif
                @else
                <span class="text-danger" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Diperiksa">X</span>
                @endif
            </th>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
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
