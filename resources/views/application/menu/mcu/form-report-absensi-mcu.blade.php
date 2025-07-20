<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Daftar Kehadiran MCU</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div id="report-kehadiran-mcu" class="p-2"></div>

</div>
<script>
    $('#report-kehadiran-mcu').html(
        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
    );
    $.ajax({
        url: "{{ route('medical_check_up_prosess_cetak_absensi_mcu') }}",
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
</script>
