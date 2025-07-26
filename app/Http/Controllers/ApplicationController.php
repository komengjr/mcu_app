<?php

namespace App\Http\Controllers;

use App\Exports\McuExport;
use App\Imports\PesertaAllImport;
use App\Imports\PesertaImport;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            if (Auth::user()->access_code == 'master') {
                $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                    ->join('company_mou_access', 'company_mou_access.company_mou_code', '=', 'company_mou.company_mou_code')->get();
            } else {
                $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                    ->join('company_mou_access', 'company_mou_access.company_mou_code', '=', 'company_mou.company_mou_code')
                    ->where('company_mou_access.userid', Auth::user()->userid)->get();
            }
            return view('application.dashboard.monitoring-mcu', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function monitoring_mcu_cari_nama(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->join('company_mou_access', 'company_mou_access.company_mou_code', '=', 'company_mou.company_mou_code')
                ->where('company_mou.company_mou_name', 'like', '%' . $request->code . '%')->get();
        } else {
            $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->join('company_mou_access', 'company_mou_access.company_mou_code', '=', 'company_mou.company_mou_code')
                ->where('company_mou.company_mou_name', 'like', '%' . $request->code . '%')
                ->where('company_mou_access.userid', Auth::user()->userid)->get();
        }
        return view('application.dashboard.hasil-pencarian-mcu', ['data' => $data]);
    }
    public function monitoring_mcu_detail(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.dashboard.monitoring.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta]);
    }
    public function monitoring_mcu_detail_belum(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.dashboard.monitoring.data-peserta-mcu-belum', ['data' => $data, 'peserta' => $peserta]);
    }
    public function monitoring_mcu_detail_sudah(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.dashboard.monitoring.data-peserta-mcu-sudah', ['data' => $data, 'peserta' => $peserta]);
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
    public function monitoring_mcu_rekap_full(Request $request)
    {
        $data = DB::table('company_mou')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)
            ->first();
        $cab = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('company_mou_peserta.company_mou_code', $request->code)->orderBy('master_cabang.id_master_cabang', 'ASC')->get()->unique('master_cabang_city');
        $cabang = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'master_cabang.master_cabang_code')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)
            ->get()
            ->unique('lokasi_cabang');
        $totalpeserta = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->count();
        $totalmcu = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('company_mou_peserta.company_mou_code', $request->code)
            ->count();
        $group = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'master_cabang.master_cabang_code')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)
            ->get()->unique('group_cabang_code');
        return view('application.dashboard.monitoring.rekap-full', [
            'data' => $data,
            'cabang' => $cabang,
            'cab' => $cab,
            'totalpeserta' => $totalpeserta,
            'totalmcu' => $totalmcu,
            'group' => $group,
        ]);
    }
    public function monitoring_mcu_rekap_full_detail(Request $request)
    {
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $request->code)->get()->unique('master_pemeriksaan_code');
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.dashboard.monitoring.data-peserta-full-rekap', ['data' => $data, 'pem' => $pemeriksaan, 'peserta' => $peserta]);
    }

    // MCU
    public function medical_check_up($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->where('company_mou_status', 1)
                ->where('company_mou_start', '<=', date('Y-m-d'))->orderBy('id_company_mou', 'DESC')->get();
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
    public function medical_check_up_add_pesertal(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.menu.service.form-add-peserta', ['code' => $request->code, 'data' => $data]);
    }
    public function medical_check_up_prosess(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        $cabang = DB::table('master_cabang')->get();
        return view('application.menu.mcu.form-proses-mcu', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'cabang' => $cabang]);
    }
    public function medical_check_up_prosess_save(Request $request)
    {
        $check = DB::table('log_lokasi_pasien')->where('mou_peserta_code', $request->code)->first();
        if ($check) {
            return redirect()->back()->withError('Gagal! Gagal Check In Peserta MCU');
        } else {
            DB::table('log_lokasi_pasien')->insert([
                'mou_peserta_code' => $request->code,
                'lokasi_cabang' => $request->cabang,
                'log_lokasi_status' => 1,
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Check In Peserta MCU');
        }
    }
    public function medical_check_up_prosess_update(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        $cabang = DB::table('master_cabang')->get();
        return view('application.menu.mcu.form-proses-mcu-update', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'cabang' => $cabang]);
    }
    public function medical_check_up_prosess_update_save(Request $request)
    {
        DB::table('log_lokasi_pasien')->where('mou_peserta_code', $request->code)->update([
            'lokasi_cabang' => $request->cabang
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil update Check In Peserta MCU');
    }
    public function medical_check_up_prosess_generate_absensi(Request $request)
    {
        $code = DB::table('log_kehadiran_pasien')->where('mou_peserta_code', $request->code)->first();
        if ($code) {
            $token = $code->log_kehadiran_pasien_token;
        } else {
            $token = str::uuid() . '-' . Str::random(25);
            DB::table('log_kehadiran_pasien')->insert([
                'mou_peserta_code' => $request->code,
                'log_kehadiran_pasien_lokasi' => Auth::user()->access_cabang,
                'log_kehadiran_pasien_sign' => '-',
                'log_kehadiran_pasien_status' => '0',
                'log_kehadiran_pasien_token' => $token,
                'log_kehadiran_pasien_time' => now(),
                'created_at' => now(),
            ]);
        }

        return view('application.menu.mcu.generate-absensi-kehadiran', ['token' => $token]);
    }
    public function medical_check_up_prosess_cetak_absensi(Request $request)
    {
        return view('application.menu.mcu.form-report-absensi-mcu', ['code' => $request['code']]);
    }
    public function medical_check_up_prosess_cetak_absensi_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo-pramita.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.menu.mcu.report.report-absensi-mcu', ['data' => $data, 'peserta' => $peserta], compact('image'))->setPaper('A4', 'landscape')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        return base64_encode($pdf->stream());
    }
    public function medical_check_up_summary(Request $request)
    {
        $mou = DB::table('company_mou')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $data = DB::table('log_summary_cabang')
            ->where('company_mou_code', $request->code)
            ->where('master_cabang_code', Auth::user()->access_cabang)
            ->first();
        return view('application.menu.mcu.form-summary-mcu', ['code' => $request->code, 'data' => $data, 'mou' => $mou]);
    }
    public function medical_check_up_summary_save_persentasi(Request $request)
    {
        $data = DB::table('log_summary_cabang')->where('company_mou_code', $request->code)->where('master_cabang_code', Auth::user()->access_cabang)->first();
        if ($request->link == "") {
            $img = null;
        } else {
            $img = 'public/document/persentasi/' . auth::user()->access_cabang . '/' . $request->link;
        }
        if ($data) {
            DB::table('log_summary_cabang')->where('company_mou_code', $request->code)
                ->where('master_cabang_code', Auth::user()->access_cabang)->update([
                    'summary_cabang_pesentasi' => $request->persentasi,
                    'summary_cabang_pesentasi_r' => $img,
                    'summary_cabang_pesentasi_date' => now(),
                ]);
        } else {
            DB::table('log_summary_cabang')->insert([
                'summary_cabang_code' => str::uuid(),
                'company_mou_code' => $request->code,
                'master_cabang_code' => Auth::user()->access_cabang,
                'summary_cabang_pesentasi' => $request->persentasi,
                'summary_cabang_pesentasi_r' => $img,
                'summary_cabang_pesentasi_date' => now(),
                'created_at' => now()
            ]);
        }

        return redirect()->back()->withSuccess('Great! Berhasil Update Persentasi MCU');
    }
    public function medical_check_up_summary_save_executive(Request $request)
    {
        $data = DB::table('log_summary_cabang')->where('company_mou_code', $request->code)->where('master_cabang_code', Auth::user()->access_cabang)->first();
        if ($request->link_executive == "") {
            $img = null;
        } else {
            $img = 'public/document/executive/' . auth::user()->access_cabang . '/' . $request->link_executive;
        }
        if ($data) {
            DB::table('log_summary_cabang')->where('company_mou_code', $request->code)
                ->where('master_cabang_code', Auth::user()->access_cabang)->update([
                    'summary_cabang_executive' => $request->executive,
                    'summary_cabang_executive_r' => $img,
                    'summary_cabang_executive_date' => now(),
                ]);
        } else {
            DB::table('log_summary_cabang')->insert([
                'summary_cabang_code' => str::uuid(),
                'company_mou_code' => $request->code,
                'master_cabang_code' => Auth::user()->access_cabang,
                'summary_cabang_executive' => $request->executive,
                'summary_cabang_executive_r' => $img,
                'summary_cabang_executive_date' => now(),
                'created_at' => now()
            ]);
        }
        return redirect()->back()->withSuccess('Great! Berhasil Update Executive MCU');
    }
    public function medical_check_up_summary_save_healty_talk(Request $request)
    {
        $data = DB::table('log_summary_cabang')->where('company_mou_code', $request->code)->where('master_cabang_code', Auth::user()->access_cabang)->first();
        if ($request->link_ha == "") {
            $img = null;
        } else {
            $img = 'public/document/healty_talk/' . auth::user()->access_cabang . '/' . $request->link_ha;
        }
        if ($data) {
            DB::table('log_summary_cabang')->where('company_mou_code', $request->code)
                ->where('master_cabang_code', Auth::user()->access_cabang)->update([
                    'summary_cabang_ht' => $request->healty_talk,
                    'summary_cabang_ht_r' => $img,
                    'summary_cabang_ht_date' => now(),
                ]);
        } else {
            DB::table('log_summary_cabang')->insert([
                'summary_cabang_code' => str::uuid(),
                'company_mou_code' => $request->code,
                'master_cabang_code' => Auth::user()->access_cabang,
                'summary_cabang_ht' => $request->healty_talk,
                'summary_cabang_ht_r' => $img,
                'summary_cabang_ht_date' => now(),
                'created_at' => now()
            ]);
        }
        return redirect()->back()->withSuccess('Great! Berhasil Update Executive MCU');
    }

    // MENU SERVICE
    public function menu_service($akses)
    {
        if ($this->url_akses($akses) == true) {
            if (Auth::user()->access_code == '0c654ba3-4496-4873-9a4c-f15f1fbc73d2' || Auth::user()->access_code == 'master') {
                $data = DB::table('company_mou_peserta')
                    ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                    ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                    ->where('company_mou_peserta.mou_peserta_status', '<', 2)
                    ->orderBy('log_lokasi_pasien.id_log_lokasi_pasien', 'DESC')->get();
            } else {
                $data = DB::table('company_mou_peserta')
                    ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                    ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                    ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                    ->where('company_mou_peserta.mou_peserta_status', '<', 2)
                    ->orderBy('log_lokasi_pasien.id_log_lokasi_pasien', 'DESC')->get();
            }
            $perusahaan = DB::table('master_company')->get();
            return view('application.menu.menu-service', ['data' => $data, 'perusahaan' => $perusahaan]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_service_pilih_perusahaan(Request $request)
    {
        $paket = DB::table('company_mou')->where('master_company_code', $request->code)->get();
        return view('application.menu.service.form-select-agreement', ['paket' => $paket]);
    }
    public function menu_service_pilih_agreement(Request $request)
    {
        if (Auth::user()->access_code == '0c654ba3-4496-4873-9a4c-f15f1fbc73d2' || Auth::user()->access_code == 'master') {
            $data = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('company_mou_peserta.mou_peserta_status', '<', 2)
                ->where('company_mou.company_mou_code', $request->code)
                ->orderBy('log_lokasi_pasien.id_log_lokasi_pasien', 'DESC')->get();
        } else {
            $data = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.mou_peserta_status', '<', 2)
                ->where('company_mou.company_mou_code', $request->code)
                ->orderBy('log_lokasi_pasien.id_log_lokasi_pasien', 'DESC')->get();
        }
        return view('application.menu.service.table-menu-service', ['data' => $data]);
    }
    public function menu_service_history(Request $request)
    {
        $data = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
            ->where('company_mou_peserta.mou_peserta_status', '=', 1)
            ->orderBy('log_lokasi_pasien.id_log_lokasi_pasien', 'DESC')->get();
        return view('application.menu.service.form-history-mcu', ['data' => $data]);
    }
    public function menu_service_proses(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        return view('application.menu.service.form-proses-pasien', ['data' => $data, 'pemeriksaan' => $pemeriksaan]);
    }
    public function menu_service_proses_update_status(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        return view('application.menu.service.form-proses-update', ['data' => $data, 'pemeriksaan' => $pemeriksaan]);
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
            'log_pengiriman_date' => $request->tanggal_kirim . ' ' . $request->time_kirim,
            'log_pengiriman_deskripsi' => $request->desc_pengiriman,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Update Pengiriman Hasil');
    }
    public function menu_service_proses_penyelesaian_peserta_mcu(Request $request)
    {
        DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->update([
            'mou_peserta_status' => 2
        ]);
        return 'sukses';
    }

    // MENU PENGIRIMAN
    public function menu_pengiriman($akses)
    {
        if ($this->url_akses($akses) == true) {
            $perusahaan = DB::table('master_company')->get();
            return view('application.menu.menu-pengiriman', [ 'perusahaan' => $perusahaan]);
        } else {
            return Redirect::to('dashboard/home');
        }
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
    public function master_company_edit_company(Request $request)
    {
        $data = DB::table('master_company')->where('master_company_code', $request->code)->first();
        return view('application.master-data.company.form-edit', ['data' => $data]);
    }
    public function master_company_edit_company_save(Request $request)
    {
        return redirect()->back()->withSuccess('Great! Berhasil update Data Perusahaan');
    }
    public function master_company_data_mou_company(Request $request)
    {
        $data = DB::table('company_mou')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.master_company_code', $request->code)
            ->orderBy('id_company_mou', 'DESC')->get();
        return view('application.master-data.company.data-mou-company', ['data' => $data]);
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
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    public function mou_company_insert_all_peserta_mcu_upload(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-upload-excel-all', ['code' => $request->code, 'data' => $data]);
    }
    public function mou_company_insert_all_peserta_mcu_upload_save(Request $request)
    {
        Excel::import(new PesertaAllImport($request->code), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
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
    public function mou_company_generetae_absesnsi_mcu(Request $request)
    {
        $cek = DB::table('company_mou_peserta_token_absensi')->where('company_mou_code', $request->code)->first();
        if ($cek) {
            return view('application.master-data.mou-company.form-generate-absensi', ['code' => $cek->company_mou_token_code]);
        } else {
            $code = $request->code . '-' . str::uuid();
            DB::table('company_mou_peserta_token_absensi')->insert([
                'company_mou_token_code' => $code,
                'company_mou_code' => $request->code,
                'company_mou_token_link' => $request->code,
                'company_mou_token_status' => 1,
                'created_at' => now()
            ]);
            return view('application.master-data.mou-company.form-generate-absensi', ['code' => $code]);
        }
    }
    public function mou_company_generetae_absesnsi_mcu_report(Request $request)
    {
        $data = DB::table('company_mou_peserta_token_absensi')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta_token_absensi.company_mou_code')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')->first();
        $image = base64_encode(file_get_contents(public_path('img/logo-pramita.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.master-data.mou-company.report.form-absensi-mcu', ['data' => $data], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        // $dompdf->get_canvas()->page_text(34, 820, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        return base64_encode($pdf->stream());
    }
    public function mou_company_sinkronisasi_nik_nip(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->get();
        foreach ($data as $value) {
            DB::table('company_mou_peserta')->where('mou_peserta_code', $value->mou_peserta_code)->update([
                'mou_peserta_nip' => $value->mou_peserta_nik
            ]);
        }
        return 'Sukses';
    }
    public function mou_company_update_peserta_mcu(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        return view('application.master-data.mou-company.form-update-peserta', ['data' => $data]);
    }
    public function mou_company_update_peserta_mcu_save(Request $request)
    {
        DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->update([
            'mou_peserta_nik' => $request->nik,
            'mou_peserta_nip' => $request->nip,
            'mou_peserta_name' => $request->name,
            'mou_peserta_no_hp' => $request->no_hp,
            'mou_peserta_email' => $request->email,
            'mou_peserta_ttl' => $request->ttl,
            'mou_peserta_jk' => $request->jk,
            'mou_peserta_departemen' => $request->departemen,
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Update Data Peserta');
    }
    public function mou_company_update_peserta_mcu_reset_signature(Request $request)
    {
        DB::table('log_kehadiran_pasien')->where('mou_peserta_code', $request->code)->update([
            'log_kehadiran_pasien_sign' => '-',
            'log_kehadiran_pasien_status' => 0,
        ]);
        return 'Berhasil Reset';
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
    public function agreement_perusahaan_update(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('mou_agreement_code', $request->code)->first();
        return view('application.master-data.agreement.form-update', ['data' => $data]);
    }
    public function agreement_perusahaan_update_save(Request $request)
    {
        DB::table('company_mou_agreement')->where('mou_agreement_code', $request->code)->update([
            'mou_agreement_name' => $request->nama,
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
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
    public function agreement_perusahaan_remove_agreement(Request $request)
    {
        DB::table('company_mou_agreement')->where('mou_agreement_code', $request->code)->delete();
        DB::table('company_mou_agreement_sub')->where('mou_agreement_code', $request->code)->delete();
        return 'Berhasil Remove';
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
    public function master_pemeriksaan_update(Request $request)
    {
        $data = DB::table('master_pemeriksaan')->where('master_pemeriksaan_code', $request->code)->first();
        return view('application.master-data.pemeriksaan.form-update', ['data' => $data]);
    }
    public function master_pemeriksaan_update_save(Request $request)
    {
        DB::table('master_pemeriksaan')->where('master_pemeriksaan_code', $request->code)->update([
            'master_pemeriksaan_name' => $request->nama
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
    public function master_access_mou_add(Request $request)
    {
        return view('application.master-data.mou-akses.form-add');
    }
    public function master_access_mou_save(Request $request)
    {
        DB::table('user_mains')->insert([
            'userid' => str::uuid(),
            'fullname' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request['password']),
            'number_handphone' => $request->no_hp,
            'email' => $request->email,
            'access_code' => '2070244a-4f32-4c81-956b-5dd394819b3b',
            'access_cabang' => 'ALL',
            'access_status' => 1,
            'remember_token' => str::uuid(),
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
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
    public function master_access_mou_remove_akses(Request $request)
    {
        return view('application.master-data.mou-akses.form-remove-akses', ['code' => $request->code]);
    }
    public function master_access_mou_remove_akses_save(Request $request)
    {
        DB::table('company_mou_access')->where('id_mou_access', $request->code)->delete();
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }

    // MASTER USER CABANG
    public function master_user_cabang($akses)
    {
        if ($this->url_akses($akses) == true) {
            $akses = DB::table('master_access')->where('master_access_name', '=', 'User Cabang')->first();
            $data = DB::table('user_mains')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'user_mains.access_cabang')
                ->where('user_mains.access_code', '=', $akses->master_access_code)->get();
            return view('application.master-data.master-user-cabang', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_user_cabang_add(Request $request)
    {
        $cabang = DB::table('master_cabang')->get();
        return view('application.master-data.user-cabang.fotm-add', ['cabang' => $cabang]);
    }
    public function master_user_cabang_save(Request $request)
    {
        $akses = DB::table('master_access')->where('master_access_name', '=', 'User Cabang')->first();
        DB::table('user_mains')->insert([
            'userid' => str::uuid(),
            'fullname' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request['password']),
            'number_handphone' => $request->no_hp,
            'email' => $request->email,
            'access_code' => $akses->master_access_code,
            'access_cabang' => $request->cabang,
            'access_status' => 1,
            'remember_token' => str::uuid(),
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data User Cabang');
    }
    public function master_user_cabang_update(Request $request)
    {
        $data = DB::table('user_mains')->where('userid', $request->code)->first();
        return view('application.master-data.user-cabang.form-update', ['data' => $data]);
    }
    public function master_user_cabang_update_save(Request $request)
    {
        if ($request->password == "") {
            DB::table('user_mains')->where('userid', $request->code)->update([
                'fullname' => $request->nama_lengkap,
                'email' => $request->email,
                'number_handphone' => $request->email,
                'username' => $request->username,
            ]);
        } else {
            DB::table('user_mains')->where('userid', $request->code)->update([
                'fullname' => $request->nama_lengkap,
                'email' => $request->email,
                'number_handphone' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request['password']),
            ]);
        }
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data User Cabang');
    }

    // MASTER GROUP CABANG
    public function master_group_cabang($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('group_cabang')->get();
            return view('application.master-data.master-group-cabang', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_group_cabang_add(Request $request)
    {
        return view('application.master-data.group-cabang.form-add');
    }
    public function master_group_cabang_save(Request $request)
    {
        DB::table('group_cabang')->insert([
            'group_cabang_code' => Str::uuid(),
            'group_cabang_name' => $request->nama_group,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data User Cabang');
    }
    public function master_group_cabang_update_group(Request $request)
    {
        $data = DB::table('group_cabang')->where('group_cabang_code', $request->code)->first();
        return view('application.master-data.group-cabang.form-update', ['data' => $data]);
    }
    public function master_group_cabang_save_group(Request $request)
    {
        DB::table('group_cabang')->where('group_cabang_code', $request->code)->update(['group_cabang_name' => $request->nama_group]);
        return redirect()->back()->withSuccess('Great! Berhasil update Data Wilayah');
    }
    public function master_group_cabang_add_cabang(Request $request)
    {
        $cabang = DB::table('master_cabang')->select('master_cabang_code', 'master_cabang_name')->get();
        return view('application.master-data.group-cabang.form-add-cabang', ['code' => $request->code, 'cabang' => $cabang]);
    }
    public function master_group_cabang_save_cabang(Request $request)
    {
        $cek = DB::table('group_cabang_detail')->where('master_cabang_code', $request->cabang)->first();
        if ($cek) {
            return redirect()->back()->withError('Failed! Cabang Sudah di dalam Group');
        } else {
            DB::table('group_cabang_detail')->insert([
                'group_cabang_code' => $request->code,
                'master_cabang_code' => $request->cabang,
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Group Cabang');
        }
    }
    public function master_group_cabang_remove_cabang(Request $request)
    {
        return view('application.master-data.group-cabang.form-remove-cabang', ['code' => $request->code]);
    }
    public function master_group_cabang_save_remove_cabang(Request $request)
    {
        DB::table('group_cabang_detail')->where('id_group_cabang_detail', $request->code)->delete();
        return redirect()->back()->withSuccess('Great! Berhasil menghapus Data Group Cabang');
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
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'master_cabang.master_cabang_code')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->where('company_mou_peserta.company_mou_code', $request->perusahaan)
            ->get()
            ->unique('lokasi_cabang');
        $totalpeserta = DB::table('company_mou_peserta')->where('company_mou_code', $request->perusahaan)->count();
        $totalmcu = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('company_mou_peserta.company_mou_code', $request->perusahaan)
            ->count();

        $group = DB::table('log_lokasi_pasien')
            ->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'log_lokasi_pasien.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'master_cabang.master_cabang_code')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->where('company_mou_peserta.company_mou_code', $request->perusahaan)
            ->get()->unique('group_cabang_code');
        return view('application.laporan.rekap-mcu.detail-rekap-mcu', [
            'data' => $data,
            'cabang' => $cabang,
            'cab' => $cab,
            'totalpeserta' => $totalpeserta,
            'totalmcu' => $totalmcu,
            'group' => $group,
        ]);
    }
    public function laporan_rekap_mcu_kehadiran_peserta_mcu(Request $request)
    {
        $group = DB::table('group_cabang')->get();
        return view('application.laporan.rekap-mcu.form-kehadiran-mcu', ['code' => $request->code, 'group' => $group]);
    }
    public function laporan_rekap_excel_mcu_kehadiran_peserta_mcu($id)
    {

        return Excel::download(new McuExport($id), 'Report_MCU' . $id . '.xlsx');
    }
    public function laporan_rekap_mcu_kehadiran_peserta_mcu_report(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo-pramita.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laporan.rekap-mcu.report.report-kehadiran', ['data' => $data, 'peserta' => $peserta], compact('image'))->setPaper('A4', 'landscape')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        return base64_encode($pdf->stream());
    }
    public function laporan_rekap_mcu_kehadiran_peserta_mcu_report_group(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->where('group_cabang_detail.group_cabang_code', $request->id)
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo-pramita.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laporan.rekap-mcu.report.report-kehadiran', ['data' => $data, 'peserta' => $peserta], compact('image'))->setPaper('A4', 'landscape')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        return base64_encode($pdf->stream());
    }
    public function laporan_rekap_mcu_kehadiran_peserta_mcu_export_data(Request $request)
    {
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $request->code)->get()->unique('master_pemeriksaan_code');
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.laporan.rekap-mcu.data-full-peserta-mcu', ['data' => $data, 'pem' => $pemeriksaan, 'peserta' => $peserta]);
    }
}
