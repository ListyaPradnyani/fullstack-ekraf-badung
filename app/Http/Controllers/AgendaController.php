<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** CRUD agenda kalender (khusus admin). Tampil di bagian "Calendar Ekraf" website utama. */
class AgendaController extends Controller
{
    private function aturan(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'nama' => ['required', 'string', 'max:150'],
            'jam' => ['nullable', 'string', 'max:40'],
            'lokasi' => ['nullable', 'string', 'max:150'],
        ];
    }

    private function pesan(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'date' => 'Format tanggal tidak valid.',
            'max' => ':attribute terlalu panjang.',
        ];
    }

    public function index(Request $request)
    {
        $bulan = $request->query('bulan');
        $agendas = Agenda::query()
            ->when($bulan && preg_match('/^\d{4}-\d{2}$/', $bulan), function ($q) use ($bulan) {
                $awal = Carbon::createFromFormat('Y-m-d', $bulan.'-01')->startOfMonth();
                $q->whereBetween('tanggal', [$awal->toDateString(), $awal->copy()->endOfMonth()->toDateString()]);
            })
            ->orderBy('tanggal')->orderBy('jam')
            ->paginate(25)->withQueryString();

        return view('admin.agenda.index', ['agendas' => $agendas, 'bulan' => $bulan, 'agenda' => new Agenda]);
    }

    public function store(Request $request)
    {
        Agenda::create($request->validate($this->aturan(), $this->pesan()));

        return redirect()->route('admin.agenda.index')->with('ok', 'Agenda ditambahkan dan langsung tampil di kalender website.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $agenda->update($request->validate($this->aturan(), $this->pesan()));

        return redirect()->route('admin.agenda.index')->with('ok', 'Agenda diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agenda.index')->with('ok', 'Agenda dihapus.');
    }
}
