<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $userPayload = [
        'email' => 'gustavo.softdev@gmail.com',
        'name' => 'Gustavo Cabreira',
        'password' => '12345678'
    ];

    public function test_user_can_register()
    {
        $response = $this->register();
        $response->assertCreated();

        $user = $response->json();

        $this->assertDatabaseHas('users', ['id' => $user['id']]);
    }

    public function test_user_can_login() {
        $this->register();
        
        $response = $this->json('POST', route('users.login'), $this->userPayload);
        $response->assertSuccessful();
    }

    private function register() {
        return $this->json('POST', route('users.create'), $this->userPayload);
    }
}
