<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    public function index($code)
    {
        // Ambil data MOU dan Company dengan Query Builder
        $mou = DB::table('company_mou')
            ->leftJoin('master_company', 'company_mou.master_company_code', '=', 'master_company.master_company_code')
            ->select(
                'company_mou.*',
                'master_company.master_company_name'
            )
            ->where('company_mou.company_mou_code', $code)
            ->first();

        // Tampilkan 404 jika data MOU tidak ditemukan
        if (!$mou) {
            abort(404, 'MOU Code tidak ditemukan.');
        }

        return view('public.display', compact('mou', 'code'));
    }

    /**
     * Endpoint API JSON untuk Update Data Real-time
     */
    public function getDisplayData($code)
    {
        // 1. Ambil Antrian yang SEDANG DIPANGGIL / DIPERIKSA
        $currentCall = DB::table('log_antrian_peserta as log')
            ->leftJoin('company_mou_peserta as peserta', 'log.mou_peserta_code', '=', 'peserta.mou_peserta_code')
            ->select(
                'log.nomor_antrian',
                'log.nama_pos_pemeriksaan',
                'log.panggilan_ke',
                'log.status_antrian',
                'peserta.mou_peserta_name',
                'peserta.mou_peserta_nip',
                'peserta.mou_peserta_nik'
            )
            ->where('log.company_mou_code', $code)
            ->whereIn('log.status_antrian', ['Dipanggil', 'Sedang Diperiksa'])
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // 2. Ambil 5 Panggilan Terakhir untuk Tabel Riwayat Side Monitor
        $recentCalls = DB::table('log_antrian_peserta as log')
            ->leftJoin('company_mou_peserta as peserta', 'log.mou_peserta_code', '=', 'peserta.mou_peserta_code')
            ->select(
                'log.nomor_antrian',
                'log.nama_pos_pemeriksaan',
                'log.status_antrian',
                'log.updated_at',
                'peserta.mou_peserta_name'
            )
            ->where('log.company_mou_code', $code)
            ->whereIn('log.status_antrian', ['Dipanggil', 'Sedang Diperiksa', 'Selesai'])
            ->orderBy('log.updated_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Rekap Total Antrian Hari Ini Per Pos Pemeriksaan
        $posStats = DB::table('log_antrian_peserta')
            ->select('nama_pos_pemeriksaan', DB::raw('COUNT(*) as total'))
            ->where('company_mou_code', $code)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->groupBy('nama_pos_pemeriksaan')
            ->get();

        return response()->json([
            'status' => 'success',
            'current' => $currentCall ? [
                'nomor_antrian' => $currentCall->nomor_antrian,
                'nama_peserta'  => $currentCall->mou_peserta_name ?? '-',
                'nip'           => ($currentCall->mou_peserta_nip ?? '-') . ' / ' . ($currentCall->mou_peserta_nik ?? '-'),
                'pos'           => $currentCall->nama_pos_pemeriksaan,
                'panggilan_ke'  => $currentCall->panggilan_ke,
            ] : null,
            'recent' => $recentCalls,
            'stats'  => $posStats
        ]);
    }
}
