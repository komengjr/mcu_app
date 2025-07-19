<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SignaturePadController extends Controller
{
    public function index()
    {

        return view('signaturePad');

    }
    public function contoh()
    {

        return view('contoh');

    }
    public function sign($id)
    {
        $data = DB::table('company_mou_peserta')
            ->join('log_kehadiran_pasien', 'log_kehadiran_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_kehadiran_pasien_token', $id)
            ->first();
        if ($data) {
            if ($data->log_kehadiran_pasien_status == 0) {
                return view('kehadiran.signature-template', ['data' => $data]);
                # code...
            } else {
                return view('kehadiran.done');
            }
        } else {
            return 'Selesai';
        }
    }
    public function sign_perusahaan($id)
    {
        $data = DB::table('company_mou_peserta_token_absensi')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta_token_absensi.company_mou_code')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou_token_code', $id)->first();
        if ($data) {
            $cabang = DB::table('master_cabang')->get();
            return view('kehadiran.form-absensi-perusahaan', ['data' => $data, 'cabang' => $cabang]);
        } else {
            return 'absensi tidak ditemukan';
        }
    }
    public function cari_data_peserta(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->where('mou_peserta_nip', $request->nip)->first();
        $cabang = DB::table('master_cabang')->where('master_cabang_code', $request->cab)->first();
        if ($data) {
            $log = DB::table('log_kehadiran_pasien')->where('mou_peserta_code', $data->mou_peserta_code)->first();
            if (!$log) {
                return view('kehadiran.template-sign', ['data' => $data, 'cabang' => $cabang]);
            } else {
                return 'Sudah Melakukan Absensi';
            }
        } else {
            return 'absensi tidak ditemukan';
        }
    }

    public function upload(Request $request)
    {
        $folderPath = public_path('/signature/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . Str::uuid() . '.' . $image_type;
        // $request->file->move(public_path('uploads'), uniqid() . '.' . $image_type);
        file_put_contents($file, $image_base64);
        return back()->with('success', 'success Full upload signature');
    }
    public function update(Request $request)
    {
        DB::table('log_kehadiran_pasien')->where('log_kehadiran_pasien_token', $request->token)->update([
            'log_kehadiran_pasien_sign' => $request->signed,
            'log_kehadiran_pasien_token' => str::uuid(),
            'log_kehadiran_pasien_status' => 1,
            'log_kehadiran_pasien_time' => now(),
        ]);
        $cek = DB::table('log_lokasi_pasien')->where('mou_peserta_code', $request->peserta)->first();
        if (!$cek) {
            DB::table('log_lokasi_pasien')->insert([
                'mou_peserta_code' => $request->peserta,
                'lokasi_cabang' => $request->cabang,
                'log_lokasi_status' => 1,
                'created_at' => now()
            ]);
        }
        return back()->with('success', 'success Full upload signature');
    }
    public function save_signiture(Request $request)
    {
        DB::table('log_kehadiran_pasien')->insert([
            'mou_peserta_code' => $request->peserta,
            'log_kehadiran_pasien_lokasi' => $request->cabang,
            'log_kehadiran_pasien_sign' => $request->signed,
            'log_kehadiran_pasien_token' => str::uuid(),
            'log_kehadiran_pasien_status' => 1,
            'log_kehadiran_pasien_time' => now(),
        ]);
        $cek = DB::table('log_lokasi_pasien')->where('mou_peserta_code', $request->peserta)->first();
        if (!$cek) {
            DB::table('log_lokasi_pasien')->insert([
                'mou_peserta_code' => $request->peserta,
                'lokasi_cabang' => $request->cabang,
                'log_lokasi_status' => 1,
                'created_at' => now()
            ]);
        }
        return back()->with('success', 'success Full upload signature');
    }
}
