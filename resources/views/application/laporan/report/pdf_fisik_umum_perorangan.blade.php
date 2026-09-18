<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>FORM PEMERIKSAAN FISIK - {{ $peserta->mou_peserta_name ?? 'Pasien' }}</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 4mm;
            /* Margin diperkecil sedikit agar aman di 1 halaman */
        }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 9px;
            /* Font dasar sesuai batas minimal */
            color: #1e293b;
            line-height: 1.42;
            /* Jarak antar baris dibuat padat agar tidak ke bawah */
        }

        /* Header Styling - Nuansa Merah */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }

        .header-title {
            font-size: 14px;
            /* Maksimum font size / judul */
            font-weight: bold;
            color: #991b1b;
            text-transform: uppercase;
        }

        .brand-logo {
            font-size: 13px;
            font-weight: bold;
            color: #dc2626;
            text-align: right;
        }

        /* Bio Box Styling */
        .bio-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            margin-bottom: 2px;
        }

        .bio-table td {
            padding: 1.5px 3px;
            vertical-align: middle;
            font-size: 9px;
            border: 0.5px solid #fecaca;
        }

        /* Grid 2 Kolom Utama */
        .grid-2col {
            width: 100%;
            border-collapse: collapse;
        }

        .grid-2col>tbody>tr>td {
            width: 50%;
            vertical-align: top;
            padding: 0 1.5px;
        }

        .grid-2col>tbody>tr>td:first-child {
            padding-left: 0;
            padding-right: 1.5px;
        }

        .grid-2col>tbody>tr>td:last-child {
            padding-left: 1.5px;
            padding-right: 0;
        }

        /* Section Header Styling - Aksen Merah */
        .section-header {
            background-color: #fee2e2;
            color: #991b1b;
            font-weight: bold;
            font-size: 9.5px;
            padding: 1.5px 3px;
            border-left: 3px solid #dc2626;
            border-top: 1px solid #fca5a5;
            border-right: 1px solid #fca5a5;
            border-bottom: 1px solid #fca5a5;
            text-transform: uppercase;
            margin-top: 2px;
            margin-bottom: 1px;
        }

        /* Table Data / Checkbox Styling */
        table.form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1px;
        }

        table.form-table td {
            border: 1px solid #cbd5e1;
            padding: 1px 3px;
            vertical-align: middle;
            font-size: 9px;
            /* Minimal font size 9px */
        }

        table.form-table tr td:first-child {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 500;
        }

        table.form-table tr td:last-child {
            background-color: #ffffff;
            color: #0f172a;
            font-weight: bold;
        }

        .checkbox-box {
            display: inline-block;
            width: 7px;
            height: 7px;
            border: 1px solid #0f172a;
            text-align: center;
            line-height: 7px;
            font-size: 7px;
            font-weight: bold;
            margin-right: 2px;
            background-color: #fff;
        }

        .ket-text {
            font-style: italic;
            color: #b91c1c;
            /* Keterangan tetap merah kontras */
            font-size: 8.5px;
            font-weight: normal;
        }

        .kesimpulan-box {
            border: 1px solid #fca5a5;
            background-color: #fef2f2;
            min-height: 18px;
            padding: 2px 4px;
            font-size: 9px;
            margin-bottom: 2px;
        }

        /* Tanda Tangan Fixed Bottom dengan Kotak Resmi */
        .ttd-section {
            position: fixed;
            bottom: 10px;
            right: 4mm;
            width: 330px;
            border: 1px solid #fca5a5;
            background-color: #fef2f2;
            padding: 4px;
            text-align: center;
            font-size: 9px;
        }

        .ttd-space {
            height: 35px;
            /* Ruang kosong untuk tanda tangan fisik / cap */
        }

        .ttd-name {
            border-top: 1px solid #991b1b;
            padding-top: 2px;
            margin-top: 2px;
        }
    </style>
</head>

