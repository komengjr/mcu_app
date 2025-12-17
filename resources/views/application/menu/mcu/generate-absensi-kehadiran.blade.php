<div class="d-flex justify-content-center">
    <div class="p-2 fw-bold">Scan Kehadiran MCU</div>
</div>
<div class="d-flex justify-content-center">
    <div class="p-2 bg-300 border border-400">{!! QrCode::size(250)->generate(url('signaturepad/data-kehadiran-mcu/detail',['id'=>$token])) !!}</div>
</div>
<div class="d-flex justify-content-center">
    <div class="p-2" id="loading-proses-send-message">
        <button class="btn btn-falcon-warning" onclick="window.open('{{url('signaturepad/data-kehadiran-mcu/detail',['id'=>$token])}}','_blank')">Menuju Link</button>
        <button class="btn btn-success" id="button-kirim-whatsapp-peserta-mcu" data-code="{{ $token }}" data-id="{{ $nos->mou_peserta_code }}">Kirim Whatsapp ke no : {{ $nos->mou_peserta_no_hp }}</button>
    </div>
</div>
