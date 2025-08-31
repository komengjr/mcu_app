<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Daftar Kehadiran MCU : Total Kehadiran Peserta <strong>{{ $peserta }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-2 pb-0">
        <div class="card mb-3 border">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <select name="page_data" id="page_data" class="form-control">
                        <option value="">Pilih Page</option>
                        <option value="all">All</option>
                        @php
                            $cetak = $peserta;
                            $no = 0;
                        @endphp
                        @for ($i = 1; $i < 100; $i++)
                            @if ($cetak < 0)
                            @else
                                <option value="{{ $i }}">Page {{ $i }} </option>
                            @endif
                            @php
                                $cetak = $cetak - 100;
                            @endphp
                        @endfor
                    </select>
                </div>
                <div class="d-flex">
                    <div class="dropdown font-sans-serif">
                        <button class="btn btn-falcon-primary btn-sm"
                            id="button-cetak-data-kehadiran-peserta-mcu" data-code="{{ $code }}">Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="report-kehadiran-mcu" class="p-2"></div>
</div>

