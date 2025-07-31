 <table id="data-pemeriksaan" class="table table-striped border" style="width:100%">
     <thead class="bg-200 text-700 fs--2">
         <tr>
             <th>No</th>
             <th>Pemeriksaaan</th>
             <th class="text-end">Action</th>
         </tr>
     </thead>
     <tbody class="fs--2">
         @php
         $no = 1;
         @endphp
         @foreach ($pemeriksaan as $item)
         <tr>
             <td style="width: 5%;">{{ $no++ }}</td>
             <td>{{ $item->master_pemeriksaan_name }}</td>
             <td></td>
         </tr>
         @endforeach
         @foreach ($pemeriksaan1 as $item)
         <tr>
             <td style="width: 5%;">{{ $no++ }}</td>
             <td>{{ $item->master_pemeriksaan_name }}</td>
             <td class="text-end"><button class="btn btn-danger btn-sm" id="button-remove-pemeriksaan-peserta-mcu" data-code="{{ $item->mou_peserta_code }}" data-pem="{{ $item->master_pemeriksaan_code }}"><span class="fas fa-trash"></span> Remove</button></td>
         </tr>
         @endforeach
     </tbody>
 </table>
 <script>
     new DataTable('#data-pemeriksaan', {
         responsive: true
     });
 </script>
