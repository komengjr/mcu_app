<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Rekap</title>
    <link rel="stylesheet" href="style.css" media="all" />
</head>



<body>

    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <table style="margin: 0px; padding: 0px;">
                    <tr>
                        <td>Nama Perusahaan</td>
                        <td>:</td>
                        <td>{{ $data->master_company_name }}</td>
                    </tr>
                    <tr>
                        <td>Project</td>
                        <td>:</td>
                        <td>
                            {{ $data->company_mou_name }}
                        </td>
                    </tr>
                </table>
            </div>
            <div id="invoice">

            </div>
        </div>
        <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
            <thead style="font-size: 11px;">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Departemen</th>
                    <th>Lokasi MCU</th>
                    <th>Tanda Tangan</th>
                </tr>
            </thead>
            <tbody id="invoiceItems" style="font-size: 10px;">
                @php
                $urut = $no;
                @endphp
                @foreach ($peserta as $pesertas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pesertas->mou_peserta_nip }}</td>
                    <td>{{ $pesertas->mou_peserta_name }}</td>
                    <td>
                        @if ($pesertas->mou_peserta_jk == 'L')
                        Laki - Laki
                        @else
                        Perempuan
                        @endif
                    </td>
                    <td>{{ $pesertas->mou_peserta_email }}</td>
                    <td>{{ $pesertas->mou_peserta_no_hp }}</td>
                    <td>{{ $pesertas->mou_peserta_departemen }}</td>
                    <td>
                        @php
                        $lokasi = DB::table('log_lokasi_pasien')
                        ->join(
                        'master_cabang',
                        'master_cabang.master_cabang_code',
                        '=',
                        'log_lokasi_pasien.lokasi_cabang',
                        )
                        ->where('log_lokasi_pasien.mou_peserta_code', $pesertas->mou_peserta_code)
                        ->first();
                        @endphp
                        @if ($lokasi)
                        {{ $lokasi->master_cabang_name }}
                        @else
                        @endif
                    </td>

                    <td style="text-align: center;">
                        @php
                        $ttd = DB::table('log_kehadiran_pasien')
                        ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                        ->where('log_kehadiran_pasien_status', 1)
                        ->first();
                        @endphp
                        @if ($ttd)
                        <img src="{{$ttd->log_kehadiran_pasien_sign}}" width="40"> <br>
                        {{$ttd->log_kehadiran_pasien_time}}
                        @else
                        <strong style="color: rgb(199, 27, 24)">Belum</strong>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </main>
</body>

</html>
