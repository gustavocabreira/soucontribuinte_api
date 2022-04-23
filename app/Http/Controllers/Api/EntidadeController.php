<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetEntidadeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EntidadeController extends Controller
{
    private string $endpoint = '';

    public function __construct()
    {
        $this->endpoint = config('api.soucontribuinte_address');
    }

    public function getUf()
    {
        $params = [
            'ocorrencia' => 'listarUf'
        ];

        $response = Http::post($this->endpoint . "/api.php", $params);

        if($response->failed()) {
            throw new \Exception('Failed when fetching ufs', 500);
        }

        $ufs = collect($response->json()['data']);
        
        return response()->json($ufs, 200);
    }

    public function index(GetEntidadeRequest $request)
    {
        $params = [
            'ocorrencia' => 'listarEntidades'
        ];

        $response = Http::post($this->endpoint . "/api.php", $params);

        if($response->failed()) {
            throw new \Exception('Failed when fetching ufs', 500);
        }

        $entidades = collect($response->json()['data']);

        if($request->input('uf')) {
            $uf = $request->input('uf');

            $entidades = $entidades->filter(function($entidade) use($uf) {
                return strtoupper($entidade['state']) === strtoupper($uf);
            })->values();
        }

        return response()->json($entidades, 200);

    }
}
