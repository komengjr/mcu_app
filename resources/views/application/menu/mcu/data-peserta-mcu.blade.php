<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">
            Data Peserta MCU : <strong class="text-primary">{{ $data->master_company_name ?? '' }} - {{ $data->company_mou_name ?? '' }}</strong>
        </h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3" id="menu-table-peserta-mcu">
        <table id="data_Peserta" class="table table-striped fs--2" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th style="width: 4%">No</th>
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
        $('#data_Peserta').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('medical_check_up_detail_data', ['id' => $code]) }}",
            columns: [{
                    data: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_peserta'
                },
                {
                    data: 'nik',
                    className: 'text-end'
                },
                {
                    data: 'ttl',
                    className: 'text-end'
                },
                {
                    data: 'jk',
                    className: 'text-end'
                },
                {
                    data: 'email'
                },
                {
                    data: 'no_hp'
                },
                {
                    data: 'nip'
                },
                {
                    data: 'departemen'
                },
                {
                    data: 'paket',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'lokasi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'button',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
