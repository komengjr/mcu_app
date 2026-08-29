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
        <div class="card-body p-0">
            <div class="alert alert-light-primary border border-primary border-dashed rounded-3 p-3 mb-3">
                <h6 class="fw-bold text-primary mb-1">
                    <i class="fas fa-truck me-2"></i>Proses Pengantaran
                </h6>
                <p class="text-muted small mb-0">
                    Pastikan orderan ini sudah benar dan sesuai dengan kurir yang akan mengambil sample.
                </p>
            </div>

            <div class="row g-3">
                <!-- Informasi Rujukan & Pasien -->
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <span class="badge bg-primary mb-3">Informasi Pasien</span>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2 d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Nama Pasien</span>
                                <span class="fw-semibold text-end">{{ $order->monitoring_hasil_pasien_nama ?? '-' }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Tanggal Lahir</span>
                                <span class="fw-semibold text-end">{{ $order->monitoring_hasil_pasien_tgl_lahir ? date('d-m-Y', strtotime($order->monitoring_hasil_pasien_tgl_lahir)) : '-' }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Dibuat Pada</span>
                                <span class="fw-semibold text-end">{{ $order->created_at ? date('d-m-Y H:i', strtotime($order->created_at)) : '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Informasi Kurir & TTD -->
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-secondary mb-3">Verifikasi Kurir</span>
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-2 d-flex justify-content-between border-bottom pb-2">
                                    <span class="text-muted">Nama Kurir</span>
                                    <span class="fw-semibold text-end">{{ $ttd->monitoring_hasil_kurir_name ?? '-' }}</span>
                                </li>
                                <li class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                    <span class="text-muted">Waktu TTD</span>
                                    <span class="fw-semibold text-end">{{ !empty($ttd->monitoring_hasil_kurir_date) ? date('d-m-Y H:i', strtotime($ttd->monitoring_hasil_kurir_date)) : '-' }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Box Tanda Tangan -->
                        <div class="text-center pt-2">
                            <p class="text-muted small mb-1">Tanda Tangan</p>
                            <div class="border bg-white rounded p-2 d-flex align-items-center justify-content-center" style="min-height: 100px;">
                                @if(!empty($ttd) && !empty($ttd->monitoring_hasil_kurir_sign))
                                <img src="{{ $ttd->monitoring_hasil_kurir_sign }}" alt="Signature" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                                @else
                                <span class="text-muted fst-italic small">( Belum Ada TTD )</span>
                                @endif
                            </div>
                        </div>
                    </div>
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
