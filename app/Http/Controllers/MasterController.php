<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function master_access()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('master_access')->get();
            return view('master.master-access', ['data' => $data]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_access_add()
    {
        if (Auth::user()->access_code == 'master') {
            return view('master.access.form-add');
        } else {
            return view('application.error.404');
        }
    }
    public function master_access_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            DB::table('master_access')->insert([
                'master_access_code' => str::uuid(),
                'master_access_name' => $request->name,
                'master_access_status' => 'Y',
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
    public function master_user()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('user_mains')
                ->join('master_access', 'master_access.master_access_code', '=', 'user_mains.access_code')
                ->get();
            return view('master.master-user', ['data' => $data]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_user_add(Request $request)
    {
        $cabang = DB::table('master_cabang')->get();
        $access = DB::table('master_access')->get();
        return view('master.master-user.form-add', ['cabang' => $cabang, 'access' => $access]);
    }
    public function master_user_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            DB::table('user_mains')->insert([
                'userid' => str::uuid(),
                'fullname' => $request->nama_lengkap,
                'username' => $request->username,
                'password' => Hash::make($request['password']),
                'number_handphone' => $request->no_hp,
                'email' => $request->email,
                'access_code' => $request->akses,
                'access_cabang' => $request->cabang,
                'access_status' => 1,
                'remember_token' => str::uuid(),
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }

    }
    public function master_cabang()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('master_cabang')->get();
            return view('master.master-cabang', ['data' => $data]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('z_menu_sub')->get();
            return view('master.master-menu', ['data' => $data]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_add()
    {
        if (Auth::user()->access_code == 'master') {
            $menu = DB::table('z_menu')->get();
            return view('master.menu.form-add', ['menu' => $menu]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_save(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $kode = Str::uuid();
            DB::table('z_menu_sub')->insert([
                'menu_sub_code' => $kode,
                'menu_code' => $request->menu,
                'menu_sub_name' => $request->sub_menu,
                'menu_sub_link' => $request->link,
                'menu_sub_icon' => $request->icon,
                'menu_sub_status' => 1,
                'created_at' => now(),
            ]);
            DB::table('z_menu_user')->insert([
                'menu_sub_code' => $kode,
                'access_code' => 'master',
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data');
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_access()
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('master_access')->get();
            return view('master.master-menu-access', ['data' => $data]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_access_setting(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            $data = DB::table('z_menu')->get();
            return view('master.menu-access.form-setting', ['data' => $data, 'code' => $request->code]);
        } else {
            return view('application.error.404');
        }
    }
    public function master_menu_access_setting_change(Request $request)
    {
        if (Auth::user()->access_code == 'master') {
            if ($request->status == 0) {
                DB::table('z_menu_user')->insert([
                    'menu_sub_code' => $request->id,
                    'access_code' => $request->code,
                    'created_at' => now()
                ]);
            } else {
                DB::table('z_menu_user')->where('id_menu_user', $request->number)->delete();
            }
        } else {
            return view('application.error.404');
        }
    }
}
