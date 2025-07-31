<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Absensi Perusahaan </h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-2" id="menu-report-absensi-mcu">
        <div class="d-flex justify-content-center">
            <div class="p-2 fw-bold">Barcode Kehadiran MCU</div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="p-2 bg-300 border border-400">{!! QrCode::size(250)->generate(url('absensi/data-kehadiran-mcu/perusahaan', ['id' => $code])) !!}</div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="p-2">
                <button class="btn btn-falcon-warning"
                    onclick="window.open('{{ url('absensi/data-kehadiran-mcu/perusahaan', ['id' => $code]) }}','_blank')"><span class="fas fa-unlink"></span> Menuju
                    Link</button>
                    <button class="btn btn-falcon-primary" id="button-report-absensi-mcu" data-code="{{$code}}"><span class="fas fa-print"></span> Print</button>
            </div>
        </div>
    </div>
</div>
