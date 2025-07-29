<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Pengiriman Email</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3 pt-0" id="menu-nik-nip">
        <table id="data-v3" class="table table-striped border" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="list fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->mou_peserta_name }}</td>
                    <td>{{ $datas->h_log_mail_address }}</td>
                    <td><?php echo $datas->h_log_mail_messages; ?></td>
                    <td>
                        @if ($datas->h_log_mail_status == 0)
                        <span class="badge bg-warning">Proses Kirim</span>
                        @elseif ($datas->h_log_mail_status == 1)
                        <span class="badge bg-primary">Terkirim</span>
                        @endif
                    </td>
                    <td></td>
                </tr>
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
