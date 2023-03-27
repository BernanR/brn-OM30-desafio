<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class CepController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $zipCoded = str_replace("-", "", $request->route("cep"));
        $redsZipCode = Redis::get("cep:{$zipCoded}:json");

        if ($redsZipCode) {
            return json_decode($redsZipCode);
        }

        $response = Http::get("https://viacep.com.br/ws/{$zipCoded}/json/");

        if (!$response->json("erro")) {

            $zipCoded = $response->object()->cep;
            $zipCoded = str_replace("-", "", $zipCoded);

            Redis::set("cep:{$zipCoded}:json", json_encode($response->json()));

            return $response->json();
        }

        return response(
            [
                'error' => 'CEP não encotrado!'
            ],
            422
        );
    }
}
