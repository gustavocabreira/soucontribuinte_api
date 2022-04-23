<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
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
            throw new Exception('Failed when fetching ufs', 500);
        }

        $ufs = collect($response->json()['data']);
        
        return response()->json($ufs, 200);
    }
}
