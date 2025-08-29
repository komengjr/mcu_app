<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Daftar Kehadiran MCU</h4>
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
                                <option value="{{ $i }}">Page {{ $i }}
                                </option>
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
                            id="button-cetak-data-kehadiran-peserta-mcu">Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="report-kehadiran-mcu" class="p-2"></div>
</div>
<script>
    $(document).on("click", "#button-cetak-data-kehadiran-peserta-mcu", function (e) {
        e.preventDefault();
        var page_data = document.getElementById("page_data").value;
        var code = $(this).data("code");
        if (page_data == "") {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Pilih Page Dulu Guys"
            });
        } else {
            $('#report-kehadiran-mcu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('medical_check_up_prosess_cetak_absensi_mcu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": '{{ $code }}',
                    "page": page_data
                },
                dataType: 'html',
            }).done(function (data) {
                $('#report-kehadiran-mcu').html(
                    '<iframe src="data:application/pdf;base64, ' +
                    data +
                    '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }).fail(function () {
                $('#report-kehadiran-mcu').html('eror');
            });
        }
    });
</script>
