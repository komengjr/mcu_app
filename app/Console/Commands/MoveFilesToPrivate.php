<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class MoveFilesToPrivate extends Command
{
    protected $signature = 'storage:move-to-private';
    protected $description = 'Memindahkan seluruh file dari disk public ke disk local (private)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ambil semua file dari disk public
        $files = Storage::disk('public')->allFiles();

        if (empty($files)) {
            $this->info('Tidak ada file yang ditemukan di disk public.');
            return;
        }

        foreach ($files as $file) {
            // Pindahkan file dari disk public ke disk local (private)
            Storage::disk('local')->move($file, $file);
            $this->line("Dipindahkan: {$file}");
        }

        $this->info('Semua file berhasil dipindahkan ke folder private!');
    }
}
