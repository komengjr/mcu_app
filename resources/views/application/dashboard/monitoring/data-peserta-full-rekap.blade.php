<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data Peserta MCU<strong>{{ $data->master_company_name }} -
                {{ $data->company_mou_name }}</strong></h4>
        <p class="text-white fs--2 mb-0">Support by <a class="fw-semi-bold text-white" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <div class="card mb-3 border">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Back to inbox" aria-label="Back to inbox">
                        <span class="fas fa-undo"></span>
                    </a>
                    <span class="mx-1 mx-sm-2 text-300">|</span>
                    @foreach ($paket as $pak)
                    <button class="btn btn-falcon-default btn-sm mx-1" type="button" id="button-monitoring-pilih-paket" data-code="{{$pak->company_mou_code}}" data-id="{{$pak->mou_agreement_code}}">
                        {{$pak->mou_agreement_name}}
                    </button>
                    @endforeach
                </div>
                <div class="d-flex">
                    <div class="d-none d-md-block">
                        <button class="btn btn-falcon-default btn-sm ms-2" type="button"><svg class="svg-inline--fa fa-chevron-left fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
                            </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                        <button class="btn btn-falcon-default btn-sm ms-2" type="button"><svg class="svg-inline--fa fa-chevron-right fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
                            </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                    </div>
                    <div class="dropdown font-sans-serif">
                        <button class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none ms-2" type="button" id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cog" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path>
                            </svg><!-- <span class="fas fa-cog"></span> Font Awesome fontawesome.com --></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-settings"><a class="dropdown-item" href="#!">Configure inbox</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Settings</a><a class="dropdown-item" href="#!">Themes</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Send feedback</a><a class="dropdown-item" href="#!">Help</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span id="peserta-monitoring-mcu">
            <table id="example" class="table table-striped" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>NO</th>
                        <th>NIP</th>
                        <th>NAMA PESERTA</th>
                        <th>JENIS KELAMIN</th>
                        <th>DEPARTEMEN</th>
                        <th>WILAYAH</th>
                        <th>LOKASI MCU </th>
                        @foreach ($pem as $pems)
                        <th>{{$pems->master_pemeriksaan_name}}</th>
                        @endforeach

                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($peserta as $pes)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pes->mou_peserta_nip }}</td>
                        <td>{{ $pes->mou_peserta_name }}</td>
                        <td>{{ $pes->mou_peserta_jk }}</td>
                        <td>{{ $pes->mou_peserta_departemen }}</td>
                        <td>{{ $pes->group_cabang_name }}</td>
                        <td>{{ $pes->master_cabang_name }}</td>
                        @foreach ($pem as $pems)
                        <?php
                        $status = DB::table('log_pemeriksaan_pasien')
                            ->where('mou_peserta_code', $pes->mou_peserta_code)
                            ->where('master_pemeriksaan_code', $pems->master_pemeriksaan_code)->first();
                        ?>
                        <th class="text-center fs--1">
                            @if ($status)
                            @if ($status->log_pemeriksaan_status == 1)
                            <span style="color: green;" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa">Y</span>
                            @else
                            <span class="text-warning" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="{{$status->log_pemeriksaan_deskripsi}}">!</span><span> : {{$status->log_pemeriksaan_deskripsi}}</span>
                            @endif
                            @else
                            <span class="text-danger" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Diperiksa">X</span>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </span>
    </div>
</div>
<script>
    new DataTable('#example', {
        responsive: true,

        layout: {
            topStart: {
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: 'Export Excel',
                    title: 'Data MCU {{ $data->master_company_name }} - {{ $data->company_mou_name }}'
                }],
            }
        }
    });
</script>
