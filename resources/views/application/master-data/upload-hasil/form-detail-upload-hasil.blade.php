<style>
    input[type="file"] {
        display: none;
    }
</style>
<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Proses & Upload Order Pasien</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    @if ($cek->monitoring_hasil_pasien_status == '0')
    <div class="p-4">
        <span class="badge bg-danger">Sample Belum Di ambil</span>
    </div>
    @elseif ($cek->monitoring_hasil_pasien_status == '1')

    <form id="form-proses-pasien" class="row g-3 p-4" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Nama Lengkap</label>
            <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" value="{{ $cek->monitoring_hasil_pasien_nama }}"
                disabled />
            <input type="text" value="{{ $cek->monitoring_hasil_pasien_code }}" name="no_code" hidden>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
            <input class="form-control" id="tgl_lahir" type="date" name="tgl_lahir" value="{{ $cek->monitoring_hasil_pasien_tgl_lahir }}" disabled />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">No Registrasi</label>
            <input class="form-control" id="no_reg" type="text" name="no_reg" placeholder="PAXXXXXX"
                required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">NIK</label>
            <input class="form-control" id="no_induk" type="text" name="no_induk" value="{{ $cek->monitoring_hasil_pasien_nik }}" disabled />
        </div>
    </form>
    <div class="modal-footer" id="button-loading">
        <button class="btn btn-primary btn-sm" id="button-proses-data-pasien">Simpan & Proses</button>
    </div>
    @elseif ($cek->monitoring_hasil_pasien_status == '2')
    <form id="form-proses-pasien" class="row g-3 p-4" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Nama Lengkap</label>
            <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" value="{{ $cek->monitoring_hasil_pasien_nama }}"
                disabled />
            <input type="text" value="{{ $cek->monitoring_hasil_pasien_code }}" name="no_code" hidden>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
            <input class="form-control" id="tgl_lahir" type="date" name="tgl_lahir" value="{{ $cek->monitoring_hasil_pasien_tgl_lahir }}" disabled />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">No Registrasi</label>
            <input class="form-control" id="no_reg" type="text" name="no_reg" value="{{ $cek->monitoring_hasil_pasien_reg }}" disabled />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">NIK</label>
            <input class="form-control" id="no_induk" type="text" name="no_induk" placeholder="61XXXXXXXXXXXXXX"
                disabled />
        </div>

    </form>
    <div class="p-4">
        <table id="example" class="table table-striped fs--2" style="width:100%" border="1">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Nama Pemeriksaan</th>
                    <th>Status Pemeriksaan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                $data = DB::table('monitoring_hasil_pemeriksaan')
                ->join('master_pemeriksaan','master_pemeriksaan.master_pemeriksaan_code','=','monitoring_hasil_pemeriksaan.master_pemeriksaan_code')
                ->where('monitoring_hasil_pasien_code',$cek->monitoring_hasil_pasien_code)->get();
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->master_pemeriksaan_name }}</td>
                    <td class="text-center">
                        @if ($datas->monitoring_hasil_pemeriksaan_status == '0')
                        <span class="badge bg-danger">Belum</span>
                        @else
                        <span class="badge bg-primary">Sudah</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-dark btn-sm">Update</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row p-4">
        <div class="col-md-12">
            <label class="custom-file-upload form-control" id="upload-container">
                <input type="file" id="browseFile" class="form-control" />
                <span class="fas fa-cloud-upload-alt"></span> Upload File
            </label>
            <div class="progress  mt-3" style="height: 20px">
                <div class="progress-bar progress-bar-striped progress-bar-animated loading"
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                    style="width: 0%; height: 100%">0%</div>
            </div>
        </div>
        <div class="col-12">
            <input id="link" type="text" name="link" class="form-control" hidden>
            <!-- <span id="videoPreview"></span> -->
            <iframe id="videoPreview" src="" frameborder="0" style="width: 100%; height: 500px; display: none;"></iframe>
            <button type="button" class="btn btn-primary btn-sm mt-4" id="proses-selesai-upload" onclick="location.reload();" style="display: none;">Selesai</button>
        </div>
    </div>
    <script type="text/javascript">
        var browseFile = $('#browseFile');
        var resumable = new Resumable({
            target: "{{ route('master_upload_hasil_pemeriksaan_detail_proses_upload') }}",
            query: {
                _token: '{{ csrf_token() }}',
                code: "{{ $cek->monitoring_hasil_pasien_code }}",
            }, // CSRF token
            fileType: ['pdf'],
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file) { // trigger when file picked
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
            $('#proses-selesai-upload').show();
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
    @elseif ($cek->monitoring_hasil_pasien_status == '3')
    <form id="form-proses-pasien" class="row g-3 p-4" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Nama Lengkap</label>
            <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" value="{{ $cek->monitoring_hasil_pasien_nama }}"
                disabled />
            <input type="text" value="{{ $cek->monitoring_hasil_pasien_code }}" name="no_code" hidden>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Tanggal Lahir</label>
            <input class="form-control" id="tgl_lahir" type="date" name="tgl_lahir" value="{{ $cek->monitoring_hasil_pasien_tgl_lahir }}" disabled />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">No Registrasi</label>
            <input class="form-control" id="no_reg" type="text" name="no_reg" value="{{ $cek->monitoring_hasil_pasien_reg }}" disabled />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">NIK</label>
            <input class="form-control" id="no_induk" type="text" name="no_induk" placeholder="61XXXXXXXXXXXXXX"
                disabled />
        </div>

    </form>
    <div class="p-4">
        <table id="example" class="table table-striped fs--2" style="width:100%" border="1">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Nama Pemeriksaan</th>
                    <th>Status Pemeriksaan</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                $data = DB::table('monitoring_hasil_pemeriksaan')
                ->join('master_pemeriksaan','master_pemeriksaan.master_pemeriksaan_code','=','monitoring_hasil_pemeriksaan.master_pemeriksaan_code')
                ->where('monitoring_hasil_pasien_code',$cek->monitoring_hasil_pasien_code)->get();
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->master_pemeriksaan_name }}</td>
                    <td class="text-center">
                        @if ($datas->monitoring_hasil_pemeriksaan_status == '0')
                        <span class="badge bg-danger">Belum</span>
                        @else
                        <span class="badge bg-primary">Sudah</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row p-4">
        <div class="col-md-12">
            <label class="custom-file-upload form-control" id="upload-container">
                <input type="file" id="browseFile" class="form-control" />
                <span class="fas fa-cloud-upload-alt"></span> Upload Ulang
            </label>
            <div class="progress  mt-3" style="height: 20px">
                <div class="progress-bar progress-bar-striped progress-bar-animated loading"
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                    style="width: 0%; height: 100%">0%</div>
            </div>
        </div>
        <div class="col-12">
            <input id="link" type="text" name="link" class="form-control" hidden>
            <!-- <span id="videoPreview"></span> -->
            <iframe id="videoPreview" src="{{ asset($cek->monitoring_hasil_pasien_file) }}" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            <button type="button" class="btn btn-primary btn-sm mt-4" id="proses-selesai-upload" onclick="location.reload();" style="display: none;">Selesai</button>
        </div>
    </div>
    <script type="text/javascript">
        var browseFile = $('#browseFile');
        var resumable = new Resumable({
            target: "{{ route('master_upload_hasil_pemeriksaan_detail_proses_upload') }}",
            query: {
                _token: '{{ csrf_token() }}',
                code: "{{ $cek->monitoring_hasil_pasien_code }}",
            }, // CSRF token
            fileType: ['pdf'],
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file) { // trigger when file picked
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
            $('#proses-selesai-upload').show();
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

    @endif
</div>
