<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data MOU Perusahaan</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="card-body border-top p-3">
        <table id="mou-table" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>MOU Persuahaan</th>
                    <th>Nama Perusahaan</th>
                    <th>Jumlah Peserta</th>
                    <th>Tanggal</th>
                    <th>Agreement</th>
                    <th>Status MOU</th>
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
                        <td>{{ $datas->company_mou_name }}</td>
                        <td>{{ $datas->master_company_name }}</td>
                        <td>
                            @php
                                $total = DB::table('company_mou_peserta')
                                    ->where('company_mou_code', $datas->company_mou_code)
                                    ->count();
                            @endphp
                            {{ $total }}
                        </td>
                        <td>{{ $datas->company_mou_start }} <br>{{ $datas->company_mou_end }}</td>
                        <td>
                            @php
                                $agreement = DB::table('company_mou_agreement')
                                    ->where('company_mou_code', $datas->company_mou_code)
                                    ->get();
                            @endphp
                            @foreach ($agreement as $item)
                                <li>{{ $item->mou_agreement_name }}</li>
                            @endforeach
                        </td>
                        <td>
                            @if ($datas->company_mou_status == 0)
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @else
                                <span class="badge bg-primary">Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-align-left me-1"
                                        data-fa-transform="shrink-3"></span>Option</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                    <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                        data-bs-target="#modal-company" id="button-add-companys" data-code="123"><span
                                            class="far fa-edit"></span>
                                        Edit Perusahaan</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-company"
                                        id="button-data-peserta-mcu" data-code="{{ $datas->company_mou_code }}">
                                        <span class="fas fa-user-friends"></span>
                                        Peserta MCU</button>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#modal-company-xl" id="button-data-insert-peserta"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <span class="fas fa-file-import"></span>
                                        Insert Peserta</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-company-sm" id="button-aktifasi-mou"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <span class="fab fa-galactic-republic"></span>
                                        Aktivasi MOU</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#mou-table', {
        responsive: true
    });
</script>
