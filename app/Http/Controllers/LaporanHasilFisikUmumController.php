<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanHasilFisikUmumController extends Controller
{
    public function getMou(Request $request)
    {
        $mou = DB::table('company_mou')
            ->where('master_company_code', $request->company_code)
            ->select('company_mou_code', 'company_mou_name')
            ->get();

        return response()->json($mou);
    }

    public function getPeserta(Request $request)
    {
        $peserta = DB::table('company_mou_peserta')
            ->where('company_mou_code', $request->mou_code)
            ->select('mou_peserta_code', 'mou_peserta_name', 'mou_peserta_nip', 'mou_peserta_nik')
            ->get();

        return response()->json($peserta);
    }

    public function getData(Request $request)
    {
        // Validasi parameter mou_code
        if (!$request->filled('mou_code')) {
            return response()->json(['data' => []]);
        }

        try {
            // Query mengambil seluruh peserta berdasarkan MoU dan me-JOIN ke tabel pemeriksaan fisik
            $query = DB::table('company_mou_peserta')
                ->leftJoin('mcu_pemeriksaan_fisik', 'company_mou_peserta.mou_peserta_code', '=', 'mcu_pemeriksaan_fisik.mou_peserta_code')
                ->where('company_mou_peserta.company_mou_code', $request->mou_code)
                ->select([
                    'company_mou_peserta.mou_peserta_code',
                    'company_mou_peserta.mou_peserta_nik',
                    'company_mou_peserta.mou_peserta_nip',
                    'company_mou_peserta.mou_peserta_name',
                    'company_mou_peserta.mou_peserta_departemen',
                    'mcu_pemeriksaan_fisik.id_pemeriksaan_fisik',
                    'mcu_pemeriksaan_fisik.no_reg',
                    'mcu_pemeriksaan_fisik.tgl_pemeriksaan',
                    'mcu_pemeriksaan_fisik.dokter_pemeriksa',
                    'mcu_pemeriksaan_fisik.kesimpulan',
                ]);

            // Filter Tanggal jika diisi
            if ($request->filled('tgl_pemeriksaan')) {
                $query->whereDate('mcu_pemeriksaan_fisik.tgl_pemeriksaan', $request->tgl_pemeriksaan);
            }

            $data = $query->orderBy('company_mou_peserta.mou_peserta_name', 'asc')->get();

            $formattedData = $data->map(function ($item, $index) {
                // Status Pemeriksaan
                if ($item->id_pemeriksaan_fisik) {
                    $statusBadge = '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Sudah Periksa</span>';
                    $tglPeriksa = $item->tgl_pemeriksaan ? date('d/m/Y', strtotime($item->tgl_pemeriksaan)) : '-';
                    $dokter = $item->dokter_pemeriksa ?? '-';
                } else {
                    $statusBadge = '<span class="badge bg-secondary"><i class="fas fa-clock me-1"></i>Belum Periksa</span>';
                    $tglPeriksa = '-';
                    $dokter = '-';
                }

                $urlPrintPerorangan = route('laporan.fisik_umum.print_perorangan_pdf', $item->mou_peserta_code);

                // Tombol Aksi
                $actionBtn = '<button class="btn btn-sm btn-info btn-view-detail" data-peserta-code="' . $item->mou_peserta_code . '">
                                <i class="fas fa-eye me-1"></i> Detail
                              </button>';

                if ($item->id_pemeriksaan_fisik) {
                    $actionBtn .= ' <a href="' . $urlPrintPerorangan . '" target="_blank" class="btn btn-sm btn-danger ms-1">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                    </a>';
                }

                return [
                    'DT_RowIndex' => $index + 1,
                    'nip_nik' => ($item->mou_peserta_nip ?? '-') . ' / ' . ($item->mou_peserta_nik ?? '-'),
                    'nama_pasien' => $item->mou_peserta_name,
                    'tgl_pemeriksaan' => $tglPeriksa,
                    'pemeriksa' => $dokter,
                    'kondisi_umum' => $statusBadge,
                    'action' => $actionBtn
                ];
            });

            return response()->json(['data' => $formattedData]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSummaryStats(Request $request)
    {
        if (!$request->filled('mou_code')) {
            return response()->json(['total' => 0, 'total_peserta' => 0]);
        }

        // Total Peserta Terdaftar di MoU Ini
        $totalPeserta = DB::table('company_mou_peserta')
            ->where('company_mou_code', $request->mou_code)
            ->count();

        // Total Peserta yang Sudah Diperiksa Fisik
        $totalSudahPeriksa = DB::table('mcu_pemeriksaan_fisik')
            ->join('company_mou_peserta', 'mcu_pemeriksaan_fisik.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $request->mou_code)
            ->count();

        return response()->json([
            'total' => $totalSudahPeriksa,
            'total_peserta' => $totalPeserta
        ]);
    }
    public function printPeroranganPdf($mou_peserta_code)
    {
        // 1. Ambil Data Peserta berdasarkan Mou Peserta Code
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou_peserta.company_mou_code', '=', 'company_mou.company_mou_code')
            ->join('master_company', 'company_mou.master_company_code', '=', 'master_company.master_company_code')
            ->where('company_mou_peserta.mou_peserta_code', $mou_peserta_code)
            ->select([
                'company_mou_peserta.*',
                'company_mou.company_mou_name',
                'master_company.master_company_name'
            ])
            ->first();

        if (!$peserta) {
            abort(404, 'Data Peserta tidak ditemukan.');
        }

        // 2. Ambil Header Pemeriksaan Fisik Peserta
        $pemeriksaan = DB::table('mcu_pemeriksaan_fisik')
            ->where('mou_peserta_code', $mou_peserta_code)
            ->first();

        $paramsData = [];

        if ($pemeriksaan) {
            // 3. Ambil Detail Parameter & Mapping berdasarkan key_parameter
            $rawParams = DB::table('mcu_pemeriksaan_parameters as p')
                ->leftJoin('mcu_pemeriksaan_fisik_details as d', function ($join) use ($pemeriksaan) {
                    $join->on('p.id_parameter', '=', 'd.id_parameter')
                        ->where('d.id_pemeriksaan_fisik', '=', $pemeriksaan->id_pemeriksaan_fisik);
                })
                ->where('p.is_active', true)
                ->select([
                    'p.key_parameter',
                    'p.input_type',
                    'd.nilai_value',
                    'd.keterangan'
                ])
                ->get();

            // Key-Value Mapping agar sesuai dengan panggilannya di Blade ($paramsData['key_parameter'])
            foreach ($rawParams as $item) {
                if ($item->key_parameter) {
                    $paramsData[$item->key_parameter] = [
                        'value'      => $item->nilai_value,
                        'keterangan' => $item->keterangan,
                        'input_type' => $item->input_type,
                    ];
                }
            }
        }
        // return response()->json($paramsData);
        // dd($paramsData);
        // 4. Render ke Blade PDF
        $pdf = Pdf::loadView('application.laporan.report.pdf_fisik_umum_perorangan', compact('peserta', 'pemeriksaan', 'paramsData'))
            ->setPaper('a4', 'portrait')->setOptions([
                'defaultFont' => 'Helvetica',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true
            ]);

        return $pdf->stream('Hasil_Fisik_Umum_' . str_replace(' ', '_', $peserta->mou_peserta_name) . '.pdf');
    }
}
