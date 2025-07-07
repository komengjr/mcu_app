<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Form Add Cabang Group</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_group_cabang_save_cabang') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <input type="text" name="code" value="{{$code}}" id="" hidden>
        <div class="col-md-12">
            <label class="form-label" for="inputAddress">Pilih Cabang</label>
            <select name="cabang" class="form-select choices-single-cabang" id="" required>
                <option value="">Pilih Cabang</option>
                @foreach ($cabang as $cabangs)
                    <option value="{{ $cabangs->master_cabang_code }}">{{ $cabangs->master_cabang_name }}</option>
                @endforeach
            </select>
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
</script>
