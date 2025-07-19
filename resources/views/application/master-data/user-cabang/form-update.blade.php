<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Form Update User</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_user_cabang_update_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Nama Lengkap</label>
            <input class="form-control" id="inputAddress" type="text" name="nama_lengkap"
                value="{{ $data->fullname }}" required />
            <input type="text" name="code" value="{{ $data->userid }}" hidden>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Email</label>
            <input class="form-control" id="inputAddress" type="text" name="email" value="{{ $data->email }}"
                required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">No Handphone</label>
            <input class="form-control" id="inputAddress" type="text" name="no_hp"
                value="{{ $data->number_handphone }}" required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Username</label>
            <input class="form-control" id="inputAddress" type="text" name="username" value="{{ $data->username }}"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Password</label>
            <input class="form-control" id="inputAddress" type="text" name="password" placeholder="********" />
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-cabang"));
    new window.Choices(document.querySelector(".choices-single-akses"));
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
