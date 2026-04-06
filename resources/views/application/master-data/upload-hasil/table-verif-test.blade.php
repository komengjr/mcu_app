<table id="example" class="table table-striped fs--2" style="width:100%" border="1">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Pemeriksaan</th>
            <th>Status Pemeriksaan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        $data = DB::table('monitoring_hasil_pemeriksaan')
        ->join('master_test','master_test.master_test_code','=','monitoring_hasil_pemeriksaan.master_test_code')
        ->where('monitoring_hasil_pasien_code',$reg)->get();
        @endphp
        @foreach ($data as $datas)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $datas->master_test_name }}</td>
            <td class="text-center">
                @if ($datas->monitoring_hasil_pemeriksaan_status == '0')
                <span class="badge bg-danger">Belum</span>
                @else
                <span class="badge bg-primary">Sudah</span><br> <small>{{ $datas->updated_at }}</small>
                @endif
            </td>
            <td class="text-center">
                @if ($datas->monitoring_hasil_pemeriksaan_status == '0')
                <button class="btn btn-dark btn-sm" id="button-verif-test-pemeriksaan" data-code="{{ $datas->monitoring_hasil_pemeriksaan_code }}" data-reg="{{ $datas->monitoring_hasil_pasien_code }}">Verif</button>

                @else
                <button class="btn btn-primary btn-sm" disabled>Done</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
