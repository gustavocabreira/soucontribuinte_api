<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntidadeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fecth_uf() {
        $user = User::factory()->create();
        $token = $user->createToken('user_token')->plainTextToken;

        $response = $this->json('GET', route('entidades.getUf'), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertOk();
    }
}
