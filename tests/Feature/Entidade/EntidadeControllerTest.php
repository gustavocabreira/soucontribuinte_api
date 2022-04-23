<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntidadeControllerTest extends TestCase
{
    use RefreshDatabase;

    private $token = null;

    public function test_can_fetch_uf(): void
    {
        $response = $this->makeRequest('GET', route('entidades.getUf'));
        $response->assertOk();
    }

    public function test_can_fetch_entidades(): void
    {
        $response = $this->makeRequest('GET', route('entidades.index'));
        $response->assertOk();
    }

    private function generateBearerToken(): string
    {
        $user = User::factory()->create();
        $this->token = $user->createToken('user_token')->plainTextToken;
        return $this->token;
    }

    private function makeRequest(string $method, string $route, array $params = [])
    {
        $token = $this->token ?? $this->generateBearerToken();
        return $this->json($method, $route, $params, [
            'Authorization' => "Bearer {$token}"
        ]);
    }
}
