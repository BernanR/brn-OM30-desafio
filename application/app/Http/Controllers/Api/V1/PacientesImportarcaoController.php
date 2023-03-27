<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $paciente = new PacientesImportacao();
        $paciente->importar($path);

        return response([
            'success' => true,
            'message' => "Seus dados serão importados, retornaremos caso tiver algo de errado."
        ]);
    }
}
