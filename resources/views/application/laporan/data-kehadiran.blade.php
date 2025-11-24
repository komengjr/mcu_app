@extends('layouts.template')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-danger">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/company.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-danger fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-danger fw-bold mb-1">MCU <span class="text-danger fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                    <h4 class="text-danger fw-bold mb-0">Laporan <span class="text-danger fw-medium">Data
                            Kehadiran</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-danger">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-danger m-0 p-0">Data Kehadiran MCU</span></h3>
            </div>
            <div class="col-auto">

            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="progress" style="height: 30px;">
            <div id="progressBar"
                class="progress-bar progress-bar-striped progress-bar-animated"
                style="width: 0%; font-weight: bold;">
                0%
            </div>
        </div>
    </div>

    <div id="message" class="mt-3"></div>
    <div class="card-body border-top p-3">
        <table id="example" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>MOU Persuahaan</th>
                    <th>Nama Perusahaan</th>
                    <th>Jumlah Peserta</th>
                    <th>Jumlah Peserta Hadir</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fs--2">
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
                    <td>
                        @php
                        $hadir = DB::table('log_lokasi_pasien')
                        ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
                        ->where('company_mou_peserta.company_mou_code', $datas->company_mou_code)
                        ->count();
                        @endphp
                        {{ $hadir }}
                    </td>

                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <a href="#" id="button-download-pdf"
                                    class="dropdown-item text-warning"
                                    data-code="{{$datas->company_mou_code}}"><span class="fas fa-file-signature"></span>
                                    Download Absensi Kehadiran</a>
                                <!-- <div class="dropdown-divider"></div> -->
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-company" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-company"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-notif" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content border-0">
            {{-- <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
            <div id="menu-notif"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-download-pdf", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        document.getElementById('message').innerHTML = "";
        startProgressChecking();

        fetch('../../../application/laporan/laporan-data-kehadiran/preview/' + code)
            .then(response => response.blob())
            .then(blob => {
                stopProgressChecking();

                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');

                a.href = url;
                a.download = "users.pdf";
                a.click();

                document.getElementById('progressBar').style.width = "100%";
                document.getElementById('progressBar').innerHTML = "100%";

                document.getElementById('message').innerHTML = `
                <div class="alert alert-success">Export selesai!</div>
            `;
            })
            .catch(err => {
                stopProgressChecking();
                document.getElementById('message').innerHTML = `
                <div class="alert alert-danger">${err}</div>
            `;
            });
    });

    function startProgressChecking() {
        progressInterval = setInterval(() => {
            fetch('../../../export-progress')
                .then(res => res.json())
                .then(data => {
                    let p = data.progress;
                    const bar = document.getElementById('progressBar');

                    bar.style.width = p + "%";
                    bar.innerHTML = p + "%";
                });
        }, 700); // cek setiap 0.7 detik
    }

    function stopProgressChecking() {
        clearInterval(progressInterval);
    }
</script>
@endsection
