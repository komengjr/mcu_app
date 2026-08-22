<?php

namespace App\Http\Controllers;

use App\Models\McuForm;
use App\Models\McuPesertaAnswer;
use App\Models\CompanyMouPeserta;
use Illuminate\Http\Request;

class PesertaMcuFormController extends Controller
{
    public function showWizard($code)
    {
        $peserta = CompanyMouPeserta::where('mou_peserta_code', $code)->firstOrFail();
        return view('public.wizard', compact('peserta'));
    }

    public function getWizardData($code)
    {
        $forms = McuForm::with(['items.options'])->orderBy('sort_order', 'asc')->get();

        $existingAnswers = McuPesertaAnswer::where('mou_peserta_code', $code)
            ->get()
            ->keyBy('id_mcu_form');

        return response()->json([
            'status'  => 'success',
            'forms'   => $forms,
            'answers' => $existingAnswers
        ]);
    }

    public function saveStepAnswer(Request $request)
    {
        $request->validate([
            'mou_peserta_code' => 'required|exists:company_mou_peserta,mou_peserta_code',
            'id_mcu_form'      => 'required|exists:mcu_forms,id_mcu_form',
            'answers'          => 'required|array',
        ]);

        $answer = McuPesertaAnswer::updateOrCreate(
            [
                'mou_peserta_code' => $request->mou_peserta_code,
                'id_mcu_form'      => $request->id_mcu_form,
            ],
            [
                'answers_data' => $request->answers,
                'is_completed' => true,
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Langkah ini berhasil disimpan!',
            'data'    => $answer
        ]);
    }
}
