<?php

namespace App\Exports;

use App\Models\CompanyMouPeserta;
use App\Models\McuForm;
use App\Models\McuFormItem;
use App\Models\McuPesertaAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ParticipantFormExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $mouCode;
    protected $formCode;
    protected $status;
    protected $formItems;

    public function __construct($mouCode, $formCode, $status)
    {
        $this->mouCode = $mouCode;
        $this->formCode = $formCode;
        $this->status = $status; // 'sudah' atau 'belum'

        // Ambil daftar pertanyaan/item form berdasarkan form_code
        $form = McuForm::where('form_code', $this->formCode)->first();
        $this->formItems = $form ? McuFormItem::where('id_mcu_form', $form->id_mcu_form)
            ->orderBy('sort_order', 'asc')
            ->get() : collect();
    }

    public function collection()
    {
        $form = McuForm::where('form_code', $this->formCode)->first();
        $query = CompanyMouPeserta::where('company_mou_code', $this->mouCode);

        if ($form) {
            if ($this->status == 'sudah') {
                $pesertaCodes = McuPesertaAnswer::where('id_mcu_form', $form->id_mcu_form)
                    ->where('is_completed', true)
                    ->pluck('mou_peserta_code');
                $query->whereIn('mou_peserta_code', $pesertaCodes);
            } else {
                $pesertaCodes = McuPesertaAnswer::where('id_mcu_form', $form->id_mcu_form)
                    ->pluck('mou_peserta_code');
                $query->whereNotIn('mou_peserta_code', $pesertaCodes);
            }
        }

        return $query->get();
    }

    public function headings(): array
    {
        // Heading dasar profil peserta
        $headings = [
            'No',
            'NIP / NIK',
            'Nama Peserta',
            'Departemen',
            $this->status == 'sudah' ? 'Status Pengisian' : 'No HP / Email'
        ];

        // Tambahkan label pertanyaan dari mcu_form_items sebagai kolom dinamis
        foreach ($this->formItems as $item) {
            $label = $item->item_label;
            if (!empty($item->unit)) {
                $label .= ' (' . $item->unit . ')';
            }
            $headings[] = $label;
        }

        return $headings;
    }

    public function map($row): array
    {
        static $index = 0;
        $index++;

        $form = McuForm::where('form_code', $this->formCode)->first();

        $answerRecord = null;
        if ($form) {
            $answerRecord = McuPesertaAnswer::where('mou_peserta_code', $row->mou_peserta_code)
                ->where('id_mcu_form', $form->id_mcu_form)
                ->first();
        }

        // Data JSON jawaban peserta (biasanya disimpan sebagai array/key-value berdasarkan id_mcu_form_item atau label)
        // Sesuaikan key array di bawah ini jika struktur JSON Anda menggunakan ID item (misal: $answers[$item->id_mcu_form_item])
        // atau menggunakan nama label/field. Di sini diasumsikan menggunakan ID item atau key form item.
        $answersData = $answerRecord ? (array) $answerRecord->answers_data : [];

        // Baris dasar data peserta
        $rowMap = [
            $index,
            $row->nip_nik ?? '-',
            $row->mou_peserta_name ?? '-',
            $row->mou_peserta_departemen ?? '-',
            $this->status == 'sudah' ? 'Selesai Mengisi' : ($row->mou_peserta_phone ?? $row->mou_peserta_email ?? '-')
        ];

        // Masukkan jawaban dinamis berdasarkan urutan pertanyaan item form
        foreach ($this->formItems as $item) {
            // Cek apakah key disimpan berdasarkan id_mcu_form_item atau string key lainnya di dalam JSON
            // Contoh umum: $answersData[$item->id_mcu_form_item] atau $answersData['item_' . $item->id_mcu_form_item]
            // Sesuaikan key di bawah ini dengan struktur penyimpanan JSON answers_data Anda saat form disubmit.
            $ansValue = '-';

            // Mencoba beberapa kemungkinan struktur key JSON yang sering digunakan
            if (isset($answersData[$item->id_mcu_form_item])) {
                $ansValue = $answersData[$item->id_mcu_form_item];
            } elseif (isset($answersData['item_' . $item->id_mcu_form_item])) {
                $ansValue = $answersData['item_' . $item->id_mcu_form_item];
            } elseif (isset($answersData[$item->item_label])) {
                $ansValue = $answersData[$item->item_label];
            }

            // Jika jawaban berupa array (misalnya checkbox), ubah menjadi string koma
            if (is_array($ansValue)) {
                $ansValue = implode(', ', $ansValue);
            }

            $rowMap[] = $ansValue !== '' && $ansValue !== null ? $ansValue : '-';
        }

        return $rowMap;
    }

    public function title(): string
    {
        return 'Laporan ' . ucfirst($this->status);
    }
}
