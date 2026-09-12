<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OperatorAntrianController extends Controller
{
    public function index($cabang, $mou_code, $pos_code)
    {
        // 1. Cek keberadaan MOU
        $mou = DB::table('company_mou')->where('company_mou_code', $mou_code)->first();
        if (!$mou) {
            abort(404, 'MOU Tidak Ditemukan');
        }

        // 2. Validasi apakah pos_code ada di dalam paket MOU ini
        $posExistsInMou = DB::table('company_mou_agreement as a')
            ->join('company_mou_agreement_sub as sub', 'a.mou_agreement_code', '=', 'sub.mou_agreement_code')
            ->where('a.company_mou_code', $mou_code)
            ->where('sub.master_pemeriksaan_code', $pos_code)
            ->exists();

        if (!$posExistsInMou) {
            abort(403, 'Akses Ditolak: Pos Pemeriksaan tidak terdaftar pada MOU ini.');
        }

        // 3. Ambil Nama Pos Pemeriksaan dari Master Tabel
        $masterPos = DB::table('master_pemeriksaan')
            ->where('master_pemeriksaan_code', $pos_code)
            ->first();

        $namaPos = $masterPos ? $masterPos->master_pemeriksaan_name : $pos_code;

        return view('operator.antrian', compact('cabang', 'mou_code', 'pos_code', 'namaPos', 'mou'));
    }

    public function getData($cabang, $mou_code, $pos_code)
    {
        // 1. Antrian Aktif di Pos Ini
        $currentCall = DB::table('log_pemanggilan_pos as call')
            ->join('log_antrian_peserta as antrian', 'call.log_antrian_id', '=', 'antrian.log_antrian_id')
            ->join('company_mou_peserta as p', 'call.mou_peserta_code', '=', 'p.mou_peserta_code')
            ->leftJoin('master_pemeriksaan as mp', 'call.master_pemeriksaan_code', '=', 'mp.master_pemeriksaan_code')
            ->select(
                'call.id_log_pemanggilan',
                'call.log_antrian_id',
                'call.panggilan_ke',
                'call.status_antrian',
                'antrian.nomor_antrian',
                'p.mou_peserta_name',
                'p.mou_peserta_nip',
                'p.mou_peserta_departemen',
                'mp.master_pemeriksaan_name'
            )
            ->where('call.company_mou_code', $mou_code)
            ->where('call.operator_user_id', $cabang)
            ->where('call.master_pemeriksaan_code', $pos_code)
            ->whereIn('call.status_antrian', ['Dipanggil', 'Sedang Diperiksa'])
            ->orderBy('call.updated_at', 'desc')
            ->first();

        // 2. Daftar Peserta Menunggu
        // (Pendaftaran Selesai + Punya Pos Pemeriksaan Ini + Belum Pernah Dipanggil di Pos Ini)
        $waitingList = DB::table('log_antrian_peserta as log')
            ->join('company_mou_peserta as p', 'log.mou_peserta_code', '=', 'p.mou_peserta_code')
            ->select(
                'log.log_antrian_id',
                'log.nomor_antrian',
                'log.mou_peserta_code',
                'p.mou_peserta_name',
                'p.mou_peserta_departemen'
            )
            ->where('log.company_mou_code', $mou_code)
            ->where('log.operator_user_id', $cabang)
            ->where('log.status_antrian', 'Selesai')
            // Filter 1: Hanya ambil peserta yang agreement package-nya memuat pos_code ini
            ->whereIn('p.mou_agreement_code', function ($query) use ($pos_code) {
                $query->select('mou_agreement_code')
                    ->from('company_mou_agreement_sub')
                    ->where('master_pemeriksaan_code', $pos_code);
            })
            // Filter 2: Abaikan peserta yang SUDAH PERNAH dipanggil/proses di pos ini
            ->whereNotIn('log.mou_peserta_code', function ($query) use ($mou_code, $pos_code) {
                $query->select('mou_peserta_code')
                    ->from('log_pemanggilan_pos')
                    ->where('company_mou_code', $mou_code)
                    ->where('master_pemeriksaan_code', $pos_code);
            })
            ->orderBy('log.updated_at', 'asc')
            ->get();

        // 3. Daftar Peserta Selesai di Pos Ini
        $finishedList = DB::table('log_pemanggilan_pos as call')
            ->join('log_antrian_peserta as antrian', 'call.log_antrian_id', '=', 'antrian.log_antrian_id')
            ->join('company_mou_peserta as p', 'call.mou_peserta_code', '=', 'p.mou_peserta_code')
            ->select(
                'antrian.nomor_antrian',
                'p.mou_peserta_name',
                'call.waktu_selesai'
            )
            ->where('call.company_mou_code', $mou_code)
            ->where('call.operator_user_id', $cabang)
            ->where('call.master_pemeriksaan_code', $pos_code)
            ->where('call.status_antrian', 'Selesai')
            ->orderBy('call.waktu_selesai', 'desc')
            ->limit(10)
            ->get();

        // 4. Daftar Peserta Dilewatkan (Skipped) di Pos Ini
        $skippedList = DB::table('log_pemanggilan_pos as call')
            ->join('company_mou_peserta as p', 'call.mou_peserta_code', '=', 'p.mou_peserta_code')
            ->select(
                'call.id_log_pemanggilan',
                'call.log_antrian_id',
                'call.nomor_antrian',
                'call.mou_peserta_code',
                'p.mou_peserta_name',
                'p.mou_peserta_departemen',
                'call.panggilan_ke',
                'call.updated_at'
            )
            ->where('call.company_mou_code', $mou_code)
            ->where('call.operator_user_id', $cabang)
            ->where('call.master_pemeriksaan_code', $pos_code)
            ->where('call.status_antrian', 'Lewat/Skip')
            ->orderBy('call.updated_at', 'desc')
            ->get();

        return response()->json([
            'status'   => 'success',
            'current'  => $currentCall,
            'waiting'  => $waitingList,
            'skipped'  => $skippedList,
            'finished' => $finishedList
        ]);
    }
    public function panggilAntrianPos(Request $request)
    {
        $logAntrianId = $request->log_antrian_id; // ID dari log_antrian_peserta
        $posCode      = $request->pos_code;
        $cabangId     = $request->operator_user_id;

        $antrian = DB::table('log_antrian_peserta')
            ->where('log_antrian_id', $logAntrianId)
            ->first();

        if (!$antrian) {
            return response()->json(['status' => 'error', 'message' => 'Data antrian tidak ditemukan.'], 404);
        }

        // Insert Record Baru KHUSUS di log_pemanggilan_pos
        $idLogPos = DB::table('log_pemanggilan_pos')->insertGetId([
            'log_pemanggilan_code'   => 'CALL-' . Str::upper(Str::random(10)),
            'log_antrian_id'         => $antrian->log_antrian_id,
            'log_antrian_code'       => $antrian->log_antrian_code,
            'nomor_antrian'          => $antrian->nomor_antrian,
            'company_mou_code'       => $antrian->company_mou_code,
            'mou_peserta_code'       => $antrian->mou_peserta_code,
            'master_pemeriksaan_code' => $posCode,
            'status_antrian'         => 'Dipanggil', // Status Pos
            'panggilan_ke'           => 1,
            'operator_user_id'       => $cabangId,
            'waktu_panggil'          => now(),
            'created_at'             => now(),
            'updated_at'             => now()
        ]);

        // Catatan: log_antrian_peserta TIDAK DI-UPDATE, statusnya tetap 'Selesai'

        return response()->json(['status' => 'success', 'message' => 'Pasien dipanggil di pos pemeriksaan']);
    }

    // 2. Panggil Ulang (Update log_pemanggilan_pos)
    public function panggilUlangPos(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan; // ID dari log_pemanggilan_pos

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'panggilan_ke'  => DB::raw('panggilan_ke + 1'),
                'waktu_panggil' => now(),
                'updated_at'    => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Panggilan ulang berhasil']);
    }

    // 3. Mulai Periksa (Update log_pemanggilan_pos -> Sedang Diperiksa)
    public function mulaiProsesPos(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Sedang Diperiksa',
                'waktu_melayani' => now(),
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Pemeriksaan dimulai']);
    }

    // 4. Selesai Periksa (Update log_pemanggilan_pos -> Selesai)
    public function selesaiProsesPos(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Selesai',
                'waktu_selesai'  => now(),
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Pemeriksaan pos selesai']);
    }

    // 5. Lewatkan / Skip (Update log_pemanggilan_pos -> Lewat/Skip)
    public function skipAntrianPos(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Lewat/Skip',
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Antrian dilewatkan']);
    }

    // 1. Panggil Pertama (Create data baru di log_pemanggilan_pos)
    public function panggilNext(Request $request)
    {
        $logAntrianId = $request->log_antrian_id;
        $posCode      = $request->pos_code;
        $cabangId     = $request->operator_user_id;

        // Ambil data induk antrian peserta
        $antrian = DB::table('log_antrian_peserta')
            ->where('log_antrian_id', $logAntrianId)
            ->first();

        if (!$antrian) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data antrian tidak ditemukan.'
            ], 404);
        }

        // --------------------------------------------------------------------------
        // VALIDASI CROSS-POS: Cek apakah peserta sedang diperiksa di pos lain
        // --------------------------------------------------------------------------
        $sedangDiperiksaLain = DB::table('log_pemanggilan_pos as call')
            ->leftJoin('master_pemeriksaan as mp', 'call.master_pemeriksaan_code', '=', 'mp.master_pemeriksaan_code')
            ->select('mp.master_pemeriksaan_name', 'call.master_pemeriksaan_code')
            ->where('call.mou_peserta_code', $antrian->mou_peserta_code)
            ->where('call.company_mou_code', $antrian->company_mou_code)
            ->where('call.status_antrian', 'Sedang Diperiksa')
            ->first();

        if ($sedangDiperiksaLain) {
            $namaPosAktif = $sedangDiperiksaLain->master_pemeriksaan_name ?? $sedangDiperiksaLain->master_pemeriksaan_code;
            return response()->json([
                'status'  => 'warning',
                'message' => "Pasien {$antrian->nomor_antrian} sedang dalam pemeriksaan di POS {$namaPosAktif}. Selesaikan dulu pemeriksaan di pos tersebut!"
            ], 422);
        }
        // --------------------------------------------------------------------------

        // Insert transaksi baru ke log_pemanggilan_pos jika lolos validasi
        $idLogPos = DB::table('log_pemanggilan_pos')->insertGetId([
            'log_pemanggilan_code'   => 'CALL-' . Str::upper(Str::random(10)),
            'log_antrian_id'         => $antrian->log_antrian_id,
            'log_antrian_code'       => $antrian->log_antrian_code,
            'nomor_antrian'          => $antrian->nomor_antrian,
            'company_mou_code'       => $antrian->company_mou_code,
            'mou_peserta_code'       => $antrian->mou_peserta_code,
            'master_pemeriksaan_code' => $posCode,
            'status_antrian'         => 'Dipanggil',
            'panggilan_ke'           => 1,
            'operator_user_id'       => $cabangId,
            'waktu_panggil'          => now(),
            'created_at'             => now(),
            'updated_at'             => now()
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Antrian berhasil dipanggil.',
            'id'      => $idLogPos
        ]);
    }

    public function panggilUlang(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        // Jika antrian sebelumnya dalam status 'Lewat/Skip', ubah kembali statusnya menjadi 'Dipanggil'
        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Dipanggil',
                'panggilan_ke'   => DB::raw('panggilan_ke + 1'),
                'waktu_panggil'  => now(),
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Panggilan antrian diproses kembali.']);
    }

    public function mulaiProses(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Sedang Diperiksa',
                'waktu_melayani' => now(),
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Pemeriksaan dimulai.']);
    }

    public function selesaiProses(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Selesai',
                'waktu_selesai'  => now(),
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Pemeriksaan pos selesai.']);
    }

    public function skipAntrian(Request $request)
    {
        $idLogPos = $request->id_log_pemanggilan;

        DB::table('log_pemanggilan_pos')
            ->where('id_log_pemanggilan', $idLogPos)
            ->update([
                'status_antrian' => 'Lewat/Skip',
                'updated_at'     => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Antrian dilewatkan.']);
    }
}
