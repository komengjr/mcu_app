<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Peserta MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3" id="menu-table-peserta-mcu">
        <table id="example" class="table table-striped fs--2" style="width:100%">
            <thead class="bg-200 text-700 ">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>NIP</th>
                    <th>Departemen</th>
                    <th>Paket</th>
                    <th>Lokasi Check In</th>
                    <th>Action</th>
                </tr>
            </thead>

        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // DataTable
        var table = $('#example').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('medical_check_up_detail_data',['id'=>$code]) }}",
            columns: [{
                    data: 'id',
                    "width": "4%"
                },
                {
                    data: 'nama_peserta'
                },
                {
                    data: 'nik',
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
                    data: 'email',
                },
                {
                    data: 'no_hp',
                },
                {
                    data: 'nip',
                },
                {
                    data: 'departemen',
                },
                {
                    data: 'paket',
                },
                {
                    data: 'lokasi',
                },
                {
                    data: 'button',
                },
            ]

        });
    });
</script>
