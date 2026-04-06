<table id="data-pemeriksaans" class="table table-striped fs--2" style="width:100%">
    <thead class="bg-200 text-700">
        <tr>
            <th>No</th>
            <th>Nama Test Pemeriksaan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @php
        $no = 1
    @endphp
    @foreach ($data as $datas)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $datas->master_test_name }}</td>
            <td class="text-end"><button class="btn btn-danger" id="button-remove-pemeriksaan_pasien" data-code="{{ $datas->monitoring_hasil_pemeriksaan_code }}" data-reg="{{ $datas->monitoring_hasil_pasien_code }}"><span class="fas fa-trash"></span>Hapus</button></td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    new DataTable('#data-pemeriksaans', {
        responsive: true
    });
</script>
