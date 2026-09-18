<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeriksaanFisikController extends Controller
{
    public function getMou(Request $request)
    {
        $companyCode = $request->get('company_code');

        if (!$companyCode) {
            return response()->json([]);
        }

        $mou = DB::table('company_mou')
            ->where('master_company_code', $companyCode)
            ->select('company_mou_code', 'company_mou_name')
            ->get();

        return response()->json($mou);
    }

    /**
     * Ambil List Peserta Berdasarkan MoU Code (JSON untuk Render Tabel Manual Frontend)
     */
    public function getParticipants(Request $request)
    {
        $mouCode = $request->get('mou_code');

        if (!$mouCode) {
            return response()->json([]);
        }

        $participants = DB::table('company_mou_peserta as p')
            ->leftJoin('mcu_pemeriksaan_fisik as pf', 'p.mou_peserta_code', '=', 'pf.mou_peserta_code')
            ->select([
                'p.mou_peserta_code',
                'p.mou_peserta_name',
                'p.mou_peserta_nip',
                'p.mou_peserta_nik',
                'p.mou_peserta_departemen',
                'pf.id_pemeriksaan_fisik',
                'pf.dokter_pemeriksa',
                'pf.tgl_pemeriksaan'
            ])
            ->where('p.company_mou_code', $mouCode)
            ->get();

        return response()->json($participants);
    }

    /**
     * Ambil Summary Stat (Total, Sudah Periksa, Belum Periksa)
     */
    public function getSummaryStats(Request $request)
    {
        $mouCode = $request->get('mou_code');

        if (!$mouCode) {
            return response()->json(['total' => 0, 'sudah' => 0, 'belum' => 0]);
        }

        $total = DB::table('company_mou_peserta')
            ->where('company_mou_code', $mouCode)
            ->count();

        $sudah = DB::table('company_mou_peserta as p')
            ->join('mcu_pemeriksaan_fisik as pf', 'p.mou_peserta_code', '=', 'pf.mou_peserta_code')
            ->where('p.company_mou_code', $mouCode)
            ->count();

        $belum = $total - $sudah;

        return response()->json([
            'total' => $total,
            'sudah' => $sudah,
            'belum' => $belum < 0 ? 0 : $belum,
        ]);
    }

    /**
     * Ambil Detail Peserta, Header Pemeriksaan, Master Parameter, & Hasil Simpanan
     */
    public function getDetail(Request $request)
    {
        $pesertaCode = $request->get('peserta_code');

        // 1. Data Peserta
        $peserta = DB::table('company_mou_peserta')
            ->where('mou_peserta_code', $pesertaCode)
            ->first();

        // 2. Data Header Pemeriksaan Fisik (jika sudah pernah diisi)
        $header = DB::table('mcu_pemeriksaan_fisik')
            ->where('mou_peserta_code', $pesertaCode)
            ->first();

        // 3. Data Master Parameter Aktif
        $parameters = DB::table('mcu_pemeriksaan_parameters')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id_parameter', 'asc')
            ->get();

        // 4. Ambil Hasil Simpanan Parameter & Keterangan
        $savedResults = [];
        $savedKeterangan = [];

        if ($header) {
            $details = DB::table('mcu_pemeriksaan_fisik_details')
                ->where('id_pemeriksaan_fisik', $header->id_pemeriksaan_fisik)
                ->get();

            foreach ($details as $detail) {
                $savedResults[$detail->id_parameter] = $detail->nilai_value;
                $savedKeterangan[$detail->id_parameter] = $detail->keterangan;
            }
        }

        return response()->json([
            'peserta' => $peserta,
            'header' => $header,
            'parameters' => $parameters,
            'saved_results' => $savedResults,
            'saved_keterangan' => $savedKeterangan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mou_peserta_code' => 'required',
            'no_reg' => 'required',
            'dokter_pemeriksa' => 'required',
            'tgl_pemeriksaan' => 'required|date',
        ]);

        try {
            DB::beginTransaction();
            $now = now();

            // 1. Cek atau Buat Header Pemeriksaan
            $header = DB::table('mcu_pemeriksaan_fisik')
                ->where('mou_peserta_code', $request->mou_peserta_code)
                ->first();

            if ($header) {
                DB::table('mcu_pemeriksaan_fisik')
                    ->where('id_pemeriksaan_fisik', $header->id_pemeriksaan_fisik)
                    ->update([
                        'no_reg' => $request->no_reg,
                        'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                        'dokter_pemeriksa' => $request->dokter_pemeriksa,
                        'kesimpulan' => $request->kesimpulan,
                        'updated_at' => $now,
                    ]);

                $idPemeriksaanFisik = $header->id_pemeriksaan_fisik;
            } else {
                $idPemeriksaanFisik = DB::table('mcu_pemeriksaan_fisik')->insertGetId([
                    'mou_peserta_code' => $request->mou_peserta_code,
                    'no_reg' => $request->no_reg,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                    'dokter_pemeriksa' => $request->dokter_pemeriksa,
                    'kesimpulan' => $request->kesimpulan,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // 2. Clear Detail Lama (Overwrite)
            DB::table('mcu_pemeriksaan_fisik_details')
                ->where('id_pemeriksaan_fisik', $idPemeriksaanFisik)
                ->delete();

            // 3. Batch Insert Parameter Dinamis beserta Keterangan Free Text
            if ($request->has('results') && is_array($request->results)) {
                $detailsToInsert = [];
                $keteranganList = $request->input('keterangan', []);

                foreach ($request->results as $idParameter => $value) {
                    if ($value !== null && $value !== '') {
                        // Ambil teks keterangan jika tersedia untuk id_parameter ini
                        $ketValue = isset($keteranganList[$idParameter]) ? trim($keteranganList[$idParameter]) : null;

                        $detailsToInsert[] = [
                            'id_pemeriksaan_fisik' => $idPemeriksaanFisik,
                            'id_parameter' => $idParameter,
                            'nilai_value' => is_array($value) ? json_encode($value) : (string)$value,
                            'keterangan' => $ketValue !== '' ? $ketValue : null,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }

                if (!empty($detailsToInsert)) {
                    DB::table('mcu_pemeriksaan_fisik_details')->insert($detailsToInsert);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data pemeriksaan fisik berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
