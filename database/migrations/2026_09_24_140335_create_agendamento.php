<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->time('hora_inicio');
            $table->time('hora_fim');

            $table->foreignId('medico_id')
                ->constrained('medicos')
                ->restrictOnDelete();

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->restrictOnDelete();

            $table->enum('motivo', ['Primeiro agendamento', 'Retorno', 'Exame']);
            $table->enum('status', ['Confirmado', 'Reagendado', 'Cancelado'])
                ->default('Confirmado');

            $table->timestamps();

            // evita duas consultas no mesmo horário exato com a mesma médica
            $table->unique(['medico_id', 'data', 'hora_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};