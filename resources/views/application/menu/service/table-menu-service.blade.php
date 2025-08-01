<span class="badge bg-primary">Data Peserta {{ $perusahaan->company_mou_name }}</span>
<table id="example01" class="table table-striped nowrap border" style="width:100%">
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
            <td>
                {{ $datas->mou_peserta_name }} <br>
                <div class="btn-group pt-2" role="group">
                    <button class="btn btn-sm btn-danger dropdown-toggle" id="btnGroupVerticalDrop2"
                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><span class="fas fa-align-left me-1"
                            data-fa-transform="shrink-3"></span>Option</button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl"
                            id="button-proses-peserta-mcu" data-code="{{ $datas->mou_peserta_code }}"><span
                                class="far fa-folder-open"></span>
                            Proses Service</button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl"
                            id="button-proses-update-status-mcu" data-code="{{ $datas->mou_peserta_code }}" data-company="{{ $datas->company_mou_code }}"><span
                                class="fas fa-scroll"></span>
                            Update Pemeriksaan</button>
                    </div>
                </div>
            </td>
            <td class="text-primary">{{ $datas->company_mou_name }}</td>
            <td>{{ $datas->mou_peserta_email }}</td>
            <td>{{ $datas->mou_peserta_no_hp }}</td>
            {{-- Pemeriksaan --}}
            <td>
                @php
                $pemeriksaan = DB::table('company_mou_agreement_sub')
                ->join('master_pemeriksaan','master_pemeriksaan.master_pemeriksaan_code','=','company_mou_agreement_sub.master_pemeriksaan_code')
                ->where('company_mou_agreement_sub.mou_agreement_code',$datas->mou_agreement_code)
                ->get();
                $pemeriksaan1 = DB::table('company_mou_agreement_user')
                ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_user.master_pemeriksaan_code')
                ->where('company_mou_agreement_user.mou_peserta_code', $datas->mou_peserta_code)->get();
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
                <li>{{ $pem->master_pemeriksaan_name }}
                    <span type="button" class="fas fa-check-circle text-success" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Melakukan"></span>
                </li>
                @else
                <li>{{ $pem->master_pemeriksaan_name }}
                    <span type="button" class="far fa-times-circle text-warning" data-bs-toggle="tooltip" data-bs-placement="right" title="{{$check->log_pemeriksaan_deskripsi}}"></span>
                </li>
                @endif
                @else
                <li>{{ $pem->master_pemeriksaan_name }}
                    <span type="button" class="far fa-times-circle text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Melakukan"></span>
                </li>
                @endif
                @endforeach
                <!-- SECOUNd PEMERIKSAAN -->
                @foreach ($pemeriksaan1 as $pem)
                @php
                $check = DB::table('log_pemeriksaan_pasien')
                ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                ->where('mou_peserta_code', $datas->mou_peserta_code)
                ->first();
                @endphp
                @if ($check)
                @if ($check->log_pemeriksaan_status == 1)
                <li>{{ $pem->master_pemeriksaan_name }}
                    <span type="button" class="fas fa-check-circle text-success" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Melakukan"></span>
                </li>
                @else
                <li>{{ $pem->master_pemeriksaan_name }}
                    <span type="button" class="far fa-times-circle text-warning" data-bs-toggle="tooltip" data-bs-placement="right" title="{{$check->log_pemeriksaan_deskripsi}}"></span>
                </li>
                @endif
                @else
                <li>{{ $pem->master_pemeriksaan_name }}
                    <span type="button" class="far fa-times-circle text-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Melakukan"></span>
                </li>
                @endif
                @endforeach
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
<script>
    new DataTable('#example01', {
        responsive: true
    });
</script>
