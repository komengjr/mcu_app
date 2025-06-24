<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class dashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('dashboard.index');
        // if (Auth::user()->access_code == 'user') {
        //     return view('dashboard.dashboard');
        // } elseif (Auth::user()->access_code == 'admin') {
        //     return view('admin.dashboard');
        // }
    }
    public function profile(){
        return view('dashboard.profile');
    }
    public function setting(){
        return view('dashboard.setting');
    }
    public function news(){
        return view('dashboard.news');
    }
    public function actifity(){
        return view('dashboard.actifity');
    }
}
