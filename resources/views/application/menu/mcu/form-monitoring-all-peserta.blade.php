<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Monitoring Lokasi Peserta MCU</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div id="report-kehadiran-mcu" class="p-2">
        <table id="example" class="table table-striped fs--2 border" style="width:100%">
            <thead class="bg-200 text-700 ">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Departemen</th>
                    <th>Lokasi MCU</th>
                </tr>
            </thead>
            <tbody class="fs--2" border="1">

            </tbody>
        </table>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        // DataTable
        var table = $('#example').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('medical_check_up_data_mointoring_all_peserta_table', ['id' => $code]) }}",
            columns: [{
                data: 'id',
                "width": "4%"
            },
            {
                data: 'nip',
                className: 'text-right'
            },
            {
                data: 'nama_peserta'
            },
            {
                data: 'jk',
                className: 'text-right'
            },
            {
                data: 'email',
            },
            {
                data: 'no_hp',
            },
            {
                data: 'departemen',
            },
            {
                data: 'lokasi',
            },
            ]

        });
    });
</script>
