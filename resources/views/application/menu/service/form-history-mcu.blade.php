<div class="modal-body p-0">
    <div class="bg-youtube rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">History MCU</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <table id="data-history" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Nama MOU</th>
                    <th>Email</th>
                    <th>No Handphone</th>
                    <th>Status Pemeriksaan</th>
                    <th>Status Hasil</th>
                    <th>Status Konsultasi</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $datas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $datas->mou_peserta_name }}</td>
                        <td class="text-primary">{{ $datas->company_mou_name }}</td>
                        <td>{{ $datas->mou_peserta_email }}</td>
                        <td>{{ $datas->mou_peserta_no_hp }}</td>
                        {{-- Pemeriksaan --}}
                        <td>
                            @php
                                $pemeriksaan = DB::table('company_mou_agreement_sub')
                                    ->join(
                                        'master_pemeriksaan',
                                        'master_pemeriksaan.master_pemeriksaan_code',
                                        '=',
                                        'company_mou_agreement_sub.master_pemeriksaan_code',
                                    )
                                    ->where('company_mou_agreement_sub.mou_agreement_code', $datas->mou_agreement_code)
                                    ->get();
                            @endphp
                            @foreach ($pemeriksaan as $pem)
                                @php
                                    $check = DB::table('log_pemeriksaan_pasien')
                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                        ->where('mou_peserta_code', $datas->mou_peserta_code)
                                        ->first();
                                @endphp
                                @if ($check)
                                    @if ($check->log_pemeriksaan_status == 1)
                                        <li>{{ $pem->master_pemeriksaan_name }} <span
                                                class="fas fa-check-square text-success"></span></li>
                                    @else
                                        <li>{{ $pem->master_pemeriksaan_name }} <span
                                                class="fas fa-exclamation-circle text-warning"></span></li>
                                    @endif
                                @else
                                    <li>{{ $pem->master_pemeriksaan_name }} <span
                                            class="fas fa-window-close text-danger"></span></li>
                                @endif
                            @endforeach
                            {{-- @if ($konsul)
                                    <span class="badge bg-primary">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Belum Selesai</span>
                                @endif --}}
                        </td>
                        {{-- Pengiriman --}}
                        <td>
                            @php
                                $pengiriman = DB::table('log_pengiriman_pasien')
                                    ->where('mou_peserta_code', $datas->mou_peserta_code)
                                    ->first();
                            @endphp
                            @if ($pengiriman)
                                <span class="badge bg-primary">Terkirim</span><br>
                                {{ $pengiriman->log_pengiriman_date }}
                            @else
                                <span class="badge bg-danger">Belum Terkirim</span>
                            @endif
                        </td>
                        {{-- Konsultasi --}}
                        <td>
                            @php
                                $konsul = DB::table('log_konsultasi_pasien')
                                    ->where('mou_peserta_code', $datas->mou_peserta_code)
                                    ->first();
                            @endphp
                            @if ($konsul)
                                <span class="badge bg-primary">Sudah dilakukan</span>
                            @else
                                <span class="badge bg-danger">Belum dilakukan</span>
                            @endif
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
  <script>
        new DataTable('#data-history', {
            responsive: true
        });
    </script>