<body>

    @php
    function getParamDetail($details, $keyParam) {
    if (is_string($details)) {
    $details = json_decode($details, true);
    }
    if (empty($details) || !isset($details[$keyParam])) {
    return ['value' => '-', 'keterangan' => null];
    }
    $item = $details[$keyParam];
    if (is_array($item)) {
    $val = $item['value'] ?? null;
    $ket = $item['keterangan'] ?? null;
    } elseif (is_object($item)) {
    $val = $item->value ?? null;
    $ket = $item->keterangan ?? null;
    } else {
    $val = $item;
    $ket = null;
    }
    return [
    'value' => ($val !== null && $val !== '' && $val !== 'null') ? $val : '-',
    'keterangan' => ($ket !== null && $ket !== '' && $ket !== 'null') ? $ket : null
    ];
    }

    function renderRow($details, $keyParam, $label, $suffix = '') {
    $data = getParamDetail($details, $keyParam);

    $html = '<tr>';
        $html .= '<td width="42%">' . $label . '</td>';
        $html .= '<td>' . $data['value'];
            if ($suffix !== '' && $data['value'] !== '-') {
            $html .= ' ' . $suffix;
            }
            if ($data['keterangan']) {
            $html .= ' <span class="ket-text">(Ket: ' . $data['keterangan'] . ')</span>';
            }
            $html .= '</td>
    </tr>';
    return $html;
    }
    @endphp

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="60%" class="header-title">Form Pemeriksaan Fisik (Medical Check Up)</td>
            <!-- <td width="40%" class="brand-logo">PRAMITA Lab</td> -->
        </tr>
    </table>

    <!-- Data Pasien -->
    <table class="bio-table">
        <tr>
            <td width="15%"><strong>No. Reg</strong></td>
            <td width="35%">{{ $pemeriksaan->no_reg ?? '-' }}</td>
            <td width="15%"><strong>Job Title/Dept.</strong></td>
            <td width="35%">{{ $peserta->mou_peserta_departemen ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pasien</strong></td>
            <td><strong>{{ $peserta->mou_peserta_name ?? '-' }}</strong></td>
            <td><strong>Divisi</strong></td>
            <td>{{ $peserta->mou_peserta_divisi ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIK / NIP</strong></td>
            <td>{{ $peserta->mou_peserta_nip ?? ($peserta->mou_peserta_nik ?? '-') }}</td>
            <td><strong>Lokasi</strong></td>
            <td>{{ $peserta->master_company_name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Umur</strong></td>
            <td>{{ $peserta->mou_peserta_umur ?? '-' }} Thn</td>
            <td><strong>Tgl Pemeriksaan</strong></td>
            <td>{{ isset($pemeriksaan->tgl_pemeriksaan) ? date('d/m/Y', strtotime($pemeriksaan->tgl_pemeriksaan)) : '-' }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Kelamin</strong></td>
            <td><span class="checkbox-box">{{ (($peserta->mou_peserta_jk ?? '') == 'L') ? 'X' : '' }}</span> L &nbsp;&nbsp;&nbsp; <span class="checkbox-box">{{ (($peserta->mou_peserta_jk ?? '') == 'P') ? 'X' : '' }}</span> P</td>
            <td><strong>Dokter Pemeriksa</strong></td>
            <td>{{ $pemeriksaan->dokter_pemeriksa ?? '-' }}</td>
        </tr>
    </table>

    <!-- Layout 2 Kolom Penuh -->
    <br>
    <table class="grid-2col">
        <tr>
            <!-- ================= KOLOM KIRI ================= -->
            <td>
                <div class="section-header">1. Tanda Vital</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'tv_denyut_nadi', 'Denyut Nadi', 'x/menit') !!}
                    {!! renderRow($paramsData, 'tv_irama_nadi', 'Irama Nadi') !!}
                    {!! renderRow($paramsData, 'tv_laju_pernafasan', 'Laju Pernafasan', 'x/menit') !!}
                    {!! renderRow($paramsData, 'tv_pola_nafas', 'Pola Nafas') !!}
                    {!! renderRow($paramsData, 'tv_tekanan_darah', 'Tekanan Darah', 'mmHg') !!}
                    {!! renderRow($paramsData, 'tv_suhu', 'Suhu Tubuh', '°C') !!}
                </table>

                <div class="section-header">2. Status Gizi</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'sg_berat_badan', 'Berat Badan', 'kg') !!}
                    {!! renderRow($paramsData, 'sg_tinggi_badan', 'Tinggi Badan', 'cm') !!}
                    {!! renderRow($paramsData, 'sg_lingkar_perut', 'Lingkar Perut', 'cm') !!}
                    {!! renderRow($paramsData, 'sg_bmi', 'BMI (Indeks Massa Tubuh)') !!}
                </table>

                <div class="section-header">3. Keadaan Umum</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'ku_kesadaran', 'Kesadaran') !!}
                    {!! renderRow($paramsData, 'ku_sikap_tingkah_laku', 'Sikap & Tingkah Laku') !!}
                    {!! renderRow($paramsData, 'ku_kontak_psikis', 'Kontak Psikis') !!}
                </table>

                <div class="section-header">4. Kepala & Wajah</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'kw_kondisi_kepala', 'Kepala / Wajah') !!}
                </table>

                <div class="section-header">5. Mata</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'mt_kondisi_mata', 'Kondisi Mata') !!}
                    {!! renderRow($paramsData, 'mt_persepsi_warna', 'Persepsi Warna') !!}
                    {!! renderRow($paramsData, 'mt_visus_tanpa_kacamata_od', 'Visus Tanpa Kacamata OD') !!}
                    {!! renderRow($paramsData, 'mt_visus_tanpa_kacamata_os', 'Visus Tanpa Kacamata OS') !!}
                </table>

                <div class="section-header">6. Telinga</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'tl_kondisi_telinga', 'Kondisi Telinga') !!}
                </table>

                <div class="section-header">7. Hidung</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'hd_kondisi_hidung', 'Kondisi Hidung') !!}
                </table>

                <div class="section-header">8. Mulut, Gigi & Tenggorokan</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'gm_mukosa_rongga_mulut', 'Mukosa Mulut') !!}
                    {!! renderRow($paramsData, 'gm_tenggorokan', 'Tenggorokan') !!}
                    {!! renderRow($paramsData, 'gm_status_gigi', 'Status Gigi') !!}
                </table>
                <div class="section-header">9. Leher</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'lh_kondisi_leher', 'Kondisi Leher') !!}
                </table>

                <div class="section-header">10. Thorax / Dada</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'tx_kondisi_thorax', 'Thorax / Dada') !!}
                </table>

                <div class="section-header">11. Paru-paru</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'pr_kondisi_paru', 'Paru-paru') !!}
                </table>
            </td>

            <!-- ================= KOLOM KANAN ================= -->
            <td>


                <div class="section-header">12. Jantung</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'jt_jvp', 'JVP Jantung') !!}
                    {!! renderRow($paramsData, 'jt_apex', 'Apex Jantung') !!}
                    {!! renderRow($paramsData, 'jt_suara_jantung', 'Suara Jantung') !!}
                    {!! renderRow($paramsData, 'jt_bising_murmur', 'Bising / Murmur') !!}
                </table>

                <div class="section-header">13. Perut / Abdomen</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'ab_kondisi_abdomen', 'Abdomen') !!}
                    {!! renderRow($paramsData, 'ab_nyeri_tekan', 'Nyeri Tekan') !!}
                    {!! renderRow($paramsData, 'ab_nyeri_ketok_ginjal', 'Ketok Ginjal') !!}
                    {!! renderRow($paramsData, 'ab_shifting_dullness', 'Shifting Dullness') !!}
                    {!! renderRow($paramsData, 'ab_bising_usus', 'Bising Usus') !!}
                    {!! renderRow($paramsData, 'ab_hati', 'Hati (Liver)') !!}
                    {!! renderRow($paramsData, 'ab_limpa', 'Limpa (Splen)') !!}
                    {!! renderRow($paramsData, 'ab_hernia', 'Hernia') !!}
                    {!! renderRow($paramsData, 'ab_hemorroid', 'Hemorroid') !!}
                </table>

                <div class="section-header">14. Genitourinaria & Anggota Gerak</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'gn_kondisi_genitourinaria', 'Genitourinaria') !!}
                    {!! renderRow($paramsData, 'ag_ekstrimitas_atas', 'Ekstremitas Atas') !!}
                    {!! renderRow($paramsData, 'ag_ekstrimitas_bawah', 'Ekstremitas Bawah') !!}
                    {!! renderRow($paramsData, 'ag_tonus_otot', 'Tonus Otot') !!}
                </table>

                <div class="section-header">15. Integumen & Persarafan</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'si_kulit', 'Kulit, Kuku, Rambut') !!}
                    {!! renderRow($paramsData, 'sp_refleks_fisiologis', 'Refleks Fisiologis') !!}
                    {!! renderRow($paramsData, 'sp_refleks_pathologis', 'Refleks Pathologis') !!}
                    {!! renderRow($paramsData, 'sp_keseimbangan_koordinasi', 'Keseimbangan / Koordinasi') !!}
                </table>

                <div class="section-header">16. Screening Test (LBP & CTS)</div>
                <table class="form-table">
                    {!! renderRow($paramsData, 'lbp_laseque_test', 'Laseque Test') !!}
                    {!! renderRow($paramsData, 'lbp_bragard_test', 'Bragard Test') !!}
                    {!! renderRow($paramsData, 'lbp_patrick_test', 'Patrick Test') !!}
                    {!! renderRow($paramsData, 'lbp_contra_patrick_test', 'Contra Patrick Test') !!}
                    {!! renderRow($paramsData, 'lbp_cts_phalen_test', 'Phalen Test') !!}
                    {!! renderRow($paramsData, 'lbp_cts_reverse_phalen', 'Reverse Phalen') !!}
                    {!! renderRow($paramsData, 'lbp_cts_tinel_test', 'Tinel Test') !!}
                </table>

                <div class="section-header">17. Kesimpulan Pemeriksaan</div>
                <div class="kesimpulan-box">
                    {{ $pemeriksaan->kesimpulan ?? 'Dalam batas normal.' }}
                </div>

            </td>
        </tr>
    </table>

    <div class="ttd-section">
        Dokter Pemeriksa,
        <div class="ttd-space"></div>
        <div class="ttd-name">
            <strong>{{ $pemeriksaan->dokter_pemeriksa ?? '............................................' }}</strong>
        </div>
    </div>
</body>

</html>
