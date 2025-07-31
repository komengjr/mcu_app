<div class="row pt-2">
    <input type="text" name="peserta_code" id="peserta_code" value="{{ $code }}" hidden>
    <input type="text" name="mou_code" id="mou_code" value="{{ $mou }}" hidden>
    <div class="col-12">
        <label for="">Pilih Pemeriksaaan</label>
        <select name="pemeriksaan" id="pemeriksaan" class="form-select choices-single-pemeriksaan" id="" required>
            <option value="">Pilih Pemeriksaan</option>
            @foreach ($data as $datas)
            <option value="{{ $datas->master_pemeriksaan_code  }}">{{ $datas->master_pemeriksaan_name  }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 pt-3">
        <button class="btn btn-primary btn-sm" id="button-simpan-penambahan-pemeriksaan-peserta-mcu">Simpan</button>
    </div>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-pemeriksaan"));
</script>
