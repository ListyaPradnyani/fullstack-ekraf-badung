<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /** Memindahkan agenda contoh dari config/ekraf.php ke database (hanya jika tabel masih kosong). */
    public function run(): void
    {
        if (Agenda::count() > 0) {
            return;
        }
        foreach (config('ekraf.kalender') as $a) {
            Agenda::create(['tanggal' => $a['date'], 'nama' => $a['name'], 'jam' => $a['time'] ?? null, 'lokasi' => $a['loc'] ?? null]);
        }
    }
}
