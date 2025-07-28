<div class="row">
    <div class="col-md-8" >
        <label for="organizerSingle" class="my-0">Pilih Project</label>
        <select class="form-select js-choice-project bg-light" id="project" name="project">
            <option value="">Pilih Project</option>
            @foreach ($data as $datas)
            <option value="{{ $datas->company_mou_code }} ">{{ $datas->company_mou_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4" >
        <label for="organizerSingle" class="my-0">Penerima</label>
        <select class="form-select js-choice-pro bg-light" id="project-site" name="project">
            <option value="">Pilih</option>
            <!-- <option value="all">All</option> -->
            <option value="single">Custom</option>

        </select>
    </div>
</div>
<script>
    new window.Choices(document.querySelector(".js-choice-project"));
    new window.Choices(document.querySelector(".js-choice-pro"));
    $('#project-site').on("change", function() {
        var dataproject = document.getElementById("project").value;
        var custom = document.getElementById("project-site").value;
        if (dataproject == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Sudah dipilih'
            });
        } else if(custom == "all"){
            $("#option-peserta").html("");
        } else {
            $.ajax({
                url: "{{ route('menu_pengiriman_pilih_project') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataproject,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#option-peserta").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
