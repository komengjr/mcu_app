<div class="col">
    <label for="organizerSingle" class="my-0 text-white">Pilih Agreement</label>
    <select class="form-select js-choice-paket bg-light mb-0" id="agreement" name="agreement">
        <option value="">Select Paket</option>
        @foreach ($paket as $pak)
        <option value="{{ $pak->company_mou_code }}">{{ $pak->company_mou_name }}</option>
        @endforeach
    </select>
</div>
<script>
    new window.Choices(document.querySelector(".js-choice-paket"));
    $('#agreement').on("change", function() {
        var dataid = document.getElementById("agreement").value;
        $("#table-service").html('<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>');
        if (dataid == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Sudah dipilih'
            });
        } else {
            $.ajax({
                url: "{{ route('menu_service_pilih_agreement') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#table-service").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
