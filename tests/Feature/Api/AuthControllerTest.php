<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use App\Models\Shopkeeper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_wrong_provider(): void
    {
        $payload = [
            'email' => 'lucas@yopmail.com',
            'password' => 'lucas123'
        ];

        $response = $this->post('/api/auth/teste', $payload);

        $response->assertStatus(404);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('error.message', 'string');
            $json->where('error.message', 'The provided provider was not found');
        });
    }

    public function test_login_with_wrong_credentials(): void
    {
        $user = Customer::factory()->create()->first();

        $payload = [
            'email' => $user->email,
            'password' => 'test'
        ];

        $response = $this->post('/api/auth/customer', $payload);

        $response->assertStatus(401);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('error.message', 'string');
            $json->where('error.message', 'Wrong credentials. Incorrect email or password');
        });
    }

    public function test_login_with_success_customer(): void
    {
        $user = Customer::factory()->create()->first();

        $payload = [
            'email' => $user->email,
            'password' => 'senha123'
        ];

        $response = $this->post('/api/auth/customer', $payload);


        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('token', 'string');
        });
    }

    public function test_login_with_success_shopkeeper(): void
    {
        $user = Shopkeeper::factory()->create()->first();

        $payload = [
            'email' => $user->email,
            'password' => 'senha123'
        ];

        $response = $this->post('/api/auth/shopkeeper', $payload);


        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('token', 'string');
        });
    }
}
