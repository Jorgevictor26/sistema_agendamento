<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        return Paciente::orderBy('nome')->get();
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:150',
            'numero' => 'required|string|max:20',
        ]);

        return response()->json(Paciente::create($dados), 201);
    }

    public function show(Paciente $paciente)
    {
        return $paciente;
    }

    public function update(Request $request, Paciente $paciente)
    {
        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:150',
            'numero' => 'sometimes|required|string|max:20',
        ]);

        $paciente->update($dados);

        return $paciente;
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return response()->noContent();
    }
}