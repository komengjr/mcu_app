@foreach ($data as $datas)
    <div class="card border border-danger mb-2">
        <div class="col-12 p-card border border-bottom ">
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="position-relative h-sm-100"><a class="d-block h-100" href="#"><img
                                class="img-fluid fit-cover w-sm-100 h-sm-100 rounded-1 absolute-sm-centered"
                                src="{{ asset('img/company/mcu.jpg') }}" alt="" /></a>
                        <div
                            class="badge rounded-pill bg-success position-absolute top-0 end-0 me-2 mt-2 fs--2 z-index-2">
                            MOU</div>
                    </div>
                </div>
                @php
                    $total = DB::table('company_mou_peserta')
                        ->where('company_mou_code', $datas->company_mou_code)
                        ->count();
                    $totalmcu = DB::table('log_lokasi_pasien')
                        ->join(
                            'company_mou_peserta',
                            'company_mou_peserta.mou_peserta_code',
                            '=',
                            'log_lokasi_pasien.mou_peserta_code',
                        )
                        ->join(
                            'master_cabang',
                            'master_cabang.master_cabang_code',
                            '=',
                            'log_lokasi_pasien.lokasi_cabang',
                        )
                        ->where('company_mou_peserta.company_mou_code', $datas->company_mou_code)
                        ->count();
                @endphp
                <div class="col-sm-8 col-md-9">
                    <div class="row">
                        <div class="col-lg-10">
                            <h5 class="mt-3 mt-sm-0"><a class="text-dark fs-0 fs-lg-1"
                                    href="#">{{ $datas->company_mou_name }}
                                </a></h5>
                            <p class="fs--1 mb-2 mb-md-2"><a class="text-500"
                                    href="#!">{{ $datas->master_company_name }}</a></p>
                            <div class="row g-3">
                                <div class="col-md-8 mt-0">
                                    <div class="card p-3 my-2 border border-danger">
                                        {{-- <h6 class="fw-semi-bold ls text-uppercase">Informasi Perusahaan</h6> --}}
                                        <div class="row">
                                            <div class="col-7 col-sm-7">
                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Total Peserta</p>
                                            </div>
                                            <div class="col">
                                                <h5 class="fs--1 fs-md-1 text-warning mb-0">
                                                    {{ $total }}
                                                    Peserta
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-sm-7">
                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Total Sudah Check
                                                    In
                                                </p>
                                            </div>
                                            <div class="col">
                                                <h5 class="fs--1 fs-md-1 text-warning mb-0">
                                                    {{ $totalmcu }}
                                                    Peserta
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-sm-7">
                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Total Belum Check
                                                    In
                                                </p>
                                            </div>
                                            <div class="col">
                                                <h5 class="fs--1 fs-md-1 text-warning mb-0">
                                                    {{ $total - $totalmcu }}
                                                    Peserta
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-sm-7">
                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Persentase</p>
                                            </div>
                                            <div class="col">
                                                <h5 class="fs-1 fs-md-2 text-primary mb-0">
                                                    @if ($total == 0)
                                                        0
                                                    @else
                                                        {{ round(($totalmcu / $total) * 100, 2) }}
                                                    @endif
                                                    %
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-0">
                                    <div class="card p-3 my-2 border border-danger">
                                        {{-- <h6 class="fw-semi-bold ls text-uppercase">Informasi Perusahaan</h6> --}}
                                        <div class="d-lg-block">
                                            <p class="fs--1 mb-0">Date : <strong
                                                    class="text-success">{{ date('d-m-Y', strtotime($datas->company_mou_start)) }}
                                                    -
                                                    {{ date('d-m-Y', strtotime($datas->company_mou_end)) }}
                                                </strong></strong>
                                            </p>
                                            <p class="fs--1 mb-1">MCU : <strong class="text-success">Available</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <ul class="list-unstyled d-none d-lg-block">
                                            @php
                                                $pemeriksaan = DB::table('company_mou_pemeriksaan')
                                                    ->join(
                                                        'master_pemeriksaan',
                                                        'master_pemeriksaan.master_pemeriksaan_code',
                                                        '=',
                                                        'company_mou_pemeriksaan.master_pemeriksaan_code',
                                                    )
                                                    ->where(
                                                        'company_mou_pemeriksaan.company_mou_code',
                                                        $datas->company_mou_code,
                                                    )
                                                    ->get();
                                            @endphp
                                            @foreach ($pemeriksaan as $item)
                                                <li><span class="fas fa-circle" data-fa-transform="shrink-12"></span>
                                                    {{ $item->master_pemeriksaan_name }}</li>
                                            @endforeach

                                        </ul> --}}
                        </div>
                        <div class="col-lg-2 justify-content-between flex-column ">
                            <div class="mt-2 g-2 float-end">
                                <a class="btn btn-sm btn-warning border-300 d-lg-block me-lg-0"href="#!"
                                    id="button-print-peserta" data-bs-toggle="modal" data-bs-target="#modal-monitoring"
                                    data-code="{{ $datas->company_mou_code }}">
                                    <span class="far fa-file-pdf"></span>
                                    <span class="ms-2 d-none d-md-inline-block">Report</span></a>
                                <a class="btn btn-sm btn-primary d-lg-block mt-lg-2" href="#!"
                                    id="button-detail-peserta" data-bs-toggle="modal" data-bs-target="#modal-monitoring"
                                    data-code="{{ $datas->company_mou_code }}">
                                    <span class="far fa-user"></span>
                                    <span class="ms-2 d-none d-md-inline-block">Peserta</span></a>
                                <a class="btn btn-sm btn-danger d-lg-block mt-lg-2" href="#!"
                                    id="button-rekap-full-peserta" data-bs-toggle="modal"
                                    data-bs-target="#modal-monitoring" data-code="{{ $datas->company_mou_code }}">
                                    <span class="far fa-address-card"></span>
                                    <span class="ms-2 d-none d-md-inline-block">Rekap</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
