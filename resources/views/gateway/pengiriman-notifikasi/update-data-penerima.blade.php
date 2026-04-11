 <form action="{{ route('gateway_pengiriman_notifikasi_save_data_penerima') }}" class="row g-3" method="post" enctype="multipart/form-data">
     @csrf
     <div class="col-md-12">
         <label class="form-label" for="inputAddress">Nama Lengkap <small class="text-danger">Wajib diisi</small></label>
         <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" value="{{ $data->gateway_penerima_name }}" style="text-transform: uppercase;"
             required />
         <input type="text" name="code" value="{{ $data->gateway_penerima_code }}" hidden>
     </div>
     <div class="col-md-6">
         <label class="form-label" for="inputAddress">No Hp <small class="text-danger">Wajib diisi</small></label>
         <input class="form-control" id="no_hp" type="text" name="no_hp" value="{{ $data->gateway_penerima_no_hp }}"
             required />
     </div>
     <div class="col-md-6">
         <label class="form-label" for="inputAddress">Jenis Kelamin <small class="text-danger">Wajib diisi</small></label>
         <select name="jk" class="form-control" id="jk">
             @if ($data->gateway_penerima_jk == 'L')
             <option value="L">Laki - Laki</option>
             <option value="P">Perempuan</option>
             @else
             <option value="P">Perempuan</option>
             <option value="L">Laki - Laki</option>
             @endif
         </select>
     </div>
     <div class="col-md-12">
         <button class="btn btn-warning btn-sm" type="submit">Update Data</button>
     </div>
 </form>
