<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CepController;
use App\Http\Controllers\Api\V1\PacienteController;
use App\Http\Controllers\Api\V1\PacientesImportarcaoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResource('/pacientes', PacienteController::class);
    Route::get('/pacientes/{cpf?}{nome?}', [PacienteController::class, 'search']);
    Route::get('/cep/{cep}', CepController::class);
    Route::post('/pacientes/importacao', PacientesImportarcaoController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
