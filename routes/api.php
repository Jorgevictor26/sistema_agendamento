<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;

Route::apiResource('medicos', MedicoController::class);
Route::apiResource('pacientes', PacienteController::class);
Route::apiResource('agendamentos', AgendamentoController::class);