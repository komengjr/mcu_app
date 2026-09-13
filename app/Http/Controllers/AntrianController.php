<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    public function index($cabang, $code)
    {
        // 1. Ambil data MOU dan Master Company
        $mou = DB::table('company_mou')
            ->leftJoin('master_company', 'company_mou.master_company_code', '=', 'master_company.master_company_code')
            ->select(
                'company_mou.*',
                'master_company.master_company_name',
                'master_company.master_company_logo'
            )
            ->where('company_mou.company_mou_code', $code)
            ->first();

        if (!$mou) {
            abort(404, 'MOU Code tidak ditemukan.');
        }

        // 2. Ambil token absensi perusahaan berdasarkan company_mou_code
        $tokenData = DB::table('company_mou_peserta_token_absensi')
            ->where('company_mou_code', $code)
            ->orderBy('created_at', 'desc') // Ambil token terbaru
            ->first();

        // Pastikan tokenCode terisi jika datanya ada
        $tokenCode = $tokenData ? $tokenData->company_mou_token_code : null;

        // 3. Kirim variabel tokenCode ke view public.display
        return view('public.display', compact('mou', 'code', 'cabang', 'tokenCode'));
    }

    /**
     * Endpoint API JSON untuk Update Data Real-time
     */
    public function getDisplayData($cabang, $code)
    {
        // 1. Query dasar untuk reuse
        $baseQuery = DB::table('log_antrian_peserta as log')
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
            ->where('log.operator_user_id', $cabang)
            ->whereIn('log.status_antrian', ['Dipanggil', 'Sedang Diperiksa']);

        // 2. Ambil panggilan aktif Registrasi / Pendaftaran 1
        $pos1 = (clone $baseQuery)
            ->where('log.nama_pos_pemeriksaan', 'Registrasi / Pendaftaran 1')
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // 3. Ambil panggilan aktif Registrasi / Pendaftaran 2
        $pos2 = (clone $baseQuery)
            ->where('log.nama_pos_pemeriksaan', 'Registrasi / Pendaftaran 2')
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // 4. Ambil panggilan paling terbaru secara keseluruhan (Untuk trigger suara TTS di frontend)
        $current = DB::table('log_antrian_peserta as log')
            ->select('log.nomor_antrian', 'log.nama_pos_pemeriksaan', 'log.panggilan_ke')
            ->where('log.company_mou_code', $code)
            ->where('log.operator_user_id', $cabang)
            ->where('log.status_antrian', 'Dipanggil')
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // 5. Ambil 5 Panggilan Terakhir
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
            ->where('log.operator_user_id', $cabang)
            ->whereIn('log.status_antrian', ['Dipanggil', 'Sedang Diperiksa', 'Selesai'])
            ->orderBy('log.updated_at', 'desc')
            ->limit(5)
            ->get();

        // 6. Ambil Antrian MENUNGGU
        $waitingCalls = DB::table('log_antrian_peserta as log')
            ->leftJoin('company_mou_peserta as peserta', 'log.mou_peserta_code', '=', 'peserta.mou_peserta_code')
            ->select(
                'log.nomor_antrian',
                'log.nama_pos_pemeriksaan',
                'peserta.mou_peserta_name',
                'peserta.mou_peserta_departemen'
            )
            ->where('log.company_mou_code', $code)
            ->where('log.operator_user_id', $cabang)
            ->where('log.status_antrian', 'Menunggu')
            ->orderBy('log.created_at', 'asc')
            ->limit(10)
            ->get();

        // 7. Rekap Total Antrian Hari Ini Per Pos Pemeriksaan
        $posStats = DB::table('log_antrian_peserta')
            ->select('nama_pos_pemeriksaan', DB::raw('COUNT(*) as total'))
            ->where('company_mou_code', $code)
            ->where('operator_user_id', $cabang)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->groupBy('nama_pos_pemeriksaan')
            ->get();

        return response()->json([
            'status'  => 'success',
            'pos1'    => $pos1 ? [
                'nomor_antrian' => $pos1->nomor_antrian,
                'nama_peserta'  => $pos1->mou_peserta_name ?? '-',
                'nip'           => ($pos1->mou_peserta_nip ?? '-') . ' / ' . ($pos1->mou_peserta_nik ?? '-'),
                'pos'           => $pos1->nama_pos_pemeriksaan,
                'panggilan_ke'  => $pos1->panggilan_ke,
            ] : null,
            'pos2'    => $pos2 ? [
                'nomor_antrian' => $pos2->nomor_antrian,
                'nama_peserta'  => $pos2->mou_peserta_name ?? '-',
                'nip'           => ($pos2->mou_peserta_nip ?? '-') . ' / ' . ($pos2->mou_peserta_nik ?? '-'),
                'pos'           => $pos2->nama_pos_pemeriksaan,
                'panggilan_ke'  => $pos2->panggilan_ke,
            ] : null,
            'current' => $current ? [
                'nomor_antrian' => $current->nomor_antrian,
                'pos'           => $current->nama_pos_pemeriksaan,
                'panggilan_ke'  => $current->panggilan_ke,
            ] : null,
            'recent'  => $recentCalls,
            'waiting' => $waitingCalls,
            'stats'   => $posStats
        ]);
    }
}
