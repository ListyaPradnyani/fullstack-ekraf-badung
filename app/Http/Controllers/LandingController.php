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

        $data = [
            'subsektor' => $c['subsektor'],
            'umkm' => Umkm::with('files')->approved()->orderBy('nama_brand')->get()
                ->map->toLanding()->values()->all(),
            'komunitas' => $withImg($c['komunitas']),
            'program' => $withImg($c['program']),
            'event' => $withImg($c['event']),
            'kalender' => Agenda::orderBy('tanggal')->orderBy('jam')->get()->map->toLanding()->values()->all(),
            'struktur' => $withImg($c['struktur']),
        ];

        return view('landing', compact('data'));
    }
}
