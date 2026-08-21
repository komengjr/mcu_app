<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Daftar Hadir Peserta MCU</title>
    <style>
        @page {
            margin: 120px 25px 50px 25px;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        /* Fixed Header di Setiap Halaman */
        header {
            position: fixed;
            top: -100px;
            left: 0px;
            right: 0px;
            height: 90px;
            border-bottom: 2px solid #db3311;
        }

        #logo {
            float: left;
            width: 150px;
        }

        #logo img {
            height: 55px;
            width: auto;
        }

        #company {
            float: right;
            text-align: right;
        }

        #company h2.name {
            font-size: 14px;
            font-weight: bold;
            color: #db3311;
            margin: 0 0 4px 0;
        }

        #company .date {
            font-size: 9px;
            color: #555555;
        }

        /* Fixed Footer/Page Numbering */
        footer {
            position: fixed;
            bottom: -35px;
            left: 0px;
            right: 0px;
            height: 20px;
            border-top: 1px solid #CCCCCC;
            padding-top: 5px;
            text-align: right;
            font-size: 8px;
            color: #777777;
        }

        .page-number:after {
            content: counter(page);
        }

        /* Detail Project Info */
        #details {
            margin-bottom: 12px;
            width: 100%;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 10px;
        }

        .client-box {
            border-left: 4px solid #db3311;
            padding-left: 8px;
        }

        /* Styling Tabel Utama Peserta */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        table.data-table thead {
            display: table-header-group;
            /* Otomatis ulang header di halaman baru */
        }

        table.data-table tr {
            page-break-inside: avoid;
            /* Mencegah baris terpotong di batas halaman */
            page-break-after: auto;
        }

        table.data-table th {
            background-color: #b90303;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #900202;
            white-space: nowrap;
        }

        table.data-table td {
            padding: 5px 4px;
            border: 1px solid #DDDDDD;
            vertical-align: middle;
        }

        /* Alternate Row Color untuk Pembacaan Lebih Mudah */
        table.data-table tbody tr:nth-child(even) {
            background-color: #F9F9F9;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-danger {
            color: #db3311;
            font-weight: bold;
        }

        .text-muted {
            color: #777777;
        }

        .img-ttd {
            height: 30px;
            max-width: 60px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <!-- Header Template (Otomatis Muncul di Tiap Halaman) -->
    <header>
        <div id="logo">
            <img src="data:image/png;base64, {{ $image }}">
        </div>
        <div id="company">
            <h2 class="name">DAFTAR HADIR PESERTA MCU</h2>
            <div class="date">Dicetak Pada: {{ now()->format('d/m/Y H:i') }} WIB</div>
        </div>
    </header>

    <!-- Footer Template -->
    <footer>
        Daftar Hadir MCU - Halaman <span class="page-number"></span>
    </footer>

    <!-- Body Utama -->
    <main>
        <div id="details">
            <table class="info-table">
                <tr>
                    <td width="70%">
                        <div class="client-box">
                            <table style="width: 100%;">
                                <tr>
                                    <td width="110"><strong>Nama Perusahaan</strong></td>
                                    <td width="10">:</td>
                                    <td>{{ $data->master_company_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Project</strong></td>
                                    <td>:</td>
                                    <td>{{ $data->company_mou_name }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td width="30%" style="text-align: right; vertical-align: middle;">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->format('svg')->size(45)->errorCorrection('H')->generate($data->company_mou_code)) !!}">
                    </td>
                </tr>
            </table>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="10%">NIP</th>
                    <th width="20%">Nama Peserta</th>
                    <th width="8%">JK</th>
                    <th width="15%">Email</th>
                    <th width="10%">No HP</th>
                    <th width="12%">Departemen</th>
                    <th width="12%">Lokasi MCU</th>
                    <th width="10%">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peserta as $index => $pesertas)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pesertas->mou_peserta_nip ?? '-' }}</td>
                    <td><strong>{{ $pesertas->mou_peserta_name }}</strong></td>
                    <td class="text-center">
                        {{ $pesertas->mou_peserta_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                    </td>
                    <td>{{ $pesertas->mou_peserta_email ?? '-' }}</td>
                    <td>{{ $pesertas->mou_peserta_no_hp ?? '-' }}</td>
                    <td>{{ $pesertas->mou_peserta_departemen ?? '-' }}</td>
                    <td>
                        @php
                        $lokasi = DB::table('log_lokasi_pasien')
                        ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                        ->where('log_lokasi_pasien.mou_peserta_code', $pesertas->mou_peserta_code)
                        ->value('master_cabang_name');
                        @endphp
                        {{ $lokasi ?? '-' }}
                    </td>
                    <td class="text-center">
                        @php
                        $ttd = DB::table('log_kehadiran_pasien')
                        ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                        ->where('log_kehadiran_pasien_status', 1)
                        ->first();
                        @endphp
                        @if ($ttd && $ttd->log_kehadiran_pasien_sign)
                        <img src="{{ $ttd->log_kehadiran_pasien_sign }}" class="img-ttd"><br>
                        <span style="font-size: 7px;" class="text-muted">{{ date('d/m/Y H:i', strtotime($ttd->log_kehadiran_pasien_time)) }}</span>
                        @else
                        <span class="text-danger">Belum</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
