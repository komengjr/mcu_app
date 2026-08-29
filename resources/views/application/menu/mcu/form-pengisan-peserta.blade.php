<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Daftar Form MCU</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Innoventra</a></p>
    </div>

    <!-- Dropdown Pilih Form MCU -->
    <div class="p-3 bg-light border-bottom">
        <div class="row align-items-center">
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bold text-700 mb-md-0" for="select-mcu-form">
                    <i class="fas fa-file-alt text-primary me-1"></i> Pilih Form MCU:
                </label>
            </div>
            <div class="col-md-9">
                <select id="select-mcu-form" class="form-select form-select-sm" data-mou="{{ $mou->company_mou_code }}">
                    <option value="">-- Pilih Form MCU --</option>
                    @foreach($forms as $form)
                    <option value="{{ $form->id_mcu_form }}">{{ $form->form_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Container Hasil Pengisian Peserta -->
    <div id="hasil-pengisian-form-pesertan-mcu" class="p-3">
        <div class="text-center py-4 text-500">
            <i class="fas fa-info-circle fa-2x mb-2 text-primary"></i>
            <p class="fs--1 mb-0">Silakan pilih salah satu Form MCU di atas untuk melihat status pengisian peserta.</p>
        </div>
    </div>
</div>

<script>
    $(document).off('change', '#select-mcu-form').on('change', '#select-mcu-form', function() {
        var idMcuForm = $(this).val();
        var mouCode = $(this).data('mou');

        if (!idMcuForm) {
            $('#hasil-pengisian-form-pesertan-mcu').html(`
                <div class="text-center py-4 text-500">
                    <i class="fas fa-info-circle fa-2x mb-2 text-primary"></i>
                    <p class="fs--1 mb-0">Silakan pilih salah satu Form MCU di atas untuk melihat status pengisian peserta.</p>
                </div>
            `);
            return;
        }

        $('#hasil-pengisian-form-pesertan-mcu').html(
            '<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        );

        $.ajax({
            url: "{{ route('medical_check_up_detail_pengisian_form') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id_mcu_form": idMcuForm,
                "mou_code": mouCode
            },
            dataType: 'html'
        }).done(function(data) {
            $('#hasil-pengisian-form-pesertan-mcu').html(data);
        }).fail(function() {
            $('#hasil-pengisian-form-pesertan-mcu').html('<div class="alert alert-danger fs--1 mb-0">Gagal memuat data pengisian peserta.</div>');
        });
    });
</script>
