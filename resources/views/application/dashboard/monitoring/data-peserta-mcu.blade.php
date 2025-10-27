<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data Peserta MCU : <strong>{{ $data->master_company_name }} -
                {{ $data->company_mou_name }}</strong></h4>
        <p class="text-white fs--2 mb-0">Support by <a class="fw-semi-bold text-white" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <table id="example" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Peserta</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    <th>Departemen</th>
                    <th>Status MCU</th>

                </tr>
            </thead>

        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // DataTable
        var table = $('#example').DataTable({
            "lengthMenu": [
                [10, 25, 500, 10000],
                [10, 25, 500, "All"]
            ],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('monitoring_mcu_detail_table',['id'=>$code]) }}",
            columns: [{
                    data: 'id',
                    "width": "4%"
                },
                {
                    data: 'nip'
                },
                {
                    data: 'nama_peserta',
                    className: 'text-right'
                },

                {
                    data: 'ttl',
                    className: 'text-right'
                },
                {
                    data: 'jk',
                    className: 'text-right'
                },
                {
                    data: 'departemen',
                },
                {
                    data: 'status',
                },

            ]

        });
    });
</script>
