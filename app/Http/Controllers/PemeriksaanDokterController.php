<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemeriksaanDokterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getMou(Request $request)
    {
        $companyCode = $request->input('company_code');

        $mous = DB::table('company_mou')
            ->where('master_company_code', $companyCode)
            ->get(['company_mou_code', 'company_mou_name']);

        return response()->json($mous);
    }

    public function getParticipants(Request $request)
    {
        $mouCode = $request->input('mou_code');
        $draw = $request->input('draw', 1);
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value');

        // Query Dasar
        $baseQuery = DB::table('company_mou_peserta')
            ->leftJoin('company_mou_pemeriksaan_doc', 'company_mou_peserta.mou_peserta_code', '=', 'company_mou_pemeriksaan_doc.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $mouCode);

        // Total data tanpa filter pencarian
        $recordsTotal = (clone $baseQuery)->count();

        // Filter Pencarian (Search Box DataTables)
        if (!empty($searchValue)) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('company_mou_peserta.mou_peserta_name', 'like', "%{$searchValue}%")
                    ->orWhere('company_mou_peserta.mou_peserta_nik', 'like', "%{$searchValue}%")
                    ->orWhere('company_mou_peserta.mou_peserta_nip', 'like', "%{$searchValue}%")
                    ->orWhere('company_mou_peserta.mou_peserta_departemen', 'like', "%{$searchValue}%");
            });
        }

        // Total data setelah difilter
        $recordsFiltered = (clone $baseQuery)->count();

        // Ambil Data Terpaginasi
        $dataPeserta = $baseQuery
            ->select([
                'company_mou_peserta.mou_peserta_code',
                'company_mou_peserta.mou_peserta_nik',
                'company_mou_peserta.mou_peserta_nip',
                'company_mou_peserta.mou_peserta_name',
                'company_mou_peserta.mou_peserta_departemen',
                'company_mou_pemeriksaan_doc.id_pemeriksaan_doc'
            ])
            ->skip($start)
            ->take($length)
            ->get();

        // Mapping Data untuk DataTables
        $formattedData = [];
        foreach ($dataPeserta as $index => $row) {
            $nipNik = ($row->mou_peserta_nip ?? '-') . ' / ' . ($row->mou_peserta_nik ?? '-');

            if ($row->id_pemeriksaan_doc) {
                $statusBadge = '<span class="badge bg-success-subtle text-success border border-success"><i class="fas fa-check-circle me-1"></i>Sudah Diperiksa</span>';
                $btnText = 'Edit Periksa';
                $btnClass = 'btn-outline-warning';
            } else {
                $statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning"><i class="fas fa-clock me-1"></i>Belum Diperiksa</span>';
                $btnText = 'Input Periksa';
                $btnClass = 'btn-primary';
            }

            $actionBtn = '<button class="btn btn-sm ' . $btnClass . ' btn-input-pemeriksaan" data-peserta-code="' . $row->mou_peserta_code . '">
                            <i class="fas fa-stethoscope me-1"></i> ' . $btnText . '
                          </button>';

            $formattedData[] = [
                'DT_RowIndex'            => $start + $index + 1,
                'nip_nik'                => $nipNik,
                'mou_peserta_name'       => $row->mou_peserta_name,
                'mou_peserta_departemen' => $row->mou_peserta_departemen ?? '-',
                'status_badge'           => $statusBadge,
                'action'                 => $actionBtn,
            ];
        }

        // Format standar DataTables Server-Side JSON
        return response()->json([
            'draw'            => intval($draw),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $formattedData
        ]);
    }

    public function getSummaryStats(Request $request)
    {
        $mouCode = $request->input('mou_code');

        $total = DB::table('company_mou_peserta')
            ->where('company_mou_code', $mouCode)
            ->count();

        $sudah = DB::table('company_mou_peserta')
            ->join('company_mou_pemeriksaan_doc', 'company_mou_peserta.mou_peserta_code', '=', 'company_mou_pemeriksaan_doc.mou_peserta_code')
            ->where('company_mou_peserta.company_mou_code', $mouCode)
            ->count();

        return response()->json([
            'total' => $total,
            'sudah' => $sudah,
            'belum' => max(0, $total - $sudah)
        ]);
    }

    public function getDetail(Request $request)
    {
        $pesertaCode = $request->input('peserta_code');

        $peserta = DB::table('company_mou_peserta')
            ->where('mou_peserta_code', $pesertaCode)
            ->first();

        $pemeriksaan = DB::table('company_mou_pemeriksaan_doc')
            ->where('mou_peserta_code', $pesertaCode)
            ->first();

        return response()->json([
            'peserta'     => $peserta,
            'pemeriksaan' => $pemeriksaan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mou_peserta_code' => 'required',
            'berat_badan'      => 'required|numeric',
            'tinggi_badan'     => 'required|numeric',
            'tensi'            => 'required|string',
        ]);

        $pesertaCode = $request->input('mou_peserta_code');

        $exists = DB::table('company_mou_pemeriksaan_doc')
            ->where('mou_peserta_code', $pesertaCode)
            ->exists();

        $payload = [
            'berat_badan'  => $request->input('berat_badan'),
            'tinggi_badan' => $request->input('tinggi_badan'),
            'rr_nafas'     => $request->input('rr_nafas'),
            'suhu'         => $request->input('suhu'),
            'tensi'        => $request->input('tensi'),
            'nadi_hr'      => $request->input('nadi_hr'),
            'spo2'         => $request->input('spo2'),
            'pemeriksa'    => $request->input('pemeriksa'),
            'dokter_penginput'    => Auth::user()->fullname,
            'updated_at'   => now(),
        ];

        if (!$exists) {
            $payload['created_at'] = now();
        }

        DB::table('company_mou_pemeriksaan_doc')->updateOrInsert(
            ['mou_peserta_code' => $pesertaCode],
            $payload
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Data pemeriksaan fisik berhasil disimpan!'
        ]);
    }
}
