<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Umkm;

class LandingController extends Controller
{
    public function index()
    {
        $c = config('ekraf');
        $withImg = fn (array $rows) => array_map(fn ($r) => [...$r, 'img' => asset($r['img'])], $rows);

        $umkmQuery = Umkm::with('files')->approved();
        if (! $umkmQuery->exists()) {
            $umkmQuery = Umkm::with('files');
        }

        // Ambil data agenda kalender dari database yang diinput oleh admin
        $allAgendas = Agenda::orderBy('tanggal')->orderBy('jam')->get();

        // Pilihan gambar representatif untuk kartu kegiatan di landing page
        $eventImages = [
            'assets/images/event/event-1.jpg',
            'assets/images/event/event-2.jpg',
            'assets/images/event/event-3.jpg',
        ];

        // Tampilkan beberapa kegiatan di landing page agar sesuai dengan agenda kalender input admin.
        // Prioritaskan agenda mendatang (tanggal hari ini ke depan). Jika kurang dari 3, tampilkan agenda terdekat/terbaru.
        if ($allAgendas->isNotEmpty()) {
            $today = now()->toDateString();
            $upcoming = $allAgendas->filter(fn ($a) => $a->tanggal->format('Y-m-d') >= $today)->values();

            if ($upcoming->count() >= 3) {
                $featuredAgendas = $upcoming->take(6);
            } else {
                // Jika agenda mendatang kurang dari 3, gabungkan agenda terbaru dari database agar tampilan tetap informatif
                $featuredAgendas = $allAgendas->count() <= 6
                    ? $allAgendas
                    : $allAgendas->sortByDesc('tanggal')->take(6)->sortBy('tanggal')->values();
            }

            $landingEvents = $featuredAgendas->values()->map(function ($agenda, $index) use ($eventImages) {
                $img = $eventImages[$index % count($eventImages)];
                return [
                    'id' => $agenda->id,
                    'date' => $agenda->tanggal->format('Y-m-d'),
                    'name' => $agenda->nama,
                    'loc' => $agenda->lokasi ?: 'Kabupaten Badung',
                    'time' => $agenda->jam ?: '',
                    'img' => asset($img),
                ];
            })->all();
        } else {
            // Fallback apabila belum ada agenda yang diinput admin di database
            $landingEvents = $withImg($c['event'] ?? []);
        }

        $data = [
            'subsektor' => $c['subsektor'],
            'umkm' => $umkmQuery->orderBy('nama_brand')->get()
                ->map->toLanding()->values()->all(),
            'komunitas' => $withImg($c['komunitas']),
            'program' => $withImg($c['program']),
            'event' => $landingEvents,
            'kalender' => $allAgendas->map->toLanding()->values()->all(),
            'struktur' => $withImg($c['struktur']),
        ];

        return view('landing', compact('data'));
    }
}
