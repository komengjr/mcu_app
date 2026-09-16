<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Daftar Hadir Peserta MCU</title>
    <style>
        @page {
            margin: 110px 25px 40px 25px;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        header {
            position: fixed;
            top: -95px;
            left: 0px;
            right: 0px;
            height: 85px;
            border-bottom: 2px solid #db3311;
        }

        #logo {
            float: left;
            width: 150px;
        }

        #logo img {
            height: 50px;
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

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        table.data-table thead {
            display: table-header-group;
        }

        table.data-table tr {
            page-break-inside: avoid;
        }

        table.data-table th {
            background-color: #b90303;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
            padding: 5px 4px;
            border: 1px solid #900202;
            white-space: nowrap;
        }

        table.data-table td {
            padding: 4px;
            border: 1px solid #DDDDDD;
            vertical-align: middle;
        }

        table.data-table tbody tr:nth-child(even) {
            background-color: #F9F9F9;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: #db3311;
            font-weight: bold;
        }

        .text-muted {
            color: #777777;
        }

        .img-ttd {
            height: 28px;
            max-width: 60px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo">
            <img src="data:image/png;base64,{{ $image }}">
        </div>
        <div id="company">
            <h2 class="name">DAFTAR HADIR PESERTA MCU</h2>
            <div class="date">Dicetak Pada: {{ now()->format('d/m/Y H:i') }} WIB</div>
        </div>
    </header>

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
                        <img src="data:image/png;base64,{!! base64_encode(QrCode::style('round')->format('svg')->size(45)->errorCorrection('H')->generate($data->company_mou_code)) !!}">
                    </td>
                </tr>
            </table>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="10%">NIP</th>
                    <th width="20%">Nama Peserta</th>
                    <th width="6%">JK</th>
                    <th width="15%">Email</th>
                    <th width="10%">No HP</th>
                    <th width="12%">Departemen</th>
                    <th width="13%">Lokasi MCU</th>
                    <th width="10%">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peserta as $index => $row)
                <tr>
                    <td class="text-center">{{ $startNo + $index }}</td>
                    <td>{{ $row->mou_peserta_nip ?? '-' }}</td>
                    <td><strong>{{ $row->mou_peserta_name }}</strong></td>
                    <td class="text-center">{{ $row->mou_peserta_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                    <td>{{ $row->mou_peserta_email ?? '-' }}</td>
                    <td>{{ $row->mou_peserta_no_hp ?? '-' }}</td>
                    <td>{{ $row->mou_peserta_departemen ?? '-' }}</td>
                    <td>{{ $row->master_cabang_name ?? '-' }}</td>
                    <td class="text-center">
                        @if ($row->log_kehadiran_pasien_sign)
                        <img src="{{ $row->log_kehadiran_pasien_sign }}" class="img-ttd">
                        <span style="font-size: 7px;" class="text-muted">{{ date('d/m/Y H:i', strtotime($row->log_kehadiran_pasien_time)) }}</span>
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
