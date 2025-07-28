 <div class="col" style="z-index: 999;">
     <!-- <label for="organizerSingle" class="my-0">Pilih Peserta</label> -->
     <label for="organizerMultiple">Pilih Peserta</label>
     <select class="form-select js-choice-peserta" id="pesertamcu" multiple="multiple" name="organizerMultiple" data-options='{"removeItemButton":true,"placeholder":true}'>
         <option value="">Cari Peserta...</option>
         @foreach ($data as $datas)
         <option value="{{$datas->mou_peserta_code }}">{{ $datas->mou_peserta_name }} - {{ $datas->mou_peserta_email }} - {{ $datas->mou_peserta_no_hp }}</option>
         @endforeach
     </select>
 </div>
 <script>
     new window.Choices(document.querySelector(".js-choice-peserta"));
 </script>
