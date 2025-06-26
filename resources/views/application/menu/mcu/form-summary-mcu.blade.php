<div class="modal-body p-0">
    <div class="bg-youtube rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Summary MCU : <strong class="text-white">{{$mou->company_mou_name}}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-3">
        <div class="progress_executive  mt-3" style="height: 20px; display: none;">
            <div class="progress-bar progress-bar-striped progress-bar-animated loading" role="progressbar"
                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%">0%
            </div>
        </div>
    </div>
    <div class="card-body p-3 pt-0">
        <div class="card-header bg-youtube">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-youtube m-0 p-0">Persentasi Hasil</span></h3>
                </div>
                <div class="col-auto"></div>
            </div>
        </div>
        <div class="card-body border border-youtube">
            <form class="row g-3 p-2" action="{{ route('medical_check_up_summary_save_persentasi') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $code }}" hidden>
                @if ($data)
                    @if ($data->summary_cabang_pesentasi == null)
                        <div class="col-md-4">
                            <label class="form-label text-warning" for="inputAddress">Persentasi Hasil</label>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman1" type="radio" name="persentasi"
                                    value="0" required />
                                <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="pengiriman2" type="radio" name="persentasi"
                                    value="1" required />
                                <label class="form-check-label mb-0" for="pengiriman2">Sudah Persentasi</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="">Upload Document</label>
                            <input type="file" id="browseFile" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <iframe src="" frameborder="0" id="videoPreview"
                                style="display: none;width: 100%; height: 400px;"></iframe>
                            <div class="progress  mt-3" style="height: 20px;display: none;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated loading"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 0%; height: 100%">0%
                                </div>
                            </div>
                            <input id="link" type="text" name="link" class="form-control" hidden>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                        </div>
                    @else
                        @if (!$data->summary_cabang_pesentasi_r == null)
                            <iframe src="{{ asset($data->summary_cabang_pesentasi_r) }}" frameborder="0"
                                style="width: 100%; height: 400px;"></iframe>
                        @endif

                    @endif
                @else
                    <div class="col-md-4">
                        <label class="form-label text-warning" for="inputAddress">Persentasi Hasil</label>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman1" type="radio" name="persentasi"
                                value="0" required />
                            <label class="form-check-label mb-0" for="pengiriman1">Tidak diperlukan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="pengiriman2" type="radio" name="persentasi"
                                value="1" required />
                            <label class="form-check-label mb-0" for="pengiriman2">Sudah Persentasi</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="">Upload Document</label>
                        <input type="file" id="browseFile" class="form-control" />
                    </div>
                    <div class="col-md-12">
                        <iframe src="" frameborder="0" id="videoPreview"
                            style="display: none;width: 100%; height: 400px;"></iframe>
                        <div class="progress  mt-3" style="height: 20px;display: none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated loading"
                                role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                style="width: 0%; height: 100%">0%
                            </div>
                        </div>
                        <input id="link" type="text" name="link" class="form-control" hidden>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body p-3 pt-0">
        <div class="card-header bg-youtube">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-youtube m-0 p-0">Executive Hasil</span></h3>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <div class="card-body border border-youtube">
            <form class="row g-3 p-2" action="{{ route('medical_check_up_summary_save_executive') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $code }}" hidden>
                @if ($data)
                    @if ($data->summary_cabang_executive == null)
                        <div class="col-md-4">
                            <label class="form-label text-warning" for="inputAddress">Executive Hasil</label>
                            <div class="form-check">
                                <input class="form-check-input" id="executive1" type="radio" name="executive"
                                    value="0" required />
                                <label class="form-check-label mb-0" for="executive1">Tidak diperlukan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="executive2" type="radio" name="executive"
                                    value="1" required />
                                <label class="form-check-label mb-0" for="executive2">Sudah dilakukan</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="">Upload Document</label>
                            <input type="file" id="browseFile_executive" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <iframe src="" frameborder="0" id="videoPreview_executive"
                                style="display: none;width: 100%; height: 400px;"></iframe>

                            <input id="link_executive" type="text" name="link_executive" class="form-control" hidden>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                        </div>
                    @else
                        @if (!$data->summary_cabang_executive_r == null)
                            <iframe src="{{ asset($data->summary_cabang_executive_r) }}" frameborder="0"
                                style="width: 100%; height: 400px;"></iframe>
                        @endif

                    @endif
                @else
                    <div class="col-md-4">
                        <label class="form-label text-warning" for="inputAddress">Executive Hasil</label>
                        <div class="form-check">
                            <input class="form-check-input" id="executive1" type="radio" name="executive"
                                value="0" required />
                            <label class="form-check-label mb-0" for="executive1">Tidak diperlukan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="executive2" type="radio" name="executive"
                                value="1" required />
                            <label class="form-check-label mb-0" for="executive2">Sudah dilakukan</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="">Upload Document</label>
                        <input type="file" id="browseFile_executive" class="form-control" />
                    </div>
                    <div class="col-md-12">
                        <iframe src="" frameborder="0" id="videoPreview_executive"
                            style="display: none;width: 100%; height: 400px;"></iframe>
                        <input id="link_executive" type="text" name="link_executive" class="form-control" hidden>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body p-3 pt-0">
        <div class="card-header bg-youtube">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-youtube m-0 p-0">Healty Talk</span></h3>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <div class="card-body border border-youtube">
            <form class="row g-3 p-2" action="{{ route('medical_check_up_summary_save_healty_talk') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" id="" value="{{ $code }}" hidden>
                @if ($data)
                    @if ($data->summary_cabang_ht == null)
                        <div class="col-md-4">
                            <label class="form-label text-warning" for="inputAddress">Healty Talk</label>
                            <div class="form-check">
                                <input class="form-check-input" id="healty_talk" type="radio" name="healty_talk"
                                    value="0" required />
                                <label class="form-check-label mb-0" for="healty_talk">Tidak diperlukan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="healty_talk" type="radio" name="healty_talk"
                                    value="1" required />
                                <label class="form-check-label mb-0" for="healty_talk">Sudah dilakukan</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="">Upload Documents</label>
                            <input type="file" id="browseFile_ha" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <iframe src="" frameborder="0" id="videoPreview_ha"
                                style="display: none;width: 100%; height: 400px;"></iframe>

                            <input id="link_ha" type="text" name="link_ha" class="form-control" hidden>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                        </div>
                    @else
                        @if (!$data->summary_cabang_ht_r == null)
                            <iframe src="{{ asset($data->summary_cabang_ht_r) }}" frameborder="0"
                                style="width: 100%; height: 400px;"></iframe>
                        @endif
                    @endif
                @else
                    <div class="col-md-4">
                        <label class="form-label text-warning" for="inputAddress">Healty Talk</label>
                        <div class="form-check">
                            <input class="form-check-input" id="healty_talk1" type="radio" name="healty_talk"
                                value="0" required />
                            <label class="form-check-label mb-0" for="healty_talk1">Tidak diperlukan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="healty_talk2" type="radio" name="healty_talk"
                                value="1" required />
                            <label class="form-check-label mb-0" for="healty_talk2">Sudah dilakukan</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="">Upload Documents</label>
                        <input type="file" id="browseFile_ha" class="form-control" />
                    </div>
                    <div class="col-md-12">
                        <iframe src="" frameborder="0" id="videoPreview_ha"
                            style="display: none;width: 100%; height: 400px;"></iframe>

                        <input id="link_ha" type="text" name="link_ha" class="form-control" hidden>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm float-end">Simpan Data</button>
                    </div>
                @endif
            </form>
        </div>
    </div>


