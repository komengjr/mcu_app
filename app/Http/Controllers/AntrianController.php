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
        // 1. Query dasar antrian aktif HARI INI
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
            ->whereDate('log.created_at', DB::raw('CURDATE()'))
            ->whereIn('log.status_antrian', ['Dipanggil', 'Sedang Diperiksa']);

        // Helper untuk formatting item pos agar aman dibaca JS (lengkap dengan semua alias)
        $formatPos = function ($item) {
            if (!$item) return null;

            $nipDisplay = trim(($item->mou_peserta_nip ?? '-') . ' / ' . ($item->mou_peserta_nik ?? '-'), ' /');

            return [
                'nomor_antrian'        => $item->nomor_antrian,
                'nama_peserta'         => $item->mou_peserta_name ?? '-',
                'mou_peserta_name'     => $item->mou_peserta_name ?? '-',
                'nip'                  => $nipDisplay,
                'mou_peserta_nip'      => $item->mou_peserta_nip ?? '-',
                'mou_peserta_nik'      => $item->mou_peserta_nik ?? '-',
                'pos'                  => $item->nama_pos_pemeriksaan,
                'nama_pos_pemeriksaan' => $item->nama_pos_pemeriksaan,
                'panggilan_ke'         => $item->panggilan_ke,
            ];
        };

        // 2. Ambil panggilan aktif Pos 1 (Registrasi / Pendaftaran 1)
        $pos1Raw = (clone $baseQuery)
            ->where(function ($q) {
                $q->where('log.nama_pos_pemeriksaan', 'LIKE', '%Pendaftaran 1%')
                    ->orWhere('log.nama_pos_pemeriksaan', 'LIKE', '%Registrasi 1%');
            })
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // 3. Ambil panggilan aktif Pos 2 (Registrasi / Pendaftaran 2)
        $pos2Raw = (clone $baseQuery)
            ->where(function ($q) {
                $q->where('log.nama_pos_pemeriksaan', 'LIKE', '%Pendaftaran 2%')
                    ->orWhere('log.nama_pos_pemeriksaan', 'LIKE', '%Registrasi 2%');
            })
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // Fallback: Jika penamaan di DB tidak pakai angka 1/2, ambil 2 antrian aktif teratas secara otomatis
        if (!$pos1Raw && !$pos2Raw) {
            $activeList = (clone $baseQuery)->orderBy('log.updated_at', 'desc')->get();
            $pos1Raw = $activeList->get(0);
            $pos2Raw = $activeList->get(1);
        }

        // 4. Ambil panggilan paling terbaru secara keseluruhan (Trigger suara TTS)
        $currentRaw = DB::table('log_antrian_peserta as log')
            ->leftJoin('company_mou_peserta as peserta', 'log.mou_peserta_code', '=', 'peserta.mou_peserta_code')
            ->select('log.nomor_antrian', 'log.nama_pos_pemeriksaan', 'log.panggilan_ke', 'peserta.mou_peserta_name')
            ->where('log.company_mou_code', $code)
            ->where('log.operator_user_id', $cabang)
            ->whereDate('log.created_at', DB::raw('CURDATE()'))
            ->where('log.status_antrian', 'Dipanggil')
            ->orderBy('log.updated_at', 'desc')
            ->first();

        // 5. Ambil 5 Panggilan Terakhir Hari Ini
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
            ->whereDate('log.created_at', DB::raw('CURDATE()'))
            ->whereIn('log.status_antrian', ['Dipanggil', 'Sedang Diperiksa', 'Selesai'])
            ->orderBy('log.updated_at', 'desc')
            ->limit(5)
            ->get();

        // 6. Ambil Antrian MENUNGGU Hari Ini
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
            ->whereDate('log.created_at', DB::raw('CURDATE()'))
            ->where('log.status_antrian', 'Menunggu')
            ->orderBy('log.created_at', 'asc')
            ->limit(10)
            ->get();

        // 7. Rekap Total Antrian Hari Ini Per Pos
        $posStats = DB::table('log_antrian_peserta')
            ->select('nama_pos_pemeriksaan', DB::raw('COUNT(*) as total'))
            ->where('company_mou_code', $code)
            ->where('operator_user_id', $cabang)
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->groupBy('nama_pos_pemeriksaan')
            ->get();

        return response()->json([
            'status'  => 'success',
            'pos1'    => $formatPos($pos1Raw),
            'pos2'    => $formatPos($pos2Raw),
            'current' => $currentRaw ? [
                'nomor_antrian'        => $currentRaw->nomor_antrian,
                'pos'                  => $currentRaw->nama_pos_pemeriksaan,
                'nama_pos_pemeriksaan' => $currentRaw->nama_pos_pemeriksaan,
                'panggilan_ke'         => $currentRaw->panggilan_ke,
                'nama_peserta'         => $currentRaw->mou_peserta_name ?? '-',
            ] : null,
            'recent'  => $recentCalls,
            'waiting' => $waitingCalls,
            'stats'   => $posStats
        ]);
    }
}
