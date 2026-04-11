<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\McuExport;
use App\Exports\PesertaMcuExport;
use App\Imports\PesertaAllImport;
use App\Imports\PesertaImport;
use App\Imports\TestImport;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Stmt\TryCatch;

class GatewayController extends Controller
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
    public function gateway_pengiriman_notifikasi($akses)
    {
        if ($this->url_akses($akses) == true) {
            $penerima = DB::table('gateway_penerima')->where('gateway_penerima_cabang', Auth::user()->access_cabang)->count();
            $jadwal = DB::table('gateway_jadwal')->where('gateway_jadwal_cabang', Auth::user()->access_cabang)->get();
            return view('gateway.pengiriman-notifikasi', ['penerima' => $penerima, 'jadwal' => $jadwal]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function gateway_pengiriman_notifikasi_add_penerima(Request $request)
    {
        return view('gateway.pengiriman-notifikasi.form-add-penerima');
    }
    public function gateway_pengiriman_notifikasi_save_penerima(Request $request)
    {
        try {
            $nomorhp = $request->no_hp;
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
            DB::table('gateway_penerima')->insert([
                'gateway_penerima_code' => str::uuid(),
                'gateway_penerima_name' => $request->nama_lengkap,
                'gateway_penerima_no_hp' => $nomorhp,
                'gateway_penerima_jk' => $request->jk,
                'gateway_penerima_cabang' => Auth::user()->access_cabang,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function gateway_pengiriman_notifikasi_data_penerima(Request $request)
    {
        $data = DB::table('gateway_penerima')->where('gateway_penerima_cabang', Auth::user()->access_cabang)->get();
        return view('gateway.pengiriman-notifikasi.form-data-penerima', compact('data'));
    }
    public function gateway_pengiriman_notifikasi_add_aktifitas(Request $request)
    {
        return view('gateway.pengiriman-notifikasi.form-add-aktifitas');
    }
    public function gateway_pengiriman_notifikasi_save_aktifitas(Request $request)
    {
        try {
            DB::table('gateway_jadwal')->insert([
                'gateway_jadwal_code' => str::uuid(),
                'gateway_jadwal_date' => $request->tgl_aktifitas,
                'gateway_jadwal_time' => $request->time_aktifitas,
                'gateway_jadwal_type' => $request->type_send,
                'gateway_jadwal_pesan' => $request->pesan,
                'gateway_jadwal_cabang' => Auth::user()->access_cabang,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function gateway_pengiriman_notifikasi_proses_aktifitas(Request $request)
    {
        $cek = DB::table('gateway_jadwal')
            ->where('gateway_jadwal_cabang', Auth::user()->access_cabang)
            ->where('gateway_jadwal_time', 'LIKE', '%' . date('H:i') . '%')
            ->get();
        $log = "";
        if ($cek->isEmpty()) {
            return 'Belum Ada Jadwal Jam Segini - ' . now() . ' waktu ' . date('H:i');
        } else {
            foreach ($cek as $value) {
                $user = DB::table('gateway_penerima')->where('gateway_penerima_cabang', Auth::user()->access_cabang)->get();
                foreach ($user as $users) {
                    $jadwal = DB::table('gateway_log')
                        ->where('gateway_log_penerima', $users->gateway_penerima_code)
                        ->where('gateway_log_cabang', Auth::user()->access_cabang)
                        ->where('gateway_jadwal_code', $value->gateway_jadwal_code)
                        ->where('gateway_log_date', $value->gateway_jadwal_date)
                        ->where('gateway_log_time', $value->gateway_jadwal_time)
                        ->first();
                    if ($jadwal) {
                    } else {
                        if ($users->gateway_penerima_jk == 'L') {
                            $text = "Halo Mr. " . $users->gateway_penerima_name . "\n\n" . $value->gateway_jadwal_pesan;
                        } else {
                            $text = "Halo Ms. " . $users->gateway_penerima_name . "\n\n" . $value->gateway_jadwal_pesan;
                        }
                        DB::table('gateway_sender')->insert([
                            'gateway_sender_code' => str::uuid(),
                            'gateway_sender_name' => $users->gateway_penerima_name,
                            'gateway_sender_no_hp' => $users->gateway_penerima_no_hp,
                            'gateway_sender_text' => $text,
                            'gateway_sender_cabang' => Auth::user()->access_cabang,
                            'gateway_sender_status' => 0,
                            'created_at' => now()
                        ]);
                        DB::table('gateway_log')->insert([
                            'gateway_log_code' => str::uuid(),
                            'gateway_log_cabang' => Auth::user()->access_cabang,
                            'gateway_log_penerima' => $users->gateway_penerima_code,
                            'gateway_jadwal_code' => $value->gateway_jadwal_code,
                            'gateway_log_date' => $value->gateway_jadwal_date,
                            'gateway_log_time' => $value->gateway_jadwal_time,
                            'created_at' => now()
                        ]);
                        $log = $log . "\n" . $users->gateway_penerima_name;
                    }
                }
            }
            if ($log == "") {
                return 'Pengecekan Jadwal Notifikasi - ' . now();
            } else {
                return "Membuat Token atas Nama \n" . $log;
            }
        }
    }
}
