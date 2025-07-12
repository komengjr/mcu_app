<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Data Peserta MCU : <strong>{{ $data->master_company_name }} -
                {{ $data->company_mou_name }}</strong></h4>
        <p class="text-white fs--2 mb-0">Support by <a class="fw-semi-bold text-white" href="#!">Transforma</a></p>
    </div>
    <div class="tab-content p-3">
        <span class="badge bg-danger">Belum MCU</span>
        <table id="data-v3" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    {{-- <th>Email</th> --}}
                    <th>No HP</th>
                    <th>NIP</th>
                    <th>Departemen</th>
                    <th>Status Pemeriksaan</th>
                    <th>Status Konsultasi</th>
                    <th>Status Pengiriman Hasil</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                    $no = 1;
                @endphp
                @foreach ($peserta as $pesertas)
                    @php
                        $log = DB::table('log_lokasi_pasien')
                            ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                            ->first();
                    @endphp
                    @if (!$log)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pesertas->mou_peserta_name }}</td>
                            <td>{{ $pesertas->mou_peserta_nik }}</td>
                            <td>{{ $pesertas->mou_peserta_ttl }}</td>
                            <td>
                                @if ($pesertas->mou_peserta_jk == 'L')
                                    Laki - Laki
                                @else
                                    Perempuan
                                @endif
                            </td>
                            {{-- <td>{{ $pesertas->mou_peserta_email }}</td> --}}
                            <td>{{ $pesertas->mou_peserta_no_hp }}</td>
                            <td>{{ $pesertas->mou_peserta_nip }}</td>
                            <td>{{ $pesertas->mou_peserta_departemen }}</td>
                            <td>
                                @php
                                    $pemeriksaan = DB::table('company_mou_agreement_sub')
                                        ->join(
                                            'master_pemeriksaan',
                                            'master_pemeriksaan.master_pemeriksaan_code',
                                            '=',
                                            'company_mou_agreement_sub.master_pemeriksaan_code',
                                        )
                                        ->where(
                                            'company_mou_agreement_sub.mou_agreement_code',
                                            $pesertas->mou_agreement_code,
                                        )
                                        ->get();
                                @endphp
                                @foreach ($pemeriksaan as $pem)
                                    @php
                                        $check = DB::table('log_pemeriksaan_pasien')
                                            ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                            ->where('mou_peserta_code', $pesertas->mou_peserta_code)
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
                            </td>
                            <td>
                                @php
                                    $konsul = DB::table('log_konsultasi_pasien')
                                        ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                                        ->first();
                                @endphp
                                @if ($konsul)
                                    <span class="badge bg-primary">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Belum Selesai</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $pengiriman = DB::table('log_pengiriman_pasien')
                                        ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                                        ->first();
                                @endphp
                                @if ($pengiriman)
                                    <span class="badge bg-primary">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Belum Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-v3', {
        responsive: true
    });
</script>
