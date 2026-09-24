<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'hora_inicio',
        'hora_fim',
        'medico_id',
        'paciente_id',
        'motivo',
        'status',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    // dia da semana calculado a partir da data, nunca guardado no banco
    protected function diaSemana(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data
                ?->locale('pt_BR')
                ->isoFormat('dddd'),
        );
    }
}