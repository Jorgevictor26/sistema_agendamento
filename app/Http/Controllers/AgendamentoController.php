<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendamento::with(['medico', 'paciente'])
            ->orderBy('data')
            ->orderBy('hora_inicio');

        if ($request->filled('data')) {
            $query->whereDate('data', $request->query('data'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $dados = $this->validarDados($request);

        $agendamento = Agendamento::create($dados);

        return response()->json(
            $agendamento->load(['medico', 'paciente']),
            201
        );
    }

    public function show(Agendamento $agendamento)
    {
        return $agendamento->load(['medico', 'paciente']);
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $dados = $this->validarDados($request, $agendamento->id);

        $agendamento->update($dados);

        return $agendamento->load(['medico', 'paciente']);
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();

        return response()->noContent();
    }

    private function validarDados(Request $request, ?int $ignorarId = null): array
    {
        return $request->validate([
            'data' => 'required|date',
            'medico_id' => 'required|exists:medicos,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'motivo' => ['required', Rule::in(['Primeiro agendamento', 'Retorno', 'Exame'])],
            'status' => ['sometimes', Rule::in(['Confirmado', 'Reagendado', 'Cancelado'])],
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',

            // evita duas consultas no mesmo horário para a mesma médica
            'hora_inicio' => [
                'required',
                'date_format:H:i',
                Rule::unique('agendamentos')
                    ->where(fn ($q) => $q
                        ->where('medico_id', $request->input('medico_id'))
                        ->where('data', $request->input('data')))
                    ->ignore($ignorarId),
            ],
        ]);
    }
}