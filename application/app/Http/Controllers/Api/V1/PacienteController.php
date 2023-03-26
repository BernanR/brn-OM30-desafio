<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Paciente;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Http\Resources\PacienteResource;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PacienteResource::collection(Paciente::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePacienteRequest $request)
    {
        $task = Paciente::create($request->validated());

        return PacienteResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        return PacienteResource::make($paciente);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request, Paciente $paciente)
    {
        $paciente->update($request->validated());

        return PacienteResource::make($paciente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return response()->noContent();

    }
}
