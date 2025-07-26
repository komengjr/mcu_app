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
                    <h4 class="text-danger fw-bold mb-0">Pengiriman <span class="text-danger fw-medium">MCU Mail</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-danger">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">New message</h5>
            </div>
            <div class="col-auto py-0">
                <div class="btn-group  float-end" role="group">
                    <button class="btn btn-sm btn-falcon-danger dropdown-toggle" id="btnGroupVerticalDrop2"
                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-mcu"
                            id="button-data-history-mcu"><span class="far fa-folder-open"></span>
                            History</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form class="card">

        <div class="card-body p-0">
            <div class="border border-top-0 border-200">
                <input class="form-control border-0 rounded-0 outline-none px-card" id="email-to" type="email" aria-describedby="email-to" placeholder="To" />
            </div>
            <div class="border border-y-0 border-200">
                <input class="form-control border-0 rounded-0 outline-none px-card" id="email-subject" type="text" aria-describedby="email-subject" placeholder="Subject" />
            </div>
            <div class="min-vh-50">
                <textarea class="tinymce d-none" name="content"></textarea>
            </div>
            <div class="bg-light px-card py-3">
                <div class="d-inline-flex flex-column">
                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1"><span class="fs-1 far fa-image"></span><span class="ms-2">winter.jpg (873kb)</span><a class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right" title="Detach"><span class="fas fa-times"></span></a></div>
                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1"><span class="fs-1 far fa-file-archive"></span><span class="ms-2">coffee.zip (342kb)</span><a class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right" title="Detach"><span class="fas fa-times"></span></a></div>
                </div>
            </div>
        </div>
        <div class="card-footer border-top border-200 d-flex flex-between-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-primary btn-sm px-5 me-2" type="submit">Send</button>
                <input class="d-none" id="email-attachment" type="file" />
                <label class="me-2 btn btn-light btn-sm mb-0 cursor-pointer" for="email-attachment" data-bs-toggle="tooltip" data-bs-placement="top" title="Attach files"><span class="fas fa-paperclip fs-1" data-fa-transform="down-2"></span></label>
                <input class="d-none" id="email-image" type="file" accept="image/*" />
                <label class="btn btn-light btn-sm mb-0 cursor-pointer" for="email-image" data-bs-toggle="tooltip" data-bs-placement="top" title="Attach images"><span class="fas fa-image fs-1" data-fa-transform="down-2"></span></label>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown font-sans-serif me-2 btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" id="email-options" type="button" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-v" data-fa-transform="down-2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-options"><a class="dropdown-item" href="#!">Print</a><a class="dropdown-item" href="#!">Check spelling</a><a class="dropdown-item" href="#!">Plain text mode</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Archive</a>
                    </div>
                </div>
                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"> <span class="fas fa-trash"></span></button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-mcu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-mcu-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu-xl"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>


@endsection
