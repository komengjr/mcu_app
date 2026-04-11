<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Data Penerima Notifikasi</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <table id="data-penerima" class="table table-striped" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Nama Penerima</th>
                    <th>Jenis Kelamin</th>
                    <th>Nomor Penerima</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->gateway_penerima_name }}</td>
                    <td>{{ $datas->gateway_penerima_jk }}</td>
                    <td>{{ $datas->gateway_penerima_no_hp }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer" id="loading-button">

</div>
<script>
    new DataTable('#data-penerima', {
        responsive: true
    });
</script>
