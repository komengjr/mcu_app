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
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ParticipantFormExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithEvents
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
        $headings = [
            'No',
            'NIP / NIK',
            'Nama Peserta',
            'Departemen',
            $this->status == 'sudah' ? 'Status Pengisian' : 'No HP / Email'
        ];

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

        $answersData = $answerRecord ? (array) $answerRecord->answers_data : [];

        $rowMap = [
            $index,
            $row->mou_peserta_nip ?? '-',
            $row->mou_peserta_name ?? '-',
            $row->mou_peserta_departemen ?? '-',
            $this->status == 'sudah' ? 'Selesai Mengisi' : ($row->mou_peserta_phone ?? $row->mou_peserta_email ?? '-')
        ];

        foreach ($this->formItems as $item) {
            $ansValue = '-';

            if (isset($answersData[$item->id_mcu_form_item])) {
                $ansValue = $answersData[$item->id_mcu_form_item];
            } elseif (isset($answersData['item_' . $item->id_mcu_form_item])) {
                $ansValue = $answersData['item_' . $item->id_mcu_form_item];
            } elseif (isset($answersData[$item->item_label])) {
                $ansValue = $answersData[$item->item_label];
            }

            // Jika jawaban berupa array (misalnya checkbox)
            if (is_array($ansValue)) {
                $ansValue = array_map(function ($val) {
                    return ucwords(str_replace('_', ' ', $val));
                }, $ansValue);
                $ansValue = implode(', ', $ansValue);
            } elseif (!empty($ansValue) && $ansValue !== '-') {
                // Menghilangkan underscore (_) dan merapikan teks
                $ansValue = ucwords(str_replace('_', ' ', (string) $ansValue));
            }

            $rowMap[] = $ansValue !== '' && $ansValue !== null ? $ansValue : '-';
        }

        return $rowMap;
    }
    public function title(): string
    {
        return 'Laporan ' . ucfirst($this->status);
    }
    public function styles(Worksheet $sheet)
    {
        // Styling untuk baris Header (Baris 1)
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '0D6EFD'] // Warna latar belakang biru primary (bisa disesuaikan)
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true, // Wrap text pada header
                ]
            ],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set tinggi baris header agar teks yang di-wrap terlihat dengan baik
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Mengatur auto-size untuk kolom agar rapi, dan wrap text untuk keseluruhan isi tabel jika diperlukan
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
