<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Lokasi Perusahaan</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="card-body border-top p-3">
        <div class="card mb-3 border">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <a class="btn btn-falcon-default btn-sm" href="#" id="button-tambah-lokasi-perusahaan" data-code="{{ $code }}">
                        <span class="fas fa-plus-circle"></span> Tambah Lokasi
                    </a>
                </div>
                <div class="d-flex">

                </div>
            </div>
        </div>
        <span id="menu-table-location">
            <table id="mou-table" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-200 text-700 fs--3">
                    <tr>
                        <th>No</th>
                        <th>Nama Lokasi Perusahaan</th>
                        <th>Alamat Perusahaan</th>
                        <th>Handle Cabang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs--3">
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->company_location_name }}</td>
                        <td>{{ $datas->company_location_alamat }}</td>
                        <td>
                            @php
                                $handle = DB::table('company_location_handle')
                                ->join('master_cabang','master_cabang.master_cabang_code','=','company_location_handle.master_cabang_code')
                                ->where('company_location_handle.company_location_code',$datas->company_location_code)->get();
                            @endphp
                            @foreach ($handle as $han)
                                <li>{{ $han->master_cabang_name }} <a href="#" id="button-remove-lokasi-handle-cabang" data-code="{{ $han->id_company_location_handle }}"><span class="fas fa-trash-alt text-danger"></span></a></li>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-falcon-danger dropdown-toggle" id="btnGroupVerticalDrop2"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-align-left me-1"
                                        data-fa-transform="shrink-3"></span>Option</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                    <button class="dropdown-item" id="button-tambah-handle-cabang-company" data-code="{{$datas->company_location_code}}">
                                        <span class="nav-link-icon">
                                            <span class="far fa-edit"></span>
                                        </span>Tambah Handle Cabang</button>
                                </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </span>
    </div>
</div>
<script>
    new DataTable('#mou-table', {
        responsive: true
    });
</script>
