<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePemeriksaanDocCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pemeriksaan:hitung-bmi-tensi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengupdate status_bmi (WHO Asia-Pasifik) dan status_tensi (JNC 7) secara otomatis';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai proses pembaruan Status BMI dan Status Tensi...');

        $datas = DB::table('company_mou_pemeriksaan_doc')->get();
        $bar = $this->output->createProgressBar(count($datas));
        $bar->start();

        $updatedCount = 0;

        foreach ($datas as $row) {
            $updateData = [];

            // 1. Hitung dan Tentukan Status BMI (Standar WHO Asia-Pasifik)
            if (!is_null($row->berat_badan) && !is_null($row->tinggi_badan) && $row->tinggi_badan > 0) {
                $tinggiMeter = $row->tinggi_badan / 100;
                $bmi = $row->berat_badan / ($tinggiMeter * $tinggiMeter);

                $statusBmi = '';
                if ($bmi < 18.5) {
                    $statusBmi = 'Underweight (Kurus)';
                } elseif ($bmi >= 18.5 && $bmi <= 22.9) {
                    $statusBmi = 'Normal';
                } elseif ($bmi >= 23.0 && $bmi <= 24.9) {
                    $statusBmi = 'Overweight (Berlebih)';
                } elseif ($bmi >= 25.0 && $bmi <= 29.9) {
                    $statusBmi = 'Obese I (Beresiko)'; // atau Obese I
                } else {
                    $statusBmi = 'Obese II (Obesitas)';
                }

                $updateData['status_bmi'] = $statusBmi;
            }

            // 2. Tentukan Status Tensi (Klasifikasi JNC 7)
            // Format tensi diasumsikan "systolic/diastolic" contoh: "120/80"
            if (!empty($row->tensi) && strpos($row->tensi, '/') !== false) {
                list($systolic, $diastolic) = explode('/', trim($row->tensi));
                $systolic = (int) $systolic;
                $diastolic = (int) $diastolic;

                $statusTensi = '';
                if ($systolic < 120 && $diastolic < 80) {
                    $statusTensi = 'Normal';
                } elseif (($systolic >= 120 && $systolic <= 139) || ($diastolic >= 80 && $diastolic <= 89)) {
                    $statusTensi = 'Prehipertensi';
                } elseif (($systolic >= 140 && $systolic <= 159) || ($diastolic >= 90 && $diastolic <= 99)) {
                    $statusTensi = 'Hipertensi Stadium 1';
                } elseif ($systolic >= 160 || $diastolic >= 100) {
                    $statusTensi = 'Hipertensi Stadium 2';
                }

                $updateData['status_tensi'] = $statusTensi;
            }

            // Lakukan update jika ada data yang dihitung
            if (!empty($updateData)) {
                DB::table('company_mou_pemeriksaan_doc')
                    ->where('id_pemeriksaan_doc', $row->id_pemeriksaan_doc)
                    ->update($updateData);

                $updatedCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->info("Berhasil memperbarui {$updatedCount} data pemeriksaan secara otomatis!");

        return 0;
    }
}
