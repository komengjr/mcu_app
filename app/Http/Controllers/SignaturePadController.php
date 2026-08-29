<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
        $data = DB::table('log_kehadiran_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_kehadiran_pasien.mou_peserta_code')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('log_kehadiran_pasien_token', $id)
            ->first();

        if ($data) {
            if ($data->log_kehadiran_pasien_status == 0) {
                return view('kehadiran.signature-template', ['data' => $data]);
            } elseif ($data->log_kehadiran_pasien_status == 1) {
                if ($data->mou_peserta_status == 0) {
                    $paket = DB::table('company_mou_agreement')->where('mou_agreement_code', $data->mou_agreement_code)->first();
                    if ($paket) {
                        $pemeriksaan = DB::table('company_mou_agreement_sub')
                            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
                            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)
                            ->get();

                        $pemeriksaan1 = DB::table('company_mou_agreement_user')
                            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_user.master_pemeriksaan_code')
                            ->where('company_mou_agreement_user.mou_peserta_code', $data->mou_peserta_code)
                            ->get();

                        // Get Lampiran Form MCU berdasarkan MoU Perusahaan
                        $mcu_forms = DB::table('company_mou_form')
                            ->join('mcu_forms', 'mcu_forms.form_code', '=', 'company_mou_form.form_code')
                            ->where('company_mou_form.company_mou_code', $data->company_mou_code)
                            ->where('mcu_forms.is_active', true)
                            ->orderBy('mcu_forms.sort_order', 'asc')
                            ->get();

                        $jumlah = $pemeriksaan->count() + $pemeriksaan1->count();

                        return view('kehadiran.form-pemeriksaan', [
                            'data' => $data,
                            'pemeriksaan' => $pemeriksaan,
                            'pemeriksaan1' => $pemeriksaan1,
                            'mcu_forms' => $mcu_forms,
                            'jumlah' => $jumlah
                        ]);
                    } else {
                        $paketmcu = DB::table('company_mou_agreement')->where('company_mou_code', $data->company_mou_code)->get();
                        return view('kehadiran.form-paket', ['data' => $data, 'paket' => $paketmcu]);
                    }
                } elseif ($data->mou_peserta_status == 1) {
                    return view('kehadiran.done');
                }
            } else {
                return view('kehadiran.done');
            }
        } else {
            return '<script>
                setTimeout(() => {
                    window.close();
                }, 100);
            </script>';
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
            return '<script>
                        setTimeout(() => {
                            window.close();
                        }, 100);
                    </script>';
        }
    }
    public function cari_data_peserta(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->where('mou_peserta_nip', $request->nip)->first();
        $cabang = DB::table('master_cabang')->where('master_cabang_code', $request->cab)->first();
        if ($data) {
            $log = DB::table('log_kehadiran_pasien')->where('mou_peserta_code', $data->mou_peserta_code)->first();
            if ($log) {
                return view('kehadiran.template-sign', ['data' => $data, 'cabang' => $cabang, 'token' => $log->log_kehadiran_pasien_token]);
            } else {
                $token = str::uuid() . '-' . Str::random(45);
                DB::table('log_kehadiran_pasien')->insert([
                    'mou_peserta_code' => $data->mou_peserta_code,
                    'log_kehadiran_pasien_lokasi' => $request->cab,
                    'log_kehadiran_pasien_sign' => '-',
                    'log_kehadiran_pasien_status' => '0',
                    'log_kehadiran_pasien_token' => $token,
                    'log_kehadiran_pasien_time' => now(),
                    'created_at' => now(),
                ]);
                return view('kehadiran.template-sign', ['data' => $data, 'cabang' => $cabang, 'token' => $token]);
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
            'log_kehadiran_pasien_token' => $request->token,
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
        return redirect()->back()->withSuccess('Great! Berhasil Check In Peserta MCU');
    }
    public function signaturepad_pilih_pemeriksaan(Request $request)
    {
        DB::table('company_mou_peserta')->where('mou_peserta_code', $request->id)->update([
            'mou_agreement_code' => $request->code
        ]);
    }
    public function update_pemeriksaan(Request $request)
    {
        $cek = DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->user)->where('master_pemeriksaan_code', $request->code)->first();
        if ($cek) {
            if ($request->option == 'on') {
                DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->user)->where('master_pemeriksaan_code', $request->code)->update([
                    'log_pemeriksaan_status' => 1,
                    'log_pemeriksaan_deskripsi' => $request->ket,
                ]);
            } elseif ($request->option == 'off') {
                DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->user)->where('master_pemeriksaan_code', $request->code)->update([
                    'log_pemeriksaan_status' => 0,
                    'log_pemeriksaan_deskripsi' => $request->ket,
                ]);
            }
        } else {
            if ($request->option == 'on') {
                DB::table('log_pemeriksaan_pasien')->insert([
                    'mou_peserta_code' => $request->user,
                    'master_pemeriksaan_code' => $request->code,
                    'log_pemeriksaan_status' => 1,
                    'log_pemeriksaan_deskripsi' => $request->ket,
                    'created_at' => now()
                ]);
            } elseif ($request->option == 'off') {
                DB::table('log_pemeriksaan_pasien')->insert([
                    'mou_peserta_code' => $request->user,
                    'master_pemeriksaan_code' => $request->code,
                    'log_pemeriksaan_status' => 0,
                    'log_pemeriksaan_deskripsi' => $request->ket,
                    'created_at' => now()
                ]);
            }
        }
        $data =  DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->user)->count();
        return $data;
    }
    public function update_pemeriksaan_save(Request $request)
    {
        DB::table('company_mou_peserta')->where('mou_peserta_code', $request->peserta)->update([
            'mou_peserta_status' => 1
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menyelesaikan Medicak Checkup');
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

    // PENGMABILAN SAMPLE

    public function pengambilan_sample($token)
    {
        $cek = DB::table('monitoring_hasil_pasien')->where('monitoring_hasil_pasien_code', $token)->first();
        if ($cek) {
            if ($cek->monitoring_hasil_pasien_status == 0) {
                return view('application.menu.monitoring-hasil.sign-kurir', ['token' => $token]);
            } else {
                return view('application.error.close-sign');
            }
        } else {
            return view('application.error.404');
        }
    }
    public function pengambilan_sample_save(Request $request)
    {
        try {
            DB::table('monitoring_hasil_kurir')->insert([
                'monitoring_hasil_kurir_code' => str::uuid(),
                'monitoring_hasil_pasien_code' => $request->token,
                'monitoring_hasil_kurir_name' => $request->nama_lengkap,
                'monitoring_hasil_kurir_date' => now(),
                'monitoring_hasil_kurir_sign' => $request->signed,
                'created_at' => now(),
            ]);
            DB::table('monitoring_hasil_pasien')->where('monitoring_hasil_pasien_code', $request->token)->update([
                'monitoring_hasil_pasien_status' => 1
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function notifikasi()
    {
        return view('notifikasi');
    }
    // 1. Method untuk Mengambil Data & Memuat View Form
    public function get_data_form_pemeriksaan(Request $request)
    {
        $formCode = $request->input('form_code');
        $userCode = $request->input('user_code');

        // Ambil detail header form
        $form = DB::table('mcu_forms')
            ->where('form_code', $formCode)
            ->first();

        if (!$form) {
            return response()->json(['status' => 'error', 'message' => 'Formulir tidak ditemukan'], 404);
        }

        // Ambil item form beserta opsi pilihan (select options)
        $items = DB::table('mcu_form_items')
            ->where('id_mcu_form', $form->id_mcu_form)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Ambil semua opsi pilihan dari tabel mcu_item_options
        $itemIds = $items->pluck('id_mcu_form_item');
        $options = DB::table('mcu_item_options')
            ->whereIn('id_mcu_form_item', $itemIds)
            ->get()
            ->groupBy('id_mcu_form_item');

        // Petakan opsi ke dalam masing-masing item
        $items->transform(function ($item) use ($options) {
            $item->options = $options->get($item->id_mcu_form_item, collect());
            return $item;
        });

        // Ambil data jawaban dari JSON
        $savedRecord = DB::table('mcu_peserta_answers')
            ->where('mou_peserta_code', $userCode)
            ->where('id_mcu_form', $form->id_mcu_form)
            ->first();

        // Decode JSON answers_data ke Array (key: id_mcu_form_item, value: jawaban)
        $answers = [];
        if ($savedRecord && $savedRecord->answers_data) {
            $answers = json_decode($savedRecord->answers_data, true) ?? [];
        }

        return view('kehadiran.form.form-template', compact('form', 'items', 'answers', 'userCode'));
    }

    // 2. Method untuk Menyimpan/Memperbarui Jawaban Form (AJAX POST)
    public function save_data_form_pemeriksaan(Request $request)
    {
        $request->validate([
            'id_mcu_form'  => 'required',
            'user_code'    => 'required',
            'answers'      => 'nullable|array',
            'answers_note' => 'nullable|array',
        ]);

        $idMcuForm   = $request->input('id_mcu_form');
        $userCode    = $request->input('user_code');
        $answers     = $request->input('answers', []);
        $answersNote = $request->input('answers_note', []);

        $formattedAnswers = [];

        foreach ($answers as $itemId => $value) {
            $note = $answersNote[$itemId] ?? null;

            // Jika ada catatan (biasanya opsi 'Ya'), bungkus jawaban & catatan ke dalam array
            if ($value === 'Ya' && !empty($note)) {
                $formattedAnswers[$itemId] = [
                    'value' => $value,
                    'note'  => $note
                ];
            } else {
                // Jika tidak ada catatan, simpan nilainya langsung
                $formattedAnswers[$itemId] = $value;
            }
        }

        try {
            DB::table('mcu_peserta_answers')->updateOrInsert(
                [
                    'mou_peserta_code' => $userCode,
                    'id_mcu_form'      => $idMcuForm,
                ],
                [
                    'answers_data' => json_encode($formattedAnswers),
                    'is_completed' => true,
                    'updated_at'   => now(),
                    'created_at'   => now(),
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Data formulir berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}
