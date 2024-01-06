<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_when_is_customer(): void
    {
        $payload = [
            'name' => 'lucas',
            'surname' => 'mendes',
            'email' => 'lucas@yopmail.com',
            'password' => 'lucas123',
            'document' => '00000000000'
        ];

        $response = $this->post('/api/user/customer', $payload);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'User created Successfully');
            $json->whereType('id', 'string');
        });

        $response->assertStatus(200);
    }

    public function test_create_user_when_is_shopkeeper(): void
    {
        $payload = [
            'name' => 'lucas',
            'surname' => 'mendes',
            'email' => 'lucas@yopmail.com',
            'password' => 'lucas123',
            'document' => '00000000000000'
        ];

        $response = $this->post('/api/user/shopkeeper', $payload);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('message', 'User created Successfully');
            $json->whereType('id', 'string');
        });

        $response->assertStatus(200);
    }

    public function test_dont_create_user_when_user_type_is_not_found(): void
    {
        $payload = [
            'name' => 'lucas',
            'surname' => 'mendes',
            'email' => 'lucas@yopmail.com',
            'password' => 'lucas123',
            'document' => '00000000000'
        ];

        $response = $this->post('/api/user/test', $payload);
        $response->assertStatus(404);
        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('error.message', 'string');
            $json->where('error.message', 'The provided user type was not found');
        });
    }

    public function test_dont_create_user_when_validation_failed(): void
    {
        $payload = [
            'name' => 'lucas',
            'surname' => 'mendes',
            'email' => 'lucas',
            'password' => 'lucas123',
            'document' => '00000000000'
        ];

        $response = $this->post('/api/user/customer', $payload);
        $response->assertStatus(422);
        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('error', 'boolean');
            $json->whereType('message', 'string');
        });
    }

    public function test_list_all_users()
    {
        $customer = Customer::factory()->create()->first();

        $response = $this->get('/api/user');
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($customer) {
            $json->where('data.0', [
                "uuid" => $customer->uuid,
                "name" => $customer->name,
                "surname" => $customer->surname,
                "email" => $customer->email,
                "created_at" => $customer->created_at->toISOString(),
                "updated_at" => $customer->updated_at->toISOString(),
                "document_id" => $customer->document_id,
            ]);
        });
    }

    public function test_list_is_empty()
    {
        $response = $this->get('/api/user');
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('data', []);
        });
    }
}
