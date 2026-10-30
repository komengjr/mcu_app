<?php

namespace App\Http\Controllers;

use App\Models\MarketingAksesCabang;
use App\Models\MarketingCabang;
use App\Models\MarketingHierarkiPenilaian;
use App\Models\MarketingPenilaianStaff;
use App\Models\MarketingPenilaianStaffDetail;
use App\Models\MarketingSettingKpi;
use App\Models\MarketingSettingKpiTarget;
use App\Models\MarketingStaff;
use App\Models\MarketingTarget;
use App\Models\MasterAccess;
use App\Models\MasterCabang;
use App\Models\UserMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public function marketing_penilaian(Request $request, $akses)
    {
        if ($this->url_akses($akses) == true) {
            $bulan = date('n');
            $tahun = date('Y');

            // Ambil daftar cabang sesuai akses penilai
            $penilai = MarketingStaff::where('nik', $akses)->orWhere('id', $akses)->first();
            $cabangsQuery = MarketingCabang::where('status', 'Aktif');

            if ($penilai) {
                $aksesCabangs = MarketingAksesCabang::where('marketing_staff_id', $penilai->id)->pluck('kode_cabang')->toArray();
                if (!empty($aksesCabangs)) {
                    $cabangsQuery->whereIn('kode_cabang', $aksesCabangs);
                } elseif ($penilai->jabatan !== 'Direktur Marketing') {
                    $cabangsQuery->where('kode_cabang', $penilai->kode_cabang);
                }
            }

            $cabangs = $cabangsQuery->orderBy('nama_cabang')->get();

            return view('app-marketing.marketing-penilaian', compact(
                'akses',
                'cabangs',
                'bulan',
                'tahun'
            ));
        }

        return Redirect::to('marketing/dashboard/home');
    }
    public function get_data_penilaian(Request $request, $akses = null)
    {
        $akses = $akses ?? $request->route('akses');

        if ($this->url_akses($akses) == true) {
            $bulan = $request->get('bulan', date('n'));
            $tahun = $request->get('tahun', date('Y'));
            $kodeCabang = $request->get('kode_cabang');

            // Jalankan query dengan filter hierarki & cabang
            $staffs = $this->queryStaffBawahan($akses, $bulan, $tahun, $kodeCabang)->get();

            $totalStaff = $staffs->count();
            $sudahDinilai = $staffs->filter(fn($s) => $s->penilaians->isNotEmpty())->count();
            $belumDinilai = $totalStaff - $sudahDinilai;

            $dataStaff = $staffs->map(function ($s) {
                $penilaian = $s->penilaians->first();
                return [
                    'id' => $s->id,
                    'nama_lengkap' => $s->nama_lengkap,
                    'nik' => $s->nik,
                    'jabatan' => $s->jabatan,
                    'cabang' => $s->cabang ? $s->cabang->nama_cabang : '-',
                    'penilaian' => $penilaian ? [
                        'total_skor_akhir' => number_format($penilaian->total_skor_akhir, 2),
                        'predikat' => $penilaian->predikat,
                    ] : null
                ];
            });

            return response()->json([
                'success' => true,
                'summary' => [
                    'totalStaff' => $totalStaff,
                    'sudahDinilai' => $sudahDinilai,
                    'belumDinilai' => $belumDinilai,
                ],
                'staffs' => $dataStaff
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }

    public function getFormPenilaian(Request $request, $akses = null, $staff_id = null)
    {
        $akses = $akses ?? $request->route('akses');
        $staff_id = $staff_id ?? $request->route('staff_id');

        if ($this->url_akses($akses) == true) {
            $bulan = $request->get('bulan', date('n'));
            $tahun = $request->get('tahun', date('Y'));

            $staff = MarketingStaff::with('cabang')->findOrFail($staff_id);

            // Fetch KPI beserta target khusus di bulan & tahun ini
            $kpis = MarketingSettingKpi::with(['targets' => function ($q) use ($bulan, $tahun) {
                $q->where('bulan', $bulan)->where('tahun', $tahun);
            }])
                ->where('jabatan', $staff->jabatan)
                ->where('status', 'Aktif')
                ->get();

            // Map data KPI agar menyertakan target_standar spesifik periode
            $kpiData = $kpis->map(function ($kpi) {
                $targetObj = $kpi->targets->first();
                return [
                    'id'             => $kpi->id,
                    'nama_indikator' => $kpi->nama_indikator,
                    'tipe_penilaian' => $kpi->tipe_penilaian,
                    'satuan'         => $kpi->satuan,
                    'bobot_persen'   => $kpi->bobot_persen,
                    'target_standar' => $targetObj ? $targetObj->target_standar : 0,
                ];
            });

            $penilaian = MarketingPenilaianStaff::with('details')
                ->where('marketing_staff_id', $staff_id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            return response()->json([
                'success'   => true,
                'staff'     => $staff,
                'kpis'      => $kpiData,
                'penilaian' => $penilaian
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }
    public function storePenilaian(Request $request, $akses = null)
    {
        $akses = $akses ?? $request->route('akses');

        if ($this->url_akses($akses) == true) {
            $request->validate([
                'marketing_staff_id' => 'required|exists:marketing_staff,id',
                'bulan'              => 'required|numeric|between:1,12',
                'tahun'              => 'required|numeric',
                'target_standar'     => 'required|array',
                'pencapaian_real'    => 'required|array',
                'catatan_evaluasi'   => 'nullable|string',
            ]);

            DB::beginTransaction();
            try {
                $staff = MarketingStaff::findOrFail($request->marketing_staff_id);

                // Fetch KPI untuk jabatan bersangkutan
                $kpis = MarketingSettingKpi::where('jabatan', $staff->jabatan)
                    ->where('status', 'Aktif')
                    ->get();

                $header = MarketingPenilaianStaff::updateOrCreate(
                    [
                        'marketing_staff_id' => $staff->id,
                        'bulan'              => $request->bulan,
                        'tahun'              => $request->tahun,
                    ],
                    [
                        'catatan_evaluasi'   => $request->catatan_evaluasi,
                        'status'             => 'Final',
                    ]
                );

                MarketingPenilaianStaffDetail::where('penilaian_staff_id', $header->id)->delete();

                $totalSkorAkhir = 0;

                foreach ($kpis as $kpi) {
                    $targetVal = $request->target_standar[$kpi->id] ?? 0;
                    $realVal   = $request->pencapaian_real[$kpi->id] ?? 0;

                    // 1. Simpan / Update Target Bulanan ke marketing_setting_kpi_target
                    MarketingSettingKpiTarget::updateOrCreate(
                        [
                            'kpi_id' => $kpi->id,
                            'bulan'  => $request->bulan,
                            'tahun'  => $request->tahun,
                        ],
                        [
                            'target_standar' => $targetVal
                        ]
                    );

                    // 2. Kalkulasi Skor & Capaian
                    $targetDivider = $targetVal > 0 ? $targetVal : 1;
                    $persentaseCapaian = ($realVal / $targetDivider) * 100;
                    $skorTerbobot = ($persentaseCapaian * $kpi->bobot_persen) / 100;

                    $totalSkorAkhir += $skorTerbobot;

                    // 3. Simpan Detail Penilaian Staf
                    MarketingPenilaianStaffDetail::create([
                        'penilaian_staff_id' => $header->id,
                        'kpi_id'             => $kpi->id,
                        'nama_indikator'     => $kpi->nama_indikator,
                        'tipe_penilaian'     => $kpi->tipe_penilaian,
                        'target_standar'     => $targetVal,
                        'pencapaian_real'    => $realVal,
                        'satuan'             => $kpi->satuan,
                        'bobot_persen'       => $kpi->bobot_persen,
                        'persentase_capaian' => round($persentaseCapaian, 2),
                        'skor_terbobot'      => round($skorTerbobot, 2),
                    ]);
                }

                // Tentukan Predikat Akhir
                $predikat = 'Kurang';
                if ($totalSkorAkhir >= 90) {
                    $predikat = 'Sangat Baik';
                } elseif ($totalSkorAkhir >= 75) {
                    $predikat = 'Baik';
                } elseif ($totalSkorAkhir >= 60) {
                    $predikat = 'Cukup';
                }

                $header->update([
                    'total_skor_akhir' => round($totalSkorAkhir, 2),
                    'predikat'         => $predikat
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Penilaian bulanan staf berhasil disimpan.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }
    // Method Cetak Rekapitulasi KPI Semua Staf
    public function printAll(Request $request, $akses = null)
    {
        $akses = $akses ?? $request->route('akses');

        if ($this->url_akses($akses) == true) {
            $bulan = $request->get('bulan', date('n'));
            $tahun = $request->get('tahun', date('Y'));
            $kodeCabang = $request->get('kode_cabang');

            $staffsQuery = MarketingStaff::with(['cabang', 'penilaians' => function ($q) use ($bulan, $tahun) {
                $q->where('bulan', $bulan)->where('tahun', $tahun);
            }])->where('status_aktif', 'Aktif');

            if ($kodeCabang) {
                $staffsQuery->where('kode_cabang', $kodeCabang);
            }

            $staffs = $staffsQuery->get();

            $namaCabang = 'Semua Cabang';
            if ($kodeCabang) {
                $cabang = MarketingCabang::where('kode_cabang', $kodeCabang)->first();
                $namaCabang = $cabang ? $cabang->nama_cabang : $kodeCabang;
            }

            return view('app-marketing.print-penilaian-all', compact(
                'staffs',
                'bulan',
                'tahun',
                'namaCabang'
            ));
        }

        return Redirect::to('marketing/dashboard/home');
    }

    // Method Cetak Rekapitulasi KPI Perorang
    public function printPerson(Request $request, $akses = null, $staff_id = null)
    {
        $akses = $akses ?? $request->route('akses');
        $staff_id = $staff_id ?? $request->route('staff_id');

        if ($this->url_akses($akses) == true) {
            $bulan = $request->get('bulan', date('n'));
            $tahun = $request->get('tahun', date('Y'));

            $staff = MarketingStaff::with('cabang')->findOrFail($staff_id);

            $penilaian = MarketingPenilaianStaff::with('details')
                ->where('marketing_staff_id', $staff_id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            return view('app-marketing.print-penilaian-person', compact(
                'staff',
                'penilaian',
                'bulan',
                'tahun'
            ));
        }

        return Redirect::to('marketing/dashboard/home');
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
    // MASTER CABANG MARKETING
    public function marketing_cabang($akses)
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
            $cabangs = MarketingCabang::withCount('staff') // sesuaikan nama relasi ke staff marketing
                ->latest()
                ->get();
            return view('app-marketing.marketing-cabang', compact('staffs', 'cabangs', 'bulanSekarang', 'tahunSekarang'));
        } else {
            return Redirect::to('marketing/dashboard/home');
        }
    }
    public function marketing_cabang_store(Request $request)
    {
        $request->validate([
            'kode_cabang' => 'required|string|max:50|unique:marketing_cabang,kode_cabang',
            'nama_cabang' => 'required|string|max:100',
            'entitas'     => 'nullable|string|max:100',
            'kota'        => 'nullable|string|max:100',
            'alamat'      => 'nullable|string',
            'no_telepon'  => 'nullable|string|max:20',
            'latitude'    => 'nullable|string|max:50',
            'longitude'   => 'nullable|string|max:50',
            'status'      => 'required|in:Aktif,Nonaktif',
        ], [
            'kode_cabang.unique' => 'Kode Cabang ini sudah digunakan.',
            'kode_cabang.required' => 'Kode Cabang wajib diisi.',
            'nama_cabang.required' => 'Nama Cabang wajib diisi.'
        ]);

        $cabang = MarketingCabang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data cabang berhasil disimpan.',
            'data'    => $cabang
        ]);
    }
    // MASTER CABANG MARKETING
    public function marketing_setting($akses)
    {
        if ($this->url_akses($akses) == true) {
            $jabatans = [
                'Direktur Marketing',
                'Kepala Cabang',
                'Manager Marketing',
                'Supervisor Marketing',
                'Marketing Dokter',
                'Marketing Perusahaan',
                'Marketing Komunikasi',
                'Marketing Rujukan'
            ];

            // Ambil semua KPI dan kelompokkan berdasarkan Jabatan
            $kpiGrouped = MarketingSettingKpi::get()->groupBy('jabatan');
            return view('app-marketing.marketing-setting', compact('jabatans', 'kpiGrouped'));
        } else {
            return Redirect::to('marketing/dashboard/home');
        }
    }
    public function storeKpi(Request $request)
    {
        $request->validate([
            'jabatan'        => 'required|string',
            'nama_indikator' => 'required|string|max:150',
            'tipe_penilaian' => 'required|in:Manual,Otomatis',
            'target_standar' => 'required|numeric|min:0',
            'satuan'         => 'required|string|max:50',
            'bobot_persen'   => 'required|numeric|min:0|max:100',
        ]);

        $kpi = MarketingSettingKpi::create([
            'jabatan'               => $request->jabatan,
            'nama_indikator'        => $request->nama_indikator,
            'tipe_penilaian'        => $request->tipe_penilaian,
            'sumber_data_otomatis'  => $request->tipe_penilaian === 'Otomatis' ? $request->sumber_data_otomatis : null,
            'target_standar'        => $request->target_standar,
            'satuan'                => $request->satuan,
            'bobot_persen'          => $request->bobot_persen,
            'deskripsi'             => $request->deskripsi,
            'status'                => 'Aktif'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Indikator penilaian berhasil ditambahkan.',
            'data'    => $kpi
        ]);
    }

    public function updateKpi(Request $request)
    {
        $request->validate([
            'id'             => 'required|exists:marketing_setting_kpi,id',
            'nama_indikator' => 'required|string|max:150',
            'tipe_penilaian' => 'required|in:Manual,Otomatis',
            'target_standar' => 'required|numeric|min:0',
            'satuan'         => 'required|string|max:50',
            'bobot_persen'   => 'required|numeric|min:0|max:100',
            'status'         => 'required|in:Aktif,Nonaktif'
        ]);

        $kpi = MarketingSettingKpi::findOrFail($request->id);
        $kpi->update([
            'nama_indikator'       => $request->nama_indikator,
            'tipe_penilaian'       => $request->tipe_penilaian,
            'sumber_data_otomatis' => $request->tipe_penilaian === 'Otomatis' ? $request->sumber_data_otomatis : null,
            'target_standar'       => $request->target_standar,
            'satuan'               => $request->satuan,
            'bobot_persen'         => $request->bobot_persen,
            'deskripsi'            => $request->deskripsi,
            'status'               => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Indikator penilaian berhasil diperbarui.',
            'data'    => $kpi
        ]);
    }

    public function destroyKpi($id)
    {
        $kpi = MarketingSettingKpi::findOrFail($id);
        $kpi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Indikator penilaian berhasil dihapus.'
        ]);
    }

    private function queryStaffBawahan($akses, $bulan, $tahun, $kodeCabangFilter = null)
    {
        // 1. Identifikasi Penilai berdasarkan $akses (NIK / ID Staff)
        $penilai = MarketingStaff::where('nik', $akses)->orWhere('id', $akses)->first();

        $staffsQuery = MarketingStaff::with(['cabang', 'penilaians' => function ($q) use ($bulan, $tahun) {
            $q->where('bulan', $bulan)->where('tahun', $tahun);
        }])->where('status_aktif', 'Aktif');

        if ($penilai) {
            // A. Filter Berdasarkan Hierarki Penilaian (Atasan -> Bawahan)
            $allowedJabatan = MarketingHierarkiPenilaian::where('jabatan_penilai', $penilai->jabatan)
                ->pluck('jabatan_dinilai')
                ->toArray();

            if (!empty($allowedJabatan)) {
                $staffsQuery->whereIn('jabatan', $allowedJabatan);
            }

            // B. Filter Berdasarkan Akses Cabang
            $aksesCabangs = MarketingAksesCabang::where('marketing_staff_id', $penilai->id)
                ->pluck('kode_cabang')
                ->toArray();

            if (!empty($aksesCabangs)) {
                // Jika di-setting multi-cabang di tabel marketing_akses_cabang
                $staffsQuery->whereIn('kode_cabang', $aksesCabangs);
            } elseif ($penilai->jabatan !== 'Direktur Marketing') {
                // Jika tidak ada multi-cabang & bukan Direktur, batasi ke cabangnya sendiri
                $staffsQuery->where('kode_cabang', $penilai->kode_cabang);
            }
        }

        // C. Filter Tambahan dari Form Dropdown Cabang
        if ($kodeCabangFilter) {
            $staffsQuery->where('kode_cabang', $kodeCabangFilter);
        }

        return $staffsQuery;
    }
    public function master_akses(Request $request, $akses = null)
    {
        $akses = $akses ?? $request->route('akses');

        if ($this->url_akses($akses) == true) {
            $cabangs = MarketingCabang::all();
            $staffs = MarketingStaff::where('status_aktif', 'Aktif')->get();
            $aksesCabangs = MarketingAksesCabang::with(['staff', 'cabang'])->get()->groupBy('marketing_staff_id');
            $hierarkis = MarketingHierarkiPenilaian::all();

            // Ambil daftar master akses aktif (Direktur, Kepala Cabang, Manager, dll)
            $masterAccesses = MasterAccess::where('master_access_status', 'Y')->get();

            $listJabatan = [
                'Direktur Marketing',
                'Kepala Cabang',
                'Manager Marketing',
                'Supervisor Marketing',
                'Marketing Dokter',
                'Marketing Perusahaan',
                'Marketing Komunikasi',
                'Marketing Rujukan'
            ];

            return view('app-marketing.master-akses', compact(
                'akses',
                'cabangs',
                'staffs',
                'aksesCabangs',
                'hierarkis',
                'listJabatan',
                'masterAccesses'
            ));
        }

        return redirect()->back()->with('error', 'Akses Ditolak');
    }
    public function getStaffByCabang(Request $request, $akses = null, $kode_cabang = null)
    {
        $akses = $akses ?? $request->route('akses');
        $kode_cabang = $kode_cabang ?? $request->route('kode_cabang');

        if ($this->url_akses($akses) == true) {
            $staffs = MarketingStaff::where('kode_cabang', $kode_cabang)
                ->where('status_aktif', 'Aktif')
                ->get();

            $data = $staffs->map(function ($s) {
                $user = UserMain::where('userid', $s->nik)->first();
                $aksesCabang = MarketingAksesCabang::where('marketing_staff_id', $s->id)->pluck('kode_cabang')->toArray();

                return [
                    'id'              => $s->id,
                    'nik'             => $s->nik,
                    'nama_lengkap'    => $s->nama_lengkap,
                    'email'           => $s->email,
                    'no_telepon'      => $s->no_telepon,
                    'jabatan'         => $s->jabatan,
                    'kode_cabang'     => $s->kode_cabang,
                    'has_account'     => $user ? true : false,
                    'username'        => $user ? $user->username : '',
                    'access_code'     => $user ? $user->access_code : '',
                    'access_status'   => $user ? $user->access_status : 1,
                    'akses_cabangs'   => $aksesCabang,
                ];
            });

            return response()->json([
                'success' => true,
                'staffs'  => $data
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }
    public function storeUserAkun(Request $request, $akses = null)
    {
        $akses = $akses ?? $request->route('akses');

        if ($this->url_akses($akses) == true) {
            $request->validate([
                'marketing_staff_id' => 'required|exists:marketing_staff,id',
                'username'           => 'required|string',
                'access_code'        => 'required|exists:master_access,master_access_code',
                'access_login'       => 'required|string',
                'password'           => 'nullable|string|min:6',
                'kode_cabangs'       => 'nullable|array',
            ]);

            DB::beginTransaction();
            try {
                $staff = MarketingStaff::findOrFail($request->marketing_staff_id);
                $user = UserMain::where('userid', $staff->nik)->first();

                $dataUser = [
                    'fullname'         => $staff->nama_lengkap,
                    'username'         => $request->username,
                    'userid'           => $staff->nik, // Mengikat NIK karyawan
                    'email'            => $staff->email,
                    'number_handphone' => $staff->no_telepon ?? '',
                    'access_cabang'    => $staff->kode_cabang, // Kode Cabang Utama
                    'access_code'      => $request->access_code, // Terikat ke master_access.master_access_code
                    'access_login'     => $request->access_login,
                    'access_status'    => $request->access_status ?? 1,
                ];

                if ($request->filled('password')) {
                    $dataUser['password'] = Hash::make($request->password);
                }

                if ($user) {
                    $user->update($dataUser);
                } else {
                    if (!$request->filled('password')) {
                        return response()->json(['success' => false, 'message' => 'Password wajib diisi untuk akun baru.'], 422);
                    }
                    UserMain::create($dataUser);
                }

                // Sync Otoritas Multi Cabang untuk Manager / Kepala Cabang
                MarketingAksesCabang::where('marketing_staff_id', $staff->id)->delete();

                MarketingAksesCabang::create([
                    'marketing_staff_id' => $staff->id,
                    'kode_cabang'        => $staff->kode_cabang,
                ]);

                if ($request->has('kode_cabangs')) {
                    foreach ($request->kode_cabangs as $kc) {
                        if ($kc !== $staff->kode_cabang) {
                            MarketingAksesCabang::create([
                                'marketing_staff_id' => $staff->id,
                                'kode_cabang'        => $kc,
                            ]);
                        }
                    }
                }

                DB::commit();
                return response()->json(['success' => true, 'message' => 'Akun login & akses peran berhasil disimpan.']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }
    public function storeAksesCabang(Request $request, $akses = null)
    {
        $akses = $akses ?? $request->route('akses');

        if ($this->url_akses($akses) == true) {
            $request->validate([
                'kode_cabang'         => 'required|string',
                'marketing_staff_ids' => 'nullable|array',
            ]);

            DB::beginTransaction();
            try {
                $kodeCabang = $request->kode_cabang;
                $staffIds = $request->marketing_staff_ids ?? [];

                // Sinkronisasi hak akses pengelola cabang ini
                MarketingAksesCabang::where('kode_cabang', $kodeCabang)->delete();

                foreach ($staffIds as $staffId) {
                    MarketingAksesCabang::create([
                        'marketing_staff_id' => $staffId,
                        'kode_cabang'        => $kodeCabang,
                    ]);
                }

                DB::commit();
                return response()->json(['success' => true, 'message' => 'Hak akses pengelola cabang berhasil diperbarui.']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }

    public function deleteAksesCabang(Request $request, $akses = null, $id = null)
    {
        $akses = $akses ?? $request->route('akses');
        $id = $id ?? $request->route('id');

        if ($this->url_akses($akses) == true) {
            MarketingAksesCabang::where('id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Hak akses cabang berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => 'Akses Ditolak'], 403);
    }

    public function storeHierarki(Request $request, $akses = null)
    {
        $request->validate([
            'jabatan_penilai' => 'required|string',
            'jabatan_dinilai' => 'required|string|different:jabatan_penilai',
        ]);

        $exists = MarketingHierarkiPenilaian::where('jabatan_penilai', $request->jabatan_penilai)
            ->where('jabatan_dinilai', $request->jabatan_dinilai)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Aturan hierarki ini sudah terdaftar.'], 422);
        }

        MarketingHierarkiPenilaian::create([
            'jabatan_penilai' => $request->jabatan_penilai,
            'jabatan_dinilai' => $request->jabatan_dinilai,
        ]);

        return response()->json(['success' => true, 'message' => 'Aturan hierarki penilaian berhasil ditambahkan.']);
    }

    public function deleteHierarki(Request $request, $akses = null, $id = null)
    {
        $id = $id ?? $request->route('id');
        MarketingHierarkiPenilaian::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Aturan hierarki berhasil dihapus.']);
    }
}
