<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = ['tanggal', 'nama', 'jam', 'lokasi'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    /** Bentuk data yang dibaca kalender di js/main.js. */
    public function toLanding(): array
    {
        return [
            'date' => $this->tanggal->format('Y-m-d'),
            'name' => $this->nama,
            'time' => $this->jam ?: '',
            'loc' => $this->lokasi ?: '',
        ];
    }
}
