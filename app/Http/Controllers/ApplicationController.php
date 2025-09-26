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
        return view('application.dashboard.monitoring.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta, 'code' => $request->code]);
    }
    public function monitoring_mcu_detail_table(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)->count();
        $totalRecordswithFilter = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')
            ->select('company_mou_peserta.*')
            ->orderBy('id_mou_peserta', $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $no = 1;
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $id)->get()->unique('master_pemeriksaan_code');
        foreach ($records as $record) {
            $id = $no++;
            $nip = $record->mou_peserta_nip;
            $nama_peserta = $record->mou_peserta_name;
            $nik = $record->mou_peserta_nik;
            $ttl = $record->mou_peserta_ttl;
            $jk = $record->mou_peserta_jk;
            $departemen = $record->mou_peserta_departemen;
            $pemeriksaan = DB::table('company_mou_agreement_sub')
                ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
                ->where('company_mou_agreement_sub.mou_agreement_code', $record->mou_agreement_code)
                ->get();
            $status = "";
            foreach ($pemeriksaan as $pem) {
                $check = DB::table('log_pemeriksaan_pasien')
                    ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                    ->where('mou_peserta_code', $record->mou_peserta_code)
                    ->first();
                if ($check) {
                    if ($check->log_pemeriksaan_status == 1) {
                        $status = $status . '<li>' . $pem->master_pemeriksaan_name . ' <span class="fas fa-check-square text-success" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa"></span></li>';
                    } else {
                        $status = $status . '<li>' . $pem->master_pemeriksaan_name . ' <span class="fas fa-exclamation-circle text-warning" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="' . $check->log_pemeriksaan_deskripsi . '"></span></li>';
                    }
                } else {
                    $status = $status . '<li>' . $pem->master_pemeriksaan_name . ' <span class="fas fa-window-close text-danger" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa"></span></li>';
                }
            }
            $data_arr[] = array(
                "id" => $id,
                "nip" => $nip,
                "nama_peserta" => $nama_peserta,
                "nik" => $nik,
                "ttl" => $ttl,
                "jk" => $jk,
                "departemen" => $departemen,
                "status" => $status,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
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
            ->where('company_mou_peserta.company_mou_code', $request->code)
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->get();
        $lokasi = DB::table('company_location')
            ->join('company_mou', 'company_mou.master_company_code', 'company_location.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->get();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.dashboard.monitoring.data-peserta-full-rekap', [
            'data' => $data,
            'pem' => $pemeriksaan,
            'peserta' => $peserta,
            'paket' => $paket,
            'lokasi' => $lokasi,
            'code' => $request->code
        ]);
    }
    public function monitoring_mcu_rekap_full_detail_paket(Request $request)
    {
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $request->code)
            ->where('company_mou_agreement.mou_agreement_code', $request->id)
            ->get()->unique('master_pemeriksaan_code');
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)
            ->where('company_mou_peserta.mou_agreement_code', $request->id)
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->get();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.dashboard.monitoring.table-monitoring-peserta-mcu', [
            'data' => $data,
            'pem' => $pemeriksaan,
            'peserta' => $peserta,
            'paket' => $paket,
        ]);
    }
    public function monitoring_mcu_rekap_full_detail_lokasi(Request $request)
    {
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $request->code_mou)
            ->get()->unique('master_pemeriksaan_code');
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->join('company_location_handle', 'company_location_handle.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('company_location', 'company_location.company_location_code', '=', 'company_location_handle.company_location_code')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->where('company_mou_peserta.company_mou_code', $request->code_mou)
            ->where('company_location.company_location_code', $request->code)
            ->get();

        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code_mou)->first();
        return view('application.dashboard.monitoring.table-monitoring-peserta-mcu', [
            'data' => $data,
            'pem' => $pemeriksaan,
            'peserta' => $peserta,
        ]);
    }
    public function monitoring_mcu_rekap_full_detail_peserta(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)->count();
        $totalRecordswithFilter = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')
            ->select('company_mou_peserta.*')
            ->orderBy('id_mou_peserta', $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $no = 1;
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $id)->get()->unique('master_pemeriksaan_code');
        foreach ($records as $record) {
            $id = $no++;
            $code_peserta = $record->mou_peserta_code;
            $nama_peserta = $record->mou_peserta_name;
            $nik = $record->mou_peserta_nik;
            $ttl = $record->mou_peserta_ttl;
            $jk = $record->mou_peserta_jk;
            $email = $record->mou_peserta_email;
            $no_hp = $record->mou_peserta_no_hp;
            $nip = $record->mou_peserta_nip;
            $lokasi = DB::table('log_lokasi_pasien')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
                ->where('log_lokasi_pasien.mou_peserta_code', $record->mou_peserta_code)->first();
            if ($lokasi) {
                $group = $lokasi->group_cabang_name;
                $cabang = $lokasi->master_cabang_name;
            } else {
                $group = "";
                $cabang = "";
            }
            foreach ($pemeriksaan as $value) {
                $status = DB::table('log_pemeriksaan_pasien')
                    ->where('mou_peserta_code', $record->mou_peserta_code)
                    ->where('master_pemeriksaan_code', $value->master_pemeriksaan_code)->first();
                if ($status) {
                    $check = '<span style="color: green;" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa">Y</span>';
                } else {
                    $check = '<span class="text-danger" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Diperiksa">X</span>';
                }
            }
            $sudah = '<span style="color: green;" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa">Y</span>';
            $belum = '<span class="text-danger" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Belum Diperiksa">X</span>';
            $notice = '<span class="text-warning" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="panding">!</span><span> : Panding</span>';
            $departemen = $record->mou_peserta_departemen;
            $paket = DB::table('company_mou_agreement')
                ->where('mou_agreement_code', $record->mou_agreement_code)
                ->first();
            if ($paket) {
                $packet = $paket->mou_agreement_name . '<br><button class="btn btn-warning btn-sm" id="button-pilih-paket-mcu" data-code="' . $record->mou_peserta_code . '"><span class="fas fa-undo"></span></button>';
            } else {
                $packet = '<button class="btn btn-danger btn-sm" id="button-pilih-paket-mcu" data-code="' . $record->mou_peserta_code . '">Pilih Paket</button>';
            }
            $log = DB::table('log_lokasi_pasien')
                ->select('log_lokasi_pasien.created_at', 'master_cabang.master_cabang_name')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->where('log_lokasi_pasien.mou_peserta_code', $record->mou_peserta_code)
                ->first();
            if ($log) {
                $lokasi = '<span class="text-primary">' . $log->master_cabang_name . '</span> <br>' . $log->created_at;
                $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary" id="btnGroupVerticalDrop2" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-mcu-xl" id="button-proses-update-peserta-mcu"
                                    data-code="' . $record->mou_peserta_code . '">
                                    <span class="fas fa-folder-plus"></span> Update Lokasi</button>
                            </div>
                        </div>';
            } else {
                $lokasi = '<span class="badge bg-danger">Belum Check in</span>';
                $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary" id="btnGroupVerticalDrop2" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-mcu-xl" id="button-proses-peserta-mcu"
                                    data-code="' . $record->mou_peserta_code . '">
                                    <span class="fas fa-folder-plus"></span> Proses MCU</button>
                            </div>
                        </div>';
            }

            // $ruangan = DB::table('tbl_nomor_ruangan_cabang')->where('id_nomor_ruangan_cbaang', $record->id_nomor_ruangan_cbaang)->first();
            // if ($ruangan) {
            //     $dataruangan = $ruangan->nomor_ruangan;
            //     if ($record->status_barang == 5) {
            //         $status_barang = '<span class="badge bg-danger p-2" style="font-size: 11px;">Musnah</span>';
            //         $button = "";
            //     } else if ($record->status_barang == 4) {
            //         $status_barang = '<span class="badge bg-warning p-2" style="font-size: 11px;">Mutasi</span>';
            //         $button = "";
            //     } else {
            //         $status_barang = '<span class="badge bg-success p-2" style="font-size: 11px;">Baik</span>';
            //         $button =  "<button class='btn-warning m-1' data-toggle='modal' data-target='#editmasterbarang' id='editbarangmaster' data-url=" . url('divisi/masterbarang/showedit', ['id' => $id_inventaris]) . "><i class='bx bx-pencil'></i> edit</button>
            //         <button class='btn-dark m-1' data-toggle='modal' data-target='#editmasterbarang' id='print-barcode-master-barang' data-url=" . url('printbarcodebyidinventaris', ['id' => $record->id]) . "><i class='bx bx-print'></i> Cetak Barcode</button>";
            //     };
            // } else {
            //     $dataruangan = '<span class="badge bg-danger p-2" style="font-size: 11px;">Tidak di temukan</span>';
            //     if ($record->status_barang == 5) {
            //         $status_barang = '<span class="badge bg-danger p-2" style="font-size: 11px;">Musnah</span>';
            //         $button = "";
            //     } else if ($record->status_barang == 4) {
            //         $status_barang = '<span class="badge bg-warning p-2" style="font-size: 11px;">Mutasi</span>';
            //         $button = "";
            //     } else {
            //         $status_barang = '<span class="badge bg-success p-2" style="font-size: 11px;">Baik</span>';
            //         $button = "<button class='btn-warning m-1' data-toggle='modal' data-target='#editmasterbarang' id='editbarangmaster' data-url=" . url('divisi/masterbarang/showedit', ['id' => $id_inventaris]) . "><i class='bx bx-pencil'></i> edit</button>";
            //     };
            // };
            $check_arr[] = array(
                'cheeek' => '<span style="color: green;" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Sudah Diperiksa">Y</span>'
            );
            $data_arr[] = array(
                "id" => $id,
                "code_peserta" => $code_peserta,
                "nama_peserta" => $nama_peserta,
                "nik" => $nik,
                "ttl" => $ttl,
                "jk" => $jk,
                "email" => $email,
                "no_hp" => $no_hp,
                "nip" => $nip,
                "check" => $check,
                "departemen" => $departemen,
                "paket" => $packet,
                "lokasi" => $lokasi,
                "button" => $button,
                "group" => $group,
                "cabang" => $cabang,
                "sudah" => $sudah,
                "belum" => $belum,
                "notice" => $notice,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
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
        return view('application.menu.mcu.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta, 'code' => $request->code]);
    }
    public function medical_check_up_detail_data(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)->count();
        $totalRecordswithFilter = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')
            ->select('company_mou_peserta.*')
            ->orderBy('id_mou_peserta', $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $no = 1;
        foreach ($records as $record) {
            $id = $no++;
            $nama_peserta = $record->mou_peserta_name;
            $nik = $record->mou_peserta_nik;
            $ttl = $record->mou_peserta_ttl;
            $jk = $record->mou_peserta_jk;
            $email = $record->mou_peserta_email;
            $no_hp = $record->mou_peserta_no_hp;
            $nip = $record->mou_peserta_nip;
            $departemen = $record->mou_peserta_departemen;
            $paket = DB::table('company_mou_agreement')
                ->where('mou_agreement_code', $record->mou_agreement_code)
                ->first();
            if ($paket) {
                $packet = $paket->mou_agreement_name . '<br><button class="btn btn-warning btn-sm" id="button-pilih-paket-mcu" data-code="' . $record->mou_peserta_code . '"><span class="fas fa-undo"></span></button>';
            } else {
                $packet = '<button class="btn btn-danger btn-sm" id="button-pilih-paket-mcu" data-code="' . $record->mou_peserta_code . '">Pilih Paket</button>';
            }
            $log = DB::table('log_lokasi_pasien')
                ->select('log_lokasi_pasien.created_at', 'master_cabang.master_cabang_name')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->where('log_lokasi_pasien.mou_peserta_code', $record->mou_peserta_code)
                ->first();
            if ($log) {
                $lokasi = '<span class="text-primary">' . $log->master_cabang_name . '</span> <br>' . $log->created_at;
                $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary" id="btnGroupVerticalDrop2" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-mcu-xl" id="button-proses-update-peserta-mcu"
                                    data-code="' . $record->mou_peserta_code . '">
                                    <span class="fas fa-folder-plus"></span> Update Lokasi</button>
                            </div>
                        </div>';
            } else {
                $lokasi = '<span class="badge bg-danger">Belum Check in</span>';
                $button = '<div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary" id="btnGroupVerticalDrop2" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modal-mcu-xl" id="button-proses-peserta-mcu"
                                    data-code="' . $record->mou_peserta_code . '">
                                    <span class="fas fa-folder-plus"></span> Proses MCU</button>
                            </div>
                        </div>';
            }

            // $ruangan = DB::table('tbl_nomor_ruangan_cabang')->where('id_nomor_ruangan_cbaang', $record->id_nomor_ruangan_cbaang)->first();
            // if ($ruangan) {
            //     $dataruangan = $ruangan->nomor_ruangan;
            //     if ($record->status_barang == 5) {
            //         $status_barang = '<span class="badge bg-danger p-2" style="font-size: 11px;">Musnah</span>';
            //         $button = "";
            //     } else if ($record->status_barang == 4) {
            //         $status_barang = '<span class="badge bg-warning p-2" style="font-size: 11px;">Mutasi</span>';
            //         $button = "";
            //     } else {
            //         $status_barang = '<span class="badge bg-success p-2" style="font-size: 11px;">Baik</span>';
            //         $button =  "<button class='btn-warning m-1' data-toggle='modal' data-target='#editmasterbarang' id='editbarangmaster' data-url=" . url('divisi/masterbarang/showedit', ['id' => $id_inventaris]) . "><i class='bx bx-pencil'></i> edit</button>
            //         <button class='btn-dark m-1' data-toggle='modal' data-target='#editmasterbarang' id='print-barcode-master-barang' data-url=" . url('printbarcodebyidinventaris', ['id' => $record->id]) . "><i class='bx bx-print'></i> Cetak Barcode</button>";
            //     };
            // } else {
            //     $dataruangan = '<span class="badge bg-danger p-2" style="font-size: 11px;">Tidak di temukan</span>';
            //     if ($record->status_barang == 5) {
            //         $status_barang = '<span class="badge bg-danger p-2" style="font-size: 11px;">Musnah</span>';
            //         $button = "";
            //     } else if ($record->status_barang == 4) {
            //         $status_barang = '<span class="badge bg-warning p-2" style="font-size: 11px;">Mutasi</span>';
            //         $button = "";
            //     } else {
            //         $status_barang = '<span class="badge bg-success p-2" style="font-size: 11px;">Baik</span>';
            //         $button = "<button class='btn-warning m-1' data-toggle='modal' data-target='#editmasterbarang' id='editbarangmaster' data-url=" . url('divisi/masterbarang/showedit', ['id' => $id_inventaris]) . "><i class='bx bx-pencil'></i> edit</button>";
            //     };
            // };
            $data_arr[] = array(
                "id" => $id,
                "nama_peserta" => $nama_peserta,
                "nik" => $nik,
                "ttl" => $ttl,
                "jk" => $jk,
                "email" => $email,
                "no_hp" => $no_hp,
                "nip" => $nip,
                "departemen" => $departemen,
                "paket" => $packet,
                "lokasi" => $lokasi,
                "button" => $button,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        // exit;
    }
    public function medical_check_up_add_pesertal(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.menu.service.form-add-peserta', ['code' => $request->code, 'data' => $data]);
    }
    public function medical_check_up_data_mointoring_all_peserta(Request $request)
    {
        return view('application.menu.mcu.form-monitoring-all-peserta', ['code' => $request->code]);
    }
    public function medical_check_up_data_mointoring_all_peserta_table(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $id)->count();
        $totalRecordswithFilter = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')
            // ->orWhere('company_mou_peserta.mou_peserta_departemen', 'like', '%' . $searchValue . '%')
            // ->orWhere('company_mou_peserta.mou_peserta_nip', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')
            // ->orWhere('company_mou_peserta.mou_peserta_departemen', 'like', '%' . $searchValue . '%')
            // ->orWhere('company_mou_peserta.mou_peserta_nip', 'like', '%' . $searchValue . '%')
            ->select('company_mou_peserta.*')
            ->orderBy('id_mou_peserta', $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        // dd($records);
        $data_arr = array();
        $no = 1;
        foreach ($records as $record) {
            $id = $no++;
            $nama_peserta = $record->mou_peserta_name;
            $nik = $record->mou_peserta_nik;
            $ttl = $record->mou_peserta_ttl;
            $jk = $record->mou_peserta_jk;
            $email = $record->mou_peserta_email;
            $no_hp = $record->mou_peserta_no_hp;
            $nip = $record->mou_peserta_nip;
            $departemen = $record->mou_peserta_departemen;


            $log = DB::table('log_lokasi_pasien')
                ->select('log_lokasi_pasien.created_at', 'master_cabang.master_cabang_name')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->where('log_lokasi_pasien.mou_peserta_code', $record->mou_peserta_code)
                ->first();
            if ($log) {
                $lokasi = '<span class="text-primary">' . $log->master_cabang_name . '</span> <br>' . $log->created_at;

            } else {
                $lokasi = '<span class="badge bg-danger">Belum Check in</span>';

            }
            $ttd = DB::table('log_kehadiran_pasien')
                ->where('mou_peserta_code', $record->mou_peserta_code)
                ->where('log_kehadiran_pasien_status', 1)
                ->first();

            $data_arr[] = array(
                "id" => $id,
                "nama_peserta" => $nama_peserta,
                "nik" => $nik,
                "ttl" => $ttl,
                "jk" => $jk,
                "email" => $email,
                "no_hp" => $no_hp,
                "nip" => $nip,
                "departemen" => $departemen,
                "lokasi" => $lokasi,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
    }
    public function medical_check_up_data_mointoring_peserta(Request $request)
    {
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $request->code)->get()->unique('master_pemeriksaan_code');
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)->get();
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.menu.mcu.form-monitoring-mcu', ['data' => $data, 'pem' => $pemeriksaan, 'peserta' => $peserta]);
    }
    public function medical_check_up_prosess(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        $cabang = DB::table('master_cabang')->get();
        $pemeriksaan1 = DB::table('company_mou_agreement_user')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_user.master_pemeriksaan_code')
            ->where('company_mou_agreement_user.mou_peserta_code', $request->code)->get();
        return view('application.menu.mcu.form-proses-mcu', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'cabang' => $cabang, 'pemeriksaan1' => $pemeriksaan1]);
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
    public function medical_check_up_prosess_tambah_pemeriksaan(Request $request)
    {
        $data = DB::table('master_pemeriksaan')->get();
        return view('application.menu.mcu.form-add-pemeriksaan', ['data' => $data, 'code' => $request->code, 'mou' => $request->mou]);
    }
    public function medical_check_up_prosess_tambah_pemeriksaan_save(Request $request)
    {
        DB::table('company_mou_agreement_user')->insert([
            'mou_agreement_user_code' => str::uuid(),
            'mou_peserta_code' => $request->peserta_code,
            'master_pemeriksaan_code' => $request->pemeriksaan,
        ]);
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->peserta_code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        $pemeriksaan1 = DB::table('company_mou_agreement_user')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_user.master_pemeriksaan_code')
            ->where('company_mou_agreement_user.mou_peserta_code', $request->peserta_code)->get();
        return view('application.menu.mcu.table-list-pemeriksaan-mcu', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'pemeriksaan1' => $pemeriksaan1]);
    }
    public function medical_check_up_prosess_tambah_pemeriksaan_remove(Request $request)
    {
        DB::table('company_mou_agreement_user')->where('mou_peserta_code', $request->code)->where('master_pemeriksaan_code', $request->pem)->delete();
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $pemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $data->mou_agreement_code)->get();
        $pemeriksaan1 = DB::table('company_mou_agreement_user')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_user.master_pemeriksaan_code')
            ->where('company_mou_agreement_user.mou_peserta_code', $request->code)->get();
        return view('application.menu.mcu.table-list-pemeriksaan-mcu', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'pemeriksaan1' => $pemeriksaan1]);
    }
    public function medical_check_up_preview_cetak_absensi(Request $request)
    {
        return view('application.menu.mcu.form-preview-data-absensi', ['code' => $request->code]);
    }
    public function medical_check_up_preview_cetak_absensi_table(Request $request, $id)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
            ->where('company_mou_peserta.company_mou_code', $id)->count();
        $totalRecordswithFilter = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
            ->where('company_mou_peserta.company_mou_code', $id)
            ->where('company_mou_peserta.mou_peserta_name', 'like', '%' . $searchValue . '%')
            ->select('company_mou_peserta.*')
            ->orderBy('id_log_lokasi_pasien', $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        $no = 1;
        foreach ($records as $record) {
            $id = $no++;
            $nama_peserta = $record->mou_peserta_name;
            $nik = $record->mou_peserta_nik;
            $ttl = $record->mou_peserta_ttl;
            $jk = $record->mou_peserta_jk;
            $email = $record->mou_peserta_email;
            $no_hp = $record->mou_peserta_no_hp;
            $nip = $record->mou_peserta_nip;
            $departemen = $record->mou_peserta_departemen;

            $paket = DB::table('company_mou_agreement')
                ->where('mou_agreement_code', $record->mou_agreement_code)
                ->first();
            if ($paket) {
                $packet = $paket->mou_agreement_name . '<br><button class="btn btn-warning btn-sm" id="button-pilih-paket-mcu" data-code="' . $record->mou_peserta_code . '"><span class="fas fa-undo"></span></button>';
            } else {
                $packet = '<button class="btn btn-danger btn-sm" id="button-pilih-paket-mcu" data-code="' . $record->mou_peserta_code . '">Pilih Paket</button>';
            }
            $log = DB::table('log_lokasi_pasien')
                ->select('log_lokasi_pasien.created_at', 'master_cabang.master_cabang_name')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->where('log_lokasi_pasien.mou_peserta_code', $record->mou_peserta_code)
                ->first();
            if ($log) {
                $lokasi = '<span class="text-primary">' . $log->master_cabang_name . '</span> <br>' . $log->created_at;

            } else {
                $lokasi = '<span class="badge bg-danger">Belum Check in</span>';

            }
            $ttd = DB::table('log_kehadiran_pasien')
                ->where('mou_peserta_code', $record->mou_peserta_code)
                ->where('log_kehadiran_pasien_status', 1)
                ->first();
            if ($ttd) {
                $ttd = '<img src=' . $ttd->log_kehadiran_pasien_sign . ' width="100"> <br>' . $ttd->log_kehadiran_pasien_time;
            } else {
                $ttd = 'Belum';
            }
            $data_arr[] = array(
                "id" => $id,
                "nama_peserta" => $nama_peserta,
                "nik" => $nik,
                "ttl" => $ttl,
                "jk" => $jk,
                "email" => $email,
                "no_hp" => $no_hp,
                "nip" => $nip,
                "departemen" => $departemen,
                "paket" => $packet,
                "lokasi" => $lokasi,
                "ttd" => $ttd,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
    }
    public function medical_check_up_prosess_cetak_absensi(Request $request)
    {
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
            ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
            ->where('company_mou_peserta.company_mou_code', $request->code)->count();
        return view('application.menu.mcu.form-report-absensi-mcu', ['code' => $request['code'], 'peserta' => $peserta]);
    }
    public function medical_check_up_prosess_cetak_absensi_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        if ($request->page == 'all') {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)->get();
            $no = 1;
        } elseif ($request->page == 1) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(0)->limit(100)->get();
            $no = 0;
        } elseif ($request->page == 2) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(100)->limit(100)->get();
        } elseif ($request->page == 3) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(200)->limit(100)->get();
        } elseif ($request->page == 4) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(300)->limit(100)->get();
        } elseif ($request->page == 5) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(400)->limit(100)->get();
        } elseif ($request->page == 6) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(500)->limit(100)->get();
        } elseif ($request->page == 7) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(600)->limit(100)->get();
        } elseif ($request->page == 8) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(700)->limit(100)->get();
        } elseif ($request->page == 9) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(800)->limit(100)->get();
        } elseif ($request->page == 10) {
            $peserta = DB::table('company_mou_peserta')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
                ->join('log_lokasi_pasien', 'log_lokasi_pasien.mou_peserta_code', '=', 'company_mou_peserta.mou_peserta_code')
                ->where('log_lokasi_pasien.lokasi_cabang', Auth::user()->access_cabang)
                ->where('company_mou_peserta.company_mou_code', $request->code)
                ->offset(900)->limit(100)->get();
        }
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
    public function medical_check_up_prosess_update_paket_mcu(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->first();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $data->company_mou_code)->get();
        return view('application.menu.mcu.form-update-paket-mcu', ['data' => $data, 'paket' => $paket]);
    }
    public function medical_check_up_prosess_update_paket_mcu_save(Request $request)
    {
        DB::table('company_mou_peserta')->where('mou_peserta_code', $request->code)->update([
            'mou_agreement_code' => $request->paket
        ]);
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
                    ->where('company_mou_peserta.mou_peserta_status', '<', 0)
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
        $perusahaan = DB::table('company_mou')->where('company_mou_code', $request->code)->first();
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
        return view('application.menu.service.table-menu-service', ['data' => $data, 'perusahaan' => $perusahaan]);
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
        $pemeriksaan1 = DB::table('company_mou_agreement_user')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_user.master_pemeriksaan_code')
            ->where('company_mou_agreement_user.mou_peserta_code', $request->code)->get();
        return view('application.menu.service.form-proses-update', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'pemeriksaan1' => $pemeriksaan1]);
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
            return view('application.menu.menu-pengiriman', ['perusahaan' => $perusahaan]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_pengiriman_pilih_perusahaan(Request $request)
    {
        $data = DB::table('company_mou')->where('master_company_code', $request->code)->get();
        return view('application.menu.pengiriman.option-project', ['data' => $data]);
    }
    public function menu_pengiriman_pilih_project(Request $request)
    {
        $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->get();
        return view('application.menu.pengiriman.option-peserta', ['data' => $data]);
    }
    public function menu_pengiriman_send_project(Request $request)
    {
        // METODE EMAIL
        if ($request->metode == 'mail') {
            if ($request->pilihan == 'all') {
                $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->dataproject)->get();
                foreach ($data as $value) {
                    DB::table('h_log_mail')->insert([
                        'h_log_mail_code' => str::uuid(),
                        'h_log_mail_address' => $value->mou_peserta_email,
                        'h_log_mail_userid' => $value->mou_peserta_code,
                        'h_log_mail_subject' => $request->subject,
                        'h_log_mail_name' => $value->mou_peserta_name,
                        'h_log_mail_messages' => $request->pesan,
                        'h_log_mail_status' => 0,
                        'h_log_mail_cabang' => Auth::user()->access_cabang,
                        'created_at' => now()
                    ]);
                }
            } elseif ($request->pilihan == 'single') {
                $data = $request->peserta;
                for ($i = 0; $i < count($data); $i++) {
                    $user = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->peserta[$i])->first();
                    if ($user) {
                        DB::table('h_log_mail')->insert([
                            'h_log_mail_code' => str::uuid(),
                            'h_log_mail_address' => $user->mou_peserta_email,
                            'h_log_mail_userid' => $user->mou_peserta_code,
                            'h_log_mail_subject' => $request->subject,
                            'h_log_mail_name' => $user->mou_peserta_name,
                            'h_log_mail_messages' => $request->pesan,
                            'h_log_mail_status' => 0,
                            'h_log_mail_cabang' => Auth::user()->access_cabang,
                            'created_at' => now()
                        ]);
                    }
                }
            }
        } elseif ($request->metode == 'whatsapp') {
            $data = $request->peserta;
            for ($i = 0; $i < count($data); $i++) {
                $user = DB::table('company_mou_peserta')->where('mou_peserta_code', $request->peserta[$i])->first();
                if ($user) {
                    $nomorhp = $user->mou_peserta_no_hp;
                    //Terlebih dahulu kita trim dl
                    $nomorhp = trim($nomorhp);
                    //bersihkan dari karakter yang tidak perlu
                    $nomorhp = strip_tags($nomorhp);
                    // Berishkan dari spasi
                    $nomorhp = str_replace(" ", "", $nomorhp);
                    // Berishkan dari -
                    $nomorhp = str_replace("-", "", $nomorhp);
                    // bersihkan dari bentuk seperti  (022) 66677788
                    $nomorhp = str_replace("(", "", $nomorhp);
                    // bersihkan dari format yang ada titik seperti 0811.222.333.4
                    $nomorhp = str_replace(".", "", $nomorhp);

                    if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
                        // cek apakah no hp karakter 1-3 adalah +62
                        if (substr(trim($nomorhp), 0, 3) == '+62') {
                            $nomorhp = trim($nomorhp);
                        }
                        // cek apakah no hp karakter 1 adalah 0
                        elseif (substr($nomorhp, 0, 1) == '0') {
                            $nomorhp = '+62' . substr($nomorhp, 1);
                        }
                    }
                    $text = "Hi *" . $user->mou_peserta_name . "* \nSelamat Anda Terdaftar Sebagai Peserta MCU\n\n" . $request->pesan_wa . "\n\nSupport By. Pramita Lab";
                    DB::table('h_log_whatsapp')->insert([
                        'h_log_whatsapp_code' => str::uuid(),
                        'h_log_whatsapp_number' => $nomorhp,
                        'h_log_whatsapp_userid' => $user->mou_peserta_code,
                        'h_log_whatsapp_name' => $user->mou_peserta_name,
                        'h_log_whatsapp_text' => $text,
                        'h_log_whatsapp_status' => 0,
                        'h_log_whatsapp_cabang' => Auth::user()->access_cabang,
                        'created_at' => now()
                    ]);
                }
            }
        }
    }
    public function menu_pengiriman_history_email(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('h_log_mail')->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'h_log_mail.h_log_mail_userid')->get();
        } else {
            $data = DB::table('h_log_mail')->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'h_log_mail.h_log_mail_userid')
                ->where('h_log_mail.h_log_mail_cabang', Auth::user()->access_cabang)->get();
        }
        return view('application.menu.pengiriman.data-pengiriman-email', ['data' => $data]);
    }
    public function menu_pengiriman_history_whatsapp(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('h_log_whatsapp')->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'h_log_whatsapp.h_log_whatsapp_userid')->get();
        } else {
            $data = DB::table('h_log_whatsapp')->join('company_mou_peserta', 'company_mou_peserta.mou_peserta_code', '=', 'h_log_whatsapp.h_log_whatsapp_userid')
                ->where('h_log_whatsapp.h_log_whatsapp_cabang', Auth::user()->access_cabang)->get();
        }
        return view('application.menu.pengiriman.data-pengiriman-whatsapp', ['data' => $data]);
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
        DB::table('master_company')->where('master_company_code', $request->code)->update([
            'master_company_name' => $request->name,
            'master_company_wilayah' => $request->lokasi,
            'master_company_nat' => 0,
            'master_company_type' => $request->type,
            'master_company_phone' => $request->phone,
            'master_company_email' => $request->email,
        ]);
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
    public function master_company_data_location_company(Request $request)
    {
        $data = DB::table('company_location')->where('master_company_code', $request->code)->get();
        return view('application.master-data.company.data-location-company', ['code' => $request->code, 'data' => $data]);
    }
    public function master_company_data_location_company_add(Request $request)
    {
        return view('application.master-data.company.form-add-location', ['code' => $request->code]);
    }
    public function master_company_data_location_company_save(Request $request)
    {
        DB::table('company_location')->insert([
            'company_location_code' => str::uuid(),
            'master_company_code' => $request->code,
            'company_location_name' => $request->name,
            'company_location_alamat' => $request->alamat,
            'company_location_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Lokasi Perusahaan');
    }
    public function master_company_data_location_company_add_handle(Request $request)
    {
        $data = DB::table('master_cabang')->get();
        return view('application.master-data.company.form-add-handle-cabang', ['code' => $request->code, 'data' => $data]);
    }
    public function master_company_data_location_company_save_handle(Request $request)
    {
        DB::table('company_location_handle')->insert([
            'company_location_code' => $request->code,
            'master_cabang_code' => $request->cabang,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Handle Cabang');
    }
    public function master_company_data_location_company_remove_handle(Request $requestq)
    {
        DB::table('company_location_handle')->where('id_company_location_handle', $requestq->code)->delete();
        return 123;
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
    public function mou_company_update(Request $request)
    {
        $data = DB::table('company_mou')->where('company_mou_code', $request->code)->first();
        return view('application.master-data.mou-company.form-update', ['data' => $data]);
    }
    public function mou_company_update_save(Request $request)
    {
        DB::table('company_mou')->where('company_mou_code', $request->code)->update([
            'company_mou_name' => $request->nama,
            'company_mou_peserta' => $request->peserta,
            'company_mou_start' => $request->start,
            'company_mou_end' => $request->end,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Update Data MOU Perusahaan');
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
    public function mou_company_non_activasi_mou(Request $request)
    {
        return view('application.master-data.mou-company.form-activasi-non', ['code' => $request->code]);
    }
    public function mou_company_non_activasi_mou_save(Request $request)
    {
        $peserta = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->first();
        if ($peserta || $paket) {
            DB::table('company_mou')->where('company_mou_code', $request->code)->update([
                'company_mou_status' => 0
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
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou_peserta_token_absensi.company_mou_token_code', $request->code)->first();
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
    public function mou_company_setup_paket_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('company_mou_agreement')
                    ->whereColumn('company_mou_agreement.mou_agreement_code', 'company_mou_peserta.mou_agreement_code');
            })->where('company_mou_peserta.company_mou_code', $request->code)->get();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-setup-paket', [
            'data' => $data,
            'peserta' => $peserta,
            'paket' => $paket,
            'code' => $request->code
        ]);
    }
    public function mou_company_setup_paket_mcu_adjust(Request $request)
    {
        $peserta = DB::table('company_mou_peserta')
            ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('company_mou_agreement')
                    ->whereColumn('company_mou_agreement.mou_agreement_code', 'company_mou_peserta.mou_agreement_code');
            })->where('company_mou_peserta.company_mou_code', $request->code)->get();
        foreach ($peserta as $value) {
            DB::table('company_mou_peserta')->where('mou_peserta_code', $value->mou_peserta_code)->update([
                'mou_agreement_code' => $request->paket
            ]);
        }
        return 123;
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