</div>

</div>

{{-- UPLOAD PERSENTASI --}}
<script type="text/javascript">
    var browseFile = $('#browseFile');
    var resumable = new Resumable({
        target: "{{ route('file-upload.data_persentasi') }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['pdf'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile);

    resumable.on('fileAdded', function(file) { // trigger wn file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').show();
        $('#videoPreview').attr('src', response.path);
        $('#link').attr('value', response.filename);
        $('.card-footer').show();
        $('#browseFile').hide();
    });

    resumable.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });


    var progress = $('.progress');

    function showProgress() {
        progress.find('.loading').css('width', '0%');
        progress.find('.loading').html('0%');
        progress.find('.loading').removeClass('bg-info');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.loading').css('width', ` ${value}%`)
        progress.find('.loading').html(`${value}%`)
    }

    function hideProgress() {
        progress.hide();
    }
</script>
{{-- UPLOAD EXECUTIVE --}}
<script type="text/javascript">
    var browseFile_executive = $('#browseFile_executive');
    var resumable_executive = new Resumable({
        target: "{{ route('file-upload.data_executive') }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['pdf'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable_executive.assignBrowse(browseFile_executive);

    resumable_executive.on('fileAdded', function(file) { // trigger wn file picked
        showProgress();
        resumable_executive.upload() // to actually start uploading.
    });

    resumable_executive.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable_executive.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview_executive').show();
        $('#videoPreview_executive').attr('src', response.path);
        $('#link_executive').attr('value', response.filename);
        $('.card-footer').show();
        $('#browseFile_executive').hide();
    });

    resumable_executive.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });


    var progress_executive = $('.progress_executive');

    function showProgress() {
        progress_executive.find('.loading').css('width', '0%');
        progress_executive.find('.loading').html('0%');
        progress_executive.find('.loading').removeClass('bg-info');
        progress_executive.show();
    }

    function updateProgress(value) {
        progress_executive.find('.loading').css('width', ` ${value}%`)
        progress_executive.find('.loading').html(`${value}%`)
    }

    function hideProgress() {
        progress_executive.hide();
    }
</script>
{{-- UPLOAD HEALTY TALK --}}
<script type="text/javascript">
    var browseFile_ha = $('#browseFile_ha');
    var resumable_ha = new Resumable({
        target: "{{ route('file-upload.data_healty_talk') }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['pdf'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable_ha.assignBrowse(browseFile_ha);

    resumable_ha.on('fileAdded', function(file) { // trigger wn file picked
        showProgress();
        resumable_ha.upload() // to actually start uploading.
    });

    resumable_ha.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable_ha.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview_ha').show();
        $('#videoPreview_ha').attr('src', response.path);
        $('#link_ha').attr('value', response.filename);
        $('.card-footer').show();
        $('#browseFile_ha').hide();
    });

    resumable_ha.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });


    var progress_ha = $('.progress_ha');

    function showProgress() {
        progress_ha.find('.loading').css('width', '0%');
        progress_ha.find('.loading').html('0%');
        progress_ha.find('.loading').removeClass('bg-info');
        progress_ha.show();
    }

    function updateProgress(value) {
        progress_ha.find('.loading').css('width', ` ${value}%`)
        progress_ha.find('.loading').html(`${value}%`)
    }

    function hideProgress() {
        progress_ha.hide();
    }
</script>
