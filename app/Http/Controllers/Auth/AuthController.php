<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function fisrt()
    {
        return view('index');
    }

    public function index()
    {
        if (Auth::check()) {

            return Redirect('dashboard/home');
        } else {
            return view('auth.login');
        }
    }
    public function masrketing_login()
    {
        if (Auth::check()) {

            return Redirect('marketing/dashboard/home');
        } else {
            return view('auth.login_marketing');
        }
    }

    public function registration()
    {

        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->access_status == 0) {
                Auth::logout();
                return redirect()->intended('login')
                    ->withError('Gagal Login');
            } else {
                return redirect()->intended('dashboard/home')
                    ->withSuccess('Kamu Berhasil Masuk di Halaman ' . Auth::user()->fullname);
            }
        }
        return redirect("login")->withError('Username dan Password Tidak Sinkron Mohon Untuk Mengingat Kembali');
    }

    public function postRegistration(Request $request)
    {

        $request->validate([
            'fullname' => 'required',
            'no_hp' => 'required',
            'username' => 'required|unique:user_mains',
            'email' => 'required|unique:user_mains',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        return redirect("confrim_user")->withSuccess('Great! You have Successfully loggedin');
    }

    // public function dashboard()
    // {

    //     if (Auth::check()) {

    //         return view('dashboard');

    //     }
    //     return redirect("login")->withSuccess('Opps! You do not have access');

    // }


    public function create(array $data)
    {

        return UserMain::create([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'number_handphone' => $data['no_hp'],
            'email' => $data['email'],
            'access_code' => 'user',
            'access_status' => '0',
            'remember_token' => Str::random(10),
            'password' => Hash::make($data['password']),

        ]);
    }
    public function confrim_user()
    {
        return view('auth.confrim-page');
    }
    public function register_status()
    {
        return view('auth.register_status');
    }
    public function forget_password()
    {
        return view('auth.forget_password');
    }

    public function logout()
    {

        Session::flush();

        Auth::logout();

        return Redirect('/');
    }
    public function verifikasi_Login(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->access_status == 0) {
                Auth::logout();
                return '<div class="alert alert-warning alert-dismissible fade show my-2" role="alert"> <strong>Warning !</strong> Bermasalah Pada Akun Anda <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
                // return redirect()->intended('register_status')
                //     ->withSuccess('Gagal Login');
            } else {
                // return redirect()->intended('dashboard/home')
                //     ->withSuccess('Kamu Berhasil Masuk di Halaman ' . Auth::user()->fullname);
                return '<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                                            <strong>Greate!</strong> Selamat Datang ' . Auth::user()->fullname . '.
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <script>window.location.href = "' . route('dashboard.home') . '";</script>
                                        </div>';
            }
        }
        return '<div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                                            <strong>Error!</strong> Username Dan Password Ada Kesalahan.
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
    }
    public function verifikasi_masrketing_login(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->access_status == 0) {
                Auth::logout();
                return '<div class="alert alert-warning alert-dismissible fade show my-2" role="alert"> <strong>Warning !</strong> Bermasalah Pada Akun Anda <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
            } else {
                if (Auth::user()->access_login == 'mkt') {
                    return '<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                                                <strong>Greate!</strong> Selamat Datang ' . Auth::user()->fullname . '.
                                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <script>window.location.href = "' . route('marekitng.dashboard.home') . '";</script>
                                            </div>';
                } else {
                    Auth::logout();
                    return '<div class="alert alert-warning alert-dismissible fade show my-2" role="alert"> <strong>Warning !</strong> Bermasalah Pada Akun Anda <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
                }
            }
        }
        return '<div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                                            <strong>Error!</strong> Username Dan Password Ada Kesalahan.
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
    }
    public function kirimOtp(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);

        // Cek apakah user / email terdaftar di database (sesuaikan nama tabel/kolom Anda)
        $user = DB::table('users') // atau tabel user Anda, cth: z_menu_user / tbl_user
            ->where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau e-mail tidak didaftarkan dalam sistem.'
            ], 404);
        }

        // Generate 6 digit kode OTP random
        $otp = rand(100000, 999999);

        // Simpan OTP ke database (buat kolom otp & otp_expired di tabel user, atau tabel khusus reset)
        DB::table('users')
            ->where('id', $user->id) // sesuaikan primary key tabel
            ->update([
                'otp' => $otp,
                'otp_expired' => now()->addMinutes(10) // OTP berlaku 10 menit
            ]);

        // [OPSIONAL] Kirim OTP via Email / WhatsApp API
        /*
        Mail::raw("Kod OTP pemulihan akaun anda ialah: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Kod Pengesahan OTP Lupa Password');
        });
        */

        // Untuk keperluan development/testing, kita return sukses (di production, jangan tampilkan OTP di response JSON)
        return response()->json([
            'status' => 'success',
            'message' => 'Kode OTP berhasil dikirim.',
            'debug_otp' => $otp // Hapus baris ini saat sudah live/production
        ]);
    }

    // 2. Proses Verifikasi OTP & Reset Password Baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'otp' => 'required|numeric',
            'password' => 'required|min:6',
        ]);

        // Cari user berdasarkan username/email dan OTP yang cocok
        $user = DB::table('users')
            ->where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pengguna tidak sah.'
            ], 400);
        }

        // Validasi kecocokan OTP dan masa aktif (jika menggunakan database)
        if ($user->otp != $request->otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode OTP yang Anda masukkan salah!'
            ], 400);
        }

        // Cek kadaluarsa OTP (opsional)
        if (now()->greaterThan($user->otp_expired)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode OTP sudah luput (kadaluarsa). Sila minta kod baru.'
            ], 400);
        }

        // Update password baru dan kosongkan kembali kolom OTP
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password),
                'otp' => null,
                'otp_expired' => null
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password baru berhasil disimpan.'
        ]);
    }
}
