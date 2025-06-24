<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    public function fisrt(){
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
                ->withSuccess('Kamu Berhasil Masuk di Halaman '.Auth::user()->fullname);
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
    public function confrim_user(){
        return view('auth.confrim-page');
    }
    public function register_status(){
        return view('auth.register_status');
    }
    public function forget_password(){
        return view('auth.forget_password');
    }

    public function logout()
    {

        Session::flush();

        Auth::logout();

        return Redirect('/');

    }

}
