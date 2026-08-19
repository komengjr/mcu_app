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
        @php
        $ttd = DB::table('monitoring_hasil_kurir')->where('monitoring_hasil_pasien_code',$order->monitoring_hasil_pasien_code)->first();
        @endphp
        @if ($ttd)
        <div class="card-body">
            <h6 class="mb-3 text-primary">Proses Pengantaran : </h6>
            <p>Pastikan Orderan ini Sudah Benar dan Sesuai dengan Kurir yang akan mengambil Sample</p>
            <div class="row">
                <div class="col-6">
                    <p><strong>Rujukan</strong><br></p>

                    <p><strong>Name Pasien : </strong>{{ $order->monitoring_hasil_pasien_nama }}<br></p>
                    <p><strong>Tanggal Lahir : </strong>{{ $order->monitoring_hasil_pasien_tgl_lahir }}<br></p>
                    <p><strong>Date Create : </strong>{{ $order->created_at }}</p>
                </div>
                <div class="col-6">
                    <p><strong>Signature <img src="{{$ttd->monitoring_hasil_kurir_sign}}" width="150"></strong><br></p>
                    <p><strong>Nama Kurir : </strong>{{$ttd->monitoring_hasil_kurir_name}}<br></p>
                    <p><strong>Date Signed: </strong>{{ $ttd->monitoring_hasil_kurir_date }}</p>
                </div>
            </div>
        </div>
        @endif
        @elseif ($order->monitoring_hasil_pasien_status == 2)
        @elseif ($order->monitoring_hasil_pasien_status == 3)
        <iframe src="{{ route('monitoring_hasil_detail_pasien_view_file', ['code' => $order->monitoring_hasil_pasien_code]) }}" frameborder="0" style="width: 100%; height: 500px;"></iframe>
        @endif
    </div>
</div>
