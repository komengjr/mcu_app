<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    public function __construct(string $keyword)
    {
        $this->nama = $keyword;
    }
    public function query()
    {
        return Peserta::query()->select(
            'id_inventaris',
            'kd_inventaris',
            'no_inventaris',
            'kd_lokasi',
            'nama_barang',
            'kd_cabang',
            'merk',
            'type',
            'no_seri',
            'suplier',
            'harga_perolehan',
            'tgl_beli',
            'kondisi_barang',
        )->where('kd_cabang', $this->nama)->where('kd_jenis', 1)->orderBy('id', 'ASC');
    }
    public function headings(): array
    {
        return [
            'ID Inventaris',
            'Kode Inventaris',
            'No Inventaris',
            'Kode Lokasi',
            'Nama Barang',
            'Kode Cabang',
            'Merk',
            'Type',
            'No Serial',
            'Supplier',
            'Harga Perolehan',
            'Tanggal Pembelian',
            'Kondisi Barang',
        ];
    }
}
