<?php

namespace App\Http\Controllers;

use App\Models\MarketingCabang;
use App\Models\MarketingStaff;
use App\Models\MarketingTarget;
use App\Models\MasterCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MarketingDashboardController extends Controller
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
    public function index()
    {
        return view('app-marketing.dashboard');
    }
    // REGISTRASI PASIEN
    public function marketing_staff($akses)
    {
        if ($this->url_akses($akses) == true) {
            $bulanSekarang = date('n');
            $tahunSekarang = date('Y');

            $staffs = MarketingStaff::with([
                'cabang',
                'targets' => function ($query) use ($bulanSekarang, $tahunSekarang) {
                    $query->where('bulan', $bulanSekarang)->where('tahun', $tahunSekarang);
                }
            ])->latest()->get();

            // Ambil data cabang dari tabel marketing_cabang
            $cabangs = MarketingCabang::where('status', 'Aktif')
                ->orderBy('nama_cabang', 'asc')
                ->get();
            return view('app-marketing.mrketing-staff', compact('staffs', 'cabangs', 'bulanSekarang', 'tahunSekarang'));
        } else {
            return Redirect::to('marketing/dashboard/home');
        }
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_cabang' => 'nullable|exists:marketing_cabang,kode_cabang',
            'nik' => 'required|string|max:20|unique:marketing_staff,nik',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:marketing_staff,email',
            'no_telepon' => 'nullable|string|max:15',
            'jabatan' => 'required|in:Direktur Marketing,Kepala Cabang,Manager Marketing,Supervisor Marketing,Marketing Dokter,Marketing Perusahaan,Marketing Komunikasi,Marketing Rujukan',
            'tanggal_masuk' => 'required|date',
            'nama_bank' => 'nullable|string|max:50',
            'nomor_rekening' => 'nullable|string|max:30',
            'nama_pemilik_rekening' => 'nullable|string|max:100',
        ]);

        $staff = MarketingStaff::create($validatedData);

        // Load relasi cabang untuk respon AJAX
        $staff->load('cabang');

        return response()->json([
            'success' => true,
            'message' => 'Data staff marketing berhasil ditambahkan!',
            'data'    => $staff
        ], 200);
    }
    public function storeTarget(Request $request)
    {
        $validated = $request->validate([
            'marketing_staff_id' => 'required|exists:marketing_staff,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|digits:4|integer',
            'target_omset' => 'required|numeric|min:0',
            'persentase_komisi' => 'required|numeric|min:0|max:100',
            'tier_insentif' => 'required|in:Tier 1,Tier 2,Tier 3',
        ]);

        $target = MarketingTarget::updateOrCreate(
            [
                'marketing_staff_id' => $validated['marketing_staff_id'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
            ],
            [
                'target_omset' => $validated['target_omset'],
                'persentase_komisi' => $validated['persentase_komisi'],
                'tier_insentif' => $validated['tier_insentif'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Target insentif bulanan berhasil disimpan!',
            'data'    => $target
        ], 200);
    }
}
