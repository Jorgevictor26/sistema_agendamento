<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index()
    {
        return Medico::orderBy('nome')->get();
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:150',
            'especialidade' => 'nullable|string|max:100',
        ]);

        return response()->json(Medico::create($dados), 201);
    }

    public function show(Medico $medico)
    {
        return $medico;
    }

    public function update(Request $request, Medico $medico)
    {
        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:150',
            'especialidade' => 'nullable|string|max:100',
        ]);

        $medico->update($dados);

        return $medico;
    }

    public function destroy(Medico $medico)
    {
        $medico->delete();

        return response()->noContent();
    }
}