<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PacienteResource;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Paciente::query();

        if (request()->has('nome') || request()->has('cpf')) {
            $value = request(request()->keys()[0]);
            $value = ($value) ? $value : 'no-value';
            $paciente = $query->whereRaw("UPPER(concat(nome_completo, '#', cpf)) like '%" . strtoupper( $value ) . "%'")->get();
        } else {

            $paciente = Paciente::all();
        }

        return PacienteResource::collection($paciente);
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
        foreach ($paciente->PacientesEndereco as $endereco) {
            $endereco->delete();
        }

        $paciente->delete();

        return response()->noContent();

    }
}
