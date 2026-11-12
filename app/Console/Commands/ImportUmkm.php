<?php

namespace App\Console\Commands;

use App\Support\UmkmCsvImporter;
use Illuminate\Console\Command;

class ImportUmkm extends Command
{
    protected $signature = 'umkm:import {file=database/seeders/data/kurasi_fesyen_kriya.csv : Path file CSV}
                            {--status=pending : pending|approved|rejected untuk data baru}';

    protected $description = 'Impor data UMKM dari CSV (hasil ekspor Excel/Google Form) ke database';

    public function handle(): int
    {
        $file = base_path($this->argument('file'));
        if (! is_file($file)) {
            $file = $this->argument('file'); // path absolut
        }
        if (! is_file($file)) {
            $this->error('File CSV tidak ditemukan.');

            return self::FAILURE;
        }

        $h = UmkmCsvImporter::import($file, $this->option('status'));
        $this->info("Selesai: {$h['baru']} data baru, {$h['diperbarui']} diperbarui.");

        return self::SUCCESS;
    }
}
