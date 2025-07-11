<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Rekap</title>
    <link rel="stylesheet" href="style.css" media="all" />
</head>
<style>
    @font-face {
        font-family: SourceSansPro;
        src: url(SourceSansPro-Regular.ttf);
    }

    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    a {
        color: #0087C3;
        text-decoration: none;
    }

    body {
        position: relative;
        width: 100%;
        height: 100%;
        margin: 0 auto;
        color: #555555;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-family: SourceSansPro;
    }

    header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #0b0909;
    }

    #logo {
        float: left;
        margin-top: 8px;
    }

    #logo img {
        height: 70px;
    }

    #company {
        float: right;
        text-align: right;
        color: black;
    }


    #details {
        padding: 10px;
        border: 2px solid #0b0909;
        border-style: solid solid dashed double;
        margin-bottom: 10px;
    }

    #client {
        padding-left: 6px;
        border-left: 6px solid #db3311;
        float: left;
    }

    #client .to {
        color: #777777;
    }

    h2.name {
        font-size: 1.4em;
        font-weight: normal;
        margin: 0;
    }

    #invoice {
        padding-top: 0;
        float: right;
        text-align: right;
    }

    #invoice span {
        font-size: 1.2rem;
    }

    #invoice h1 {
        color: #db3311;
        font-size: 2.4em;
        /* line-height: 1em; */
        font-weight: normal;
        margin: 0 0 10px 0;
    }

    #invoice .date {
        font-size: 1.1em;
        color: #777777;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        /* margin-bottom: 20px; */
    }

    table th,
    table td {
        padding: 5px;
        /* background: #EEEEEE; */
        text-align: center;
        /* border-bottom: 1px solid #000000; */
    }

    table th {
        white-space: nowrap;
        font-weight: normal;
        background: #b90303;
        color: white;
    }

    table td {
        text-align: left;
    }

    table td h3 {
        color: #db3311;
        font-size: 1.2em;
        font-weight: normal;
        margin: 0 0 0.2em 0;
    }

    table .no {
        color: #FFFFFF;
        font-size: 1.6em;
        text-align: center;
        background: #db3311;
    }

    table .desc {
        text-align: left;
    }

    table .unit {
        background: #DDDDDD;
    }

    table .qty {
        text-align: center;
    }

    table .total {
        background: #eaebe3;
        color: #ff0404;
    }

    table td.unit,
    table td.qty,
    table td.total {
        font-size: 1.2em;
    }

    /* table tbody tr:last-child td {
        border: none;
    } */

    table tfoot td {
        padding: 10px 20px;
        background: #FFFFFF;
        /* border-bottom: none; */
        font-size: 1.2em;
        white-space: nowrap;
        /* border-top: 1px solid #AAAAAA; */
    }

    /* table tfoot tr:first-child td {
        border-top: none;
    } */

    table tfoot tr:last-child td {
        color: #db3311;
        font-size: 1.4em;
        border-top: 1px solid #db3311;

    }

    /* table tfoot tr td:first-child {
        border: none;
    } */

    #thanks {
        font-size: 2em;
        margin-bottom: 50px;
    }

    #notices {
        position: absolute;
        bottom: 0;
        padding-left: 6px;
        border-left: 6px solid #db3311;
    }

    #no_surat {
        margin-top: -20px;
    }

    #notices .notice {
        font-size: 1.2em;
    }

    footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #AAAAAA;
        padding: 8px 0;
        text-align: center;
    }
</style>


<body>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64, {{ $image }}">
        </div>
        <div id="company">
            {{-- <div id="no_surat">123</div>
            <br> --}}
            <h2 class="name">DAFTAR HADIR PESERTA MCU</h2>
            {{-- <div>123</div> --}}
            <div>Form</div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                {{-- <h2 class="name">
                </h2>
                <div class="address"></div> --}}

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

                <span> <img style="padding-top: 1px; left: 10px;"
                        src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->format('svg')->size(50)->errorCorrection('H')->generate(123)) !!}"></span><br>
            </div>
        </div>
        <table border="1" cellspacing="0" cellpadding="0">
            <thead style="font-size: 11px;">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>NIK</th>
                    <th>Nama Peserta</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Departemen</th>
                    <th>Lokasi Kota</th>
                    <th>Lokasi Cabang MCU</th>
                    <
                    <th>Tanda Tangan Kehadiran</th>
                </tr>
            </thead>
            <tbody id="invoiceItems" style="font-size: 10px;">
                @php
                    $no = 1;
                @endphp
                @foreach ($peserta as $pesertas)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pesertas->mou_peserta_nip }}</td>
                        <td>{{ $pesertas->mou_peserta_nik }}</td>
                        <td>{{ $pesertas->mou_peserta_name }}</td>
                        <td>{{ $pesertas->mou_peserta_ttl }}</td>
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
                                {{ $lokasi->master_cabang_city }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($lokasi)
                                {{ $lokasi->master_cabang_name }}
                            @else
                            @endif
                        </td>

                        <td style="text-align: center;">
                             @php
                                $ttd = DB::table('log_kehadiran_pasien')
                                    ->where('mou_peserta_code', $pesertas->mou_peserta_code)
                                    ->where('log_kehadiran_pasien_status',1)
                                    ->first();
                            @endphp
                            @if ($ttd)
                                <img src="<?php echo $ttd->log_kehadiran_pasien_sign ?>" width="50"> <br>
                                {{$ttd->log_kehadiran_pasien_time}}
                            @else
                                <strong style="color: rgb(199, 27, 24)">Belum</strong>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <div id="thanks">Thank you!</div> --}}
        <div id="notices">

            <img style="padding-top: 1px; left: 10px;" src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->format('svg')->size(70)->errorCorrection('H')->generate(123)) !!}">


            <div class="notice">Dokumen Tidak Bisa di Ubah</div>
        </div>
    </main>
</body>

</html>
