<?php

namespace App\Http\Controllers;

use App\Imports\PesertaImport;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function url_akses($akses)
    {
        $data = DB::table('z_menu_user')->where('menu_sub_code', $akses)->where('access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function home($akses)
    {
        if ($this->url_akses($akses) == true) {

            return view('application.dashboard.home');
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function monitoring_mcu($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->join('company_mou_access', 'company_mou_access.company_mou_code', '=', 'company_mou.company_mou_code')
                ->where('company_mou_access.userid', Auth::user()->userid)->get();
            return view('application.dashboard.monitoring-mcu', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function monitoring_mcu_detail(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.dashboard.monitoring.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta]);
    }
    public function monitoring_mcu_rekap(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $image = base64_encode(file_get_contents(public_path('img/sima.jpeg')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.dashboard.monitoring.report.rekap-mcu', ['data' => $data, 'peserta' => $peserta], compact('image'))->setPaper('A3', 'landscape')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        return base64_encode($pdf->stream());
    }

    // MCU
    public function medical_check_up($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->where('company_mou_status', 1)
                ->where('company_mou_start', '<=', date('Y-m-d'))->get();
            return view('application.menu.medical-check-up', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function medical_check_up_detail(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.menu.mcu.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta]);
    }
    public function medical_check_up_prosess(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        return view('application.menu.mcu.form-proses-mcu', ['data' => $data, 'pemeriksaan' => $pemeriksaan]);
    }
    public function medical_check_up_prosess_save(Request $request)
    {
        $check = DB::table('log_lokasi_pasien')->where('mou_peserta_code', $request->code)->first();
        if ($check) {
            return redirect()->back()->withError('Gagal! Gagal Check In Peserta MCU');
        } else {
            DB::table('log_lokasi_pasien')->insert([
                'mou_peserta_code' => $request->code,
                'lokasi_cabang' => Auth::user()->access_cabang,
                'log_lokasi_status' => 1,
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Check In Peserta MCU');
        }
    }
    public function medical_check_up_summary(Request $request)
    {
        return view('application.menu.mcu.form-summary-mcu');
    }

    // MENU SERVICE
    public function menu_service($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.mou_peserta_status','!=',1)
                ->orderBy('log_lokasi_pasien.id_log_lokasi_pasien', 'DESC')->get();
            return view('application.menu.menu-service', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }

    }
    public function menu_service_proses(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        return view('application.menu.service.form-proses-pasien', ['data' => $data, 'pemeriksaan' => $pemeriksaan]);
    }
    public function menu_service_proses_pemeriksaan_save(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $check = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        foreach ($check as $value) {
            $cek = DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->code)
                ->where('master_pemeriksaan_code', $value->master_pemeriksaan_code)->where('log_pemeriksaan_status', 1)->first();
            if (!$cek) {
                if ($request[$value->master_pemeriksaan_code] == 1) {
                    $tes = DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->code)
                        ->where('master_pemeriksaan_code', $value->master_pemeriksaan_code)->first();
                    if ($tes) {
                        DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->code)
                            ->where('master_pemeriksaan_code', $value->master_pemeriksaan_code)->update([
                                    'log_pemeriksaan_status' => 1,
                                    'log_pemeriksaan_deskripsi' => $request['desc' . $value->master_pemeriksaan_code],
                                ]);
                    } else {
                        DB::table('log_pemeriksaan_pasien')->insert([
                            'mou_peserta_code' => $request->code,
                            'master_pemeriksaan_code' => $value->master_pemeriksaan_code,
                            'log_pemeriksaan_status' => 1,
                            'log_pemeriksaan_deskripsi' => $request['desc' . $value->master_pemeriksaan_code],
                            'created_at' => now()
                        ]);

                    }
                } elseif ($request[$value->master_pemeriksaan_code] == 0) {
                    $tes = DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->code)
                        ->where('master_pemeriksaan_code', $value->master_pemeriksaan_code)->first();
                    if ($tes) {
                        DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $request->code)
                            ->where('master_pemeriksaan_code', $value->master_pemeriksaan_code)->update([
                                    'log_pemeriksaan_status' => 0,
                                    'log_pemeriksaan_deskripsi' => $request['desc' . $value->master_pemeriksaan_code],
                                ]);
                    } else {
                        DB::table('log_pemeriksaan_pasien')->insert([
                            'mou_peserta_code' => $request->code,
                            'master_pemeriksaan_code' => $value->master_pemeriksaan_code,
                            'log_pemeriksaan_status' => 0,
                            'log_pemeriksaan_deskripsi' => $request['desc' . $value->master_pemeriksaan_code],
                            'created_at' => now()
                        ]);

                    }
                }
            }
        }
        return redirect()->back()->withSuccess('Great! Berhasil Update Chcklis Pemeriksaan');
    }
    public function menu_service_proses_konsultasi_save(Request $request)
    {
        DB::table('log_konsultasi_pasien')->insert([
            'mou_peserta_code' => $request->code,
            'log_konsultasi_status' => $request->konsul_dokter,
            'log_konsultasi_deskripsi' => $request->desc_konsul,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Update Konsultasi Dokter');
    }
    public function menu_service_proses_pengiriman_save(Request $request)
    {
        DB::table('log_pengiriman_pasien')->insert([
            'mou_peserta_code' => $request->code,
            'log_pengiriman_status' => $request->pengiriman,
            'log_pengiriman_date' => $request->tanggal_kirim.' '.$request->time_kirim,
            'log_pengiriman_deskripsi' => $request->desc_pengiriman,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Update Pengiriman Hasil');
    }
    public function menu_service_proses_penyelesaian_peserta_mcu(Request $request){
        DB::table('company_mou_peserta')->where('mou_peserta_code',$request->code)->update([
            'mou_peserta_status'=>1
        ]);
        return 'sukses';
    }

    // COMPANY MASTER
    public function master_company($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('master_company')->get();
            return view('application.master-data.master-company', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_company_add_company(Request $request)
    {
        return view('application.master-data.company.form-add');
    }
    public function master_company_add_company_save(Request $request)
    {
        $total = DB::table('master_company')->count();
        DB::table('master_company')->insert([
            'master_company_code' => 'CMP' . date('Ymd') . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'master_company_name' => $request->name,
            'master_company_wilayah' => $request->lokasi,
            'master_company_nat' => 0,
            'master_company_type' => $request->type,
            'master_company_phone' => $request->phone,
            'master_company_email' => $request->email,
            'master_company_level' => 0,
            'master_company_status' => 0,
            'master_company_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }

    // COMPANY MOU
    public function mou_company($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->orderBy('id_company_mou', 'DESC')->get();
            return view('application.master-data.mou-company', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function mou_company_add(Request $request)
    {
        $data = DB::table('master_company')
            ->get();
        return view('application.master-data.mou-company.form-add', ['data' => $data]);
    }
    public function mou_company_save(Request $request)
    {
        $total = DB::table('company_mou')->where('master_company_code', $request->perusahaan)->count();
        DB::table('company_mou')->insert([
            'company_mou_code' => $request->perusahaan . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'master_company_code' => $request->perusahaan,
            'company_mou_name' => $request->nama,
            'company_mou_peserta' => $request->peserta,
            'company_mou_start' => $request->start,
            'company_mou_end' => $request->end,
            'company_mou_status' => 0,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }
    public function mou_company_peserta_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta]);
    }
    public function mou_company_insert_peserta_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.master-data.mou-company.form-insert-peserta', ['data' => $data]);
    }
    public function mou_company_insert_peserta_mcu_manual(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-add-peserta', ['code' => $request->code, 'data' => $data]);
    }
    public function mou_company_insert_peserta_mcu_manual_save(Request $request)
    {
        DB::table('company_mou_peserta')->insert([
            'mou_peserta_code' => $request->code . mt_rand(1000, 9999),
            'company_mou_code' => $request->code,
            'mou_peserta_nik' => $request->nik,
            'mou_peserta_nip' => $request->nip,
            'mou_peserta_name' => $request->nama,
            'mou_peserta_ttl' => $request->ttl,
            'mou_peserta_jk' => $request->jk,
            'mou_peserta_no_hp' => $request->no_hp,
            'mou_peserta_email' => $request->email,
            'mou_peserta_departemen' => $request->departemen,
            'mou_agreement_code' => $request->agreement,
            'mou_peserta_status' => 0,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }
    public function mou_company_insert_peserta_mcu_upload(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-upload-excel', ['code' => $request->code, 'data' => $data]);
    }
    public function mou_company_insert_peserta_mcu_upload_save(Request $request)
    {
        Excel::import(new PesertaImport($request->code, $request->id), request()->file('file'));
        Session::flash('sukses', 'Upload Data Sukses');
        return redirect()->back();
    }
    public function mou_company_insert_pemeriksaan_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $pemeriksaan = DB::table('master_pemeriksaan')->get();
        return view('application.master-data.mou-company.form-insert-pemeriksaan', ['data' => $data, 'pemeriksaan' => $pemeriksaan]);
    }
    public function mou_company_insert_pemeriksaan_mcu_insert(Request $request)
    {
        DB::table('company_mou_pemeriksaan')->insert([
            'mou_pemeriksaan_code' => str::uuid(),
            'company_mou_code' => $request->code,
            'master_pemeriksaan_code' => $request->id,
            'created_at' => now()
        ]);
        return 'sukses';
    }
    public function mou_company_activasi_mou(Request $request)
    {
        return view('application.master-data.mou-company.form-activasi-mou', ['code' => $request->code]);
    }
    public function mou_company_activasi_mou_save(Request $request)
    {
        $peserta = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->first();
        if ($peserta || $paket) {
            DB::table('company_mou')->where('company_mou_code', $request->code)->update([
                'company_mou_status' => 1
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Aktivasi Data MOU Perusahaan');
        } else {
            return redirect()->back()->withError('Gagal! Peserta dan Pemilihan Paket TIdak Boleh Kosong');
        }
    }

    // AGREEMENT PERUSAHAAN
    public function agreement_perusahaan($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou_agreement')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_agreement.company_mou_code')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->get();
            return view('application.master-data.agreement-perusahaan', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function agreement_perusahaan_add(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')->get();
        return view('application.master-data.agreement.form-add', ['data' => $data]);
    }
    public function agreement_perusahaan_save(Request $request)
    {
        DB::table('company_mou_agreement')->insert([
            'mou_agreement_code' => str::uuid(),
            'company_mou_code' => $request->code,
            'mou_agreement_name' => $request->nama,
            'mou_agreement_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }
    public function agreement_perusahaan_add_pemeriksaan(Request $request)
    {
        $pemeriksaan = DB::table('master_pemeriksaan')->get();
        $data = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $request->code)->get();
        return view('application.master-data.agreement.form-add-pemeriksaan', ['pemeriksaan' => $pemeriksaan, 'code' => $request->code, 'data' => $data]);
    }
    public function agreement_perusahaan_save_pemeriksaan(Request $request)
    {
        DB::table('company_mou_agreement_sub')->insert([
            'mou_agreement_code' => $request->code,
            'master_pemeriksaan_code' => $request->id,
            'created_at' => now()
        ]);
        $data = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $request->code)->get();
        return view('application.master-data.agreement.table-pemeriksaan-mcu', ['data' => $data]);
    }
    public function agreement_perusahaan_remove_pemeriksaan(Request $request)
    {
        DB::table('company_mou_agreement_sub')->where('id_mou_agreement_sub', $request->id)->delete();
        $data = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $request->code)->get();
        return view('application.master-data.agreement.table-pemeriksaan-mcu', ['data' => $data]);
    }


    // MASTER PEMERIKSAAN
    public function master_pemeriksaan($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('master_pemeriksaan')->get();
            return view('application.master-data.master-pemeriksaan', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }

    }
    public function master_pemeriksaan_add(Request $request)
    {
        return view('application.master-data.pemeriksaan.form-add');
    }
    public function master_pemeriksaan_save(Request $request)
    {
        DB::table('master_pemeriksaan')->insert([
            'master_pemeriksaan_code' => str::uuid(),
            'master_pemeriksaan_name' => $request->nama,
            'master_pemeriksaan_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Pemeriksaan');
    }

    // MASTER AKSES MOU
    public function master_access_mou($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('user_mains')->where('access_code', '=', '2070244a-4f32-4c81-956b-5dd394819b3b')->get();
            return view('application.master-data.master-access-mou', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_access_mou_add_akses(Request $request)
    {
        $data = DB::table('company_mou')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->get();
        return view('application.master-data.mou-akses.form-data-mou', ['data' => $data, 'code' => $request->code]);
    }
    public function master_access_mou_add_akses_pilih(Request $request)
    {
        DB::table('company_mou_access')->insert([
            'company_mou_code' => $request->id,
            'userid' => $request->code,
            'created_at' => now()
        ]);
        return 123;
    }

    // LAPORAN REKAP MCU
    public function laporan_rekap_mcu($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('user_mains')->where('access_code', '=', '2070244a-4f32-4c81-956b-5dd394819b3b')->get();
            return view('application.laporan.laporan-rekap-mcu', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function laporan_rekap_mcu_cari_data(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')->get();
        return view('application.laporan.rekap-mcu.form-cari-project', ['data' => $data]);
    }
    public function laporan_rekap_mcu_pilih_data(Request $request)
    {
        $data = DB::table('company_mou')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->perusahaan)
            ->first();
        $cab = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('company_mou_peserta.company_mou_code', $request->perusahaan)->orderBy('master_cabang.id_master_cabang', 'ASC')->get()->unique('master_cabang_city');
        $cabang = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('company_mou_peserta.company_mou_code', $request->perusahaan)
            ->get()
            ->unique('lokasi_cabang');
        $totalpeserta = DB::table('company_mou_peserta')->where('company_mou_code', $request->perusahaan)->count();
        $totalmcu = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('company_mou_peserta.company_mou_code', $request->perusahaan)
            ->count();
        return view('application.laporan.rekap-mcu.detail-rekap-mcu', [
            'data' => $data,
            'cabang' => $cabang,
            'cab' => $cab,
            'totalpeserta' => $totalpeserta,
            'totalmcu' => $totalmcu,
        ]);
    }
}
