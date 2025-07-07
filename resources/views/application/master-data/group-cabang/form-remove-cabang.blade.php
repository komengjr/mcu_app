<div class="modal-body p-0">
    <div class="bg-youtube rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Penghapusan Data Cabang</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_group_cabang_save_remove_cabang') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Yakin Untuk Hapus</label>
            <input type="text" name="code" value="{{ $code }}" id="" hidden>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Yakin</button>
        </div>
    </form>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-cabang"));
</script>
