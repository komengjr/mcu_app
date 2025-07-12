<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Kehadiran Peserta MCU</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-2">
        <div class="card mt-1 border border-danger">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-sm-auto mb-2 mb-sm-0">
                        <h6 class="mb-0">Showing PDF</h6>
                    </div>
                    <div class="col-sm-auto">
                        <div class="row gx-2 align-items-center">
                            <div class="col-auto">
                                <form class="row gx-2">
                                    <div class="col-auto"><small>Sort by Group :</small></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions"
                                            id="group" name="group">
                                            <option data-id="">All</option>
                                            @foreach ($group as $groups)
                                                <option data-id="{{ $groups->group_cabang_code }}">
                                                    {{ $groups->group_cabang_name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="code_mou" id="code_mou"
                                            value="{{ $code }}" hidden>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="report-kehadiran-mcu" class="p-2"></div>
</div>
<script>
    $('#report-kehadiran-mcu').html(
        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
    );
    $.ajax({
        url: "{{ route('laporan_rekap_mcu_kehadiran_peserta_mcu_report') }}",
        type: "POST",
        cache: false,
        data: {
            "_token": "{{ csrf_token() }}",
            "code": '{{ $code }}'
        },
        dataType: 'html',
    }).done(function(data) {
        $('#report-kehadiran-mcu').html(
            '<iframe src="data:application/pdf;base64, ' +
            data +
            '" style="width:100%; height:533px;" frameborder="0"></iframe>');
    }).fail(function() {
        $('#report-kehadiran-mcu').html('eror');
    });

    $('#group').on("change", function() {
        var dataid = $("#group option:selected").attr('data-id');
        var code = document.getElementById("code_mou").value;
        $('#report-kehadiran-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        if (dataid == null) {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Layanan Sudah dipilih'
            });
        } else {
            $.ajax({
                url: "{{ route('laporan_rekap_mcu_kehadiran_peserta_mcu_report_group') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid,
                    "code": code,
                },
                dataType: 'html',
            }).done(function(data) {
                $('#report-kehadiran-mcu').html(
                    '<iframe src="data:application/pdf;base64, ' +
                    data +
                    '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
