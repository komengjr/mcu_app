<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Detail Order Pasien</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        @if ($order->monitoring_hasil_pasien_status == 0)
        <div class="d-flex justify-content-center">
            <div class="p-2 fw-bold">Barcode Pengambilan Sample</div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="p-2 bg-300 border border-400">{!! QrCode::size(250)->generate(route('pengambilan_sample',['token'=>$order->monitoring_hasil_pasien_code])) !!}</div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="p-2">
                <button class="btn btn-falcon-warning"
                    onclick="window.open('{{ route('pengambilan_sample',['token'=>$order->monitoring_hasil_pasien_code]) }}','_blank')"><span class="fas fa-unlink"></span> Menuju
                    Link</button>
                <button class="btn btn-falcon-primary" id="button-report-absensi-mcu" data-code="$order->monitoring_hasil_pasien_code"><span class="fas fa-print"></span> Print</button>
            </div>
        </div>
        @elseif ($order->monitoring_hasil_pasien_status == 1)
        Menunggu Sampel Masih di Proses
        @elseif ($order->monitoring_hasil_pasien_status == 2)
        @elseif ($order->monitoring_hasil_pasien_status == 3)
        <iframe src="{{ asset($order->monitoring_hasil_pasien_file) }}" frameborder="0" style="width: 100%; height: 500px;"></iframe>
        @endif
    </div>
</div>
