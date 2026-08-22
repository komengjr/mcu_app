<?php

namespace App\Http\Controllers;

use App\Models\McuForm;
use App\Models\McuFormItem;
use App\Models\McuItemOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterMcuFormController extends Controller
{
    // Hanya Method ini yang Return View
    public function index()
    {
        return view('application.master-data.master-form');
    }

    // --- API / JSON RESPONSES ---

    // 1. Fetch Semua Form
    public function getForms()
    {
        $forms = McuForm::withCount('items')->orderBy('sort_order', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $forms]);
    }

    // 2. Simpan / Update Form
    public function storeOrUpdateForm(Request $request)
    {
        $id = $request->id_mcu_form;

        $request->validate([
            'form_name' => 'required|string|max:255',
            'form_code' => 'required|string|unique:mcu_forms,form_code,' . $id . ',id_mcu_form',
        ]);

        $form = McuForm::updateOrCreate(
            ['id_mcu_form' => $id],
            [
                'form_code'   => strtoupper(Str::slug($request->form_code, '_')),
                'form_name'   => $request->form_name,
                'description' => $request->description,
                'sort_order'  => $request->sort_order ?? 0,
            ]
        );

        return response()->json(['status' => 'success', 'message' => 'Data Form Berhasil Disimpan', 'data' => $form]);
    }

    // 3. Hapus Form
    public function destroyForm($id)
    {
        McuForm::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Form Berhasil Dihapus']);
    }

    // 4. Fetch Item & Opsi berdasarkan Form ID
    public function getItems($formId)
    {
        $form = McuForm::with(['items.options'])->findOrFail($formId);
        return response()->json(['status' => 'success', 'data' => $form]);
    }

    // 5. Simpan / Update Item Pertanyaan
    public function storeOrUpdateItem(Request $request)
    {
        $itemId = $request->id_mcu_form_item;

        $request->validate([
            'id_mcu_form' => 'required|exists:mcu_forms,id_mcu_form',
            'item_label'  => 'required|string|max:255',
            'field_type'  => 'required|in:text,number,yes_no,select,textarea',
        ]);

        $item = McuFormItem::updateOrCreate(
            ['id_mcu_form_item' => $itemId],
            [
                'id_mcu_form' => $request->id_mcu_form,
                'item_label'  => $request->item_label,
                'field_type'  => $request->field_type,
                'unit'        => $request->unit,
                'sort_order'  => $request->sort_order ?? 0,
            ]
        );

        // Olah Opsi untuk Tipe Input 'select'
        if ($request->field_type === 'select') {
            $item->options()->delete();
            if ($request->has('options') && is_array($request->options)) {
                foreach ($request->options as $optLabel) {
                    if (!empty(trim($optLabel))) {
                        McuItemOption::create([
                            'id_mcu_form_item' => $item->id_mcu_form_item,
                            'option_label'     => trim($optLabel),
                            'option_value'     => Str::slug($optLabel, '_'),
                        ]);
                    }
                }
            }
        } else {
            $item->options()->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Item Pemeriksaan Berhasil Disimpan']);
    }

    // 6. Hapus Item
    public function destroyItem($itemId)
    {
        McuFormItem::findOrFail($itemId)->delete();
        return response()->json(['status' => 'success', 'message' => 'Item Berhasil Dihapus']);
    }
}
