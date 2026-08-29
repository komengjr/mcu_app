<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil MCU - {{ $peserta->mou_peserta_name }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 14pt;
        }

        .header p {
            margin: 2px 0 0 0;
            font-size: 10pt;
            color: #666;
        }

        .table-biodata {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table-biodata td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .table-hasil {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-hasil th,
        .table-hasil td {
            border: 1px solid #777;
            padding: 6px 8px;
            font-size: 10pt;
        }

        .table-hasil th {
            background-color: #f2f2f2;
            text-align: left;
            text-transform: uppercase;
            font-size: 9pt;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
        }
    </style>
</head>

<body>

    <!-- Header Dokumen -->
    <div class="header">
        <h2>HASIL PENGISIAN FORM MEDICAL CHECK UP</h2>
        <p>{{ $form->form_name }}</p>
    </div>

    <!-- Informasi Peserta -->
    <table class="table-biodata">
        <tr>
            <td width="18%"><strong>Nama Peserta</strong></td>
            <td width="2%">:</td>
            <td width="30%">{{ $peserta->mou_peserta_name }}</td>
            <td width="18%"><strong>Departemen</strong></td>
            <td width="2%">:</td>
            <td width="30%">{{ $peserta->mou_peserta_departemen ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIK</strong></td>
            <td>:</td>
            <td>{{ $peserta->mou_peserta_nik ?? '-' }}</td>
            <td><strong>Tgl Pengisian</strong></td>
            <td>:</td>
            <td>{{ $answer ? date('d/m/Y H:i', strtotime($answer->updated_at)) : '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIP</strong></td>
            <td>:</td>
            <td>{{ $peserta->mou_peserta_nip ?? '-' }}</td>
            <td><strong>Jenis Kelamin</strong></td>
            <td>:</td>
            <td>{{ $peserta->mou_peserta_jk ?? '-' }}</td>
        </tr>
    </table>

    <!-- Tabel Hasil Jawaban Form -->
    <table class="table-hasil">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="55%">Item Pemeriksaan / Pertanyaan</th>
                <th width="25%">Hasil / Jawaban</th>
                <th width="15%" class="text-center">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($formItems as $index => $item)
            @php
            $val = $answersData[$item->id_mcu_form_item] ?? '-';
            if (is_array($val)) {
            $val = implode(', ', $val);
            }
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->item_label }}</td>
                <td><strong>{{ $val }}</strong></td>
                <td class="text-center">{{ $item->unit ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada item pemeriksaan pada form ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan / Verification Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        <br><br><br>
        <p><strong>( Petugas MCU )</strong></p>
    </div>

</body>

</html>
