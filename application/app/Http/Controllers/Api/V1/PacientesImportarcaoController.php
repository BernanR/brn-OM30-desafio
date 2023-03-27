<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GerenciamentoCarga;
use App\Models\PacientesImportacao;

class PacientesImportarcaoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads/csv');

        // $carga = new GerenciamentoCarga();
        // $carga->status = GerenciamentoCarga::INICIADO_STATUS;
        // $carga->servico = "carga de pacientes";
        // $carga->save();

        $paciente = new PacientesImportacao();
        $paciente->importar($path);
        $baseUrl = url('/');

        if ($paciente->fails()) {

            $pathLog = $paciente->getFileLog();

            return response([
                'success' => true,
                'message' => "Importação possui erros, baixe o arquivo para os errors.",
                'link_consulta' => $baseUrl . "/api/v1/arquivo-log-erros/" . $pathLog
            ]);
        }

        return response([
            'success' => true,
            'message' => "Dados importados com sucesso.",
            //'link_consulta' => $baseUrl . "/api/v1/gerenciamento-carga/" . $carga->id
        ]);
    }

    public function logs(Request $request) {
        $file = $request->route('file');
        $path = "csv_logs/" . $file;

        $fullPath = storage_path('app/' . $path);

        // Download the CSV file
        return response()->download($fullPath, 'retorno_erros_paciente_importacao.csv');
    }
}
