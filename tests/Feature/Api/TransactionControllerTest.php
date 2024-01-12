<?php

namespace Feature\Api;

use App\Enums\UserTypeEnum;
use App\Models\Customer;
use App\Models\Shopkeeper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_transaction_as_a_shopkeeper()
    {
        $shopkeeper = Shopkeeper::factory()->create()->first();

        $currentUser = Shopkeeper::factory()->create()->first();

        $payload = [
            'amount' => 10,
            'payee' => $shopkeeper->uuid,
            'userType' => UserTypeEnum::shopkeeper->value
        ];

        $token = $currentUser->createToken(UserTypeEnum::shopkeeper->value)->plainTextToken;

        $headers = [
            'accept' => 'application/json',
            'authorization' => "Bearer {$token}"
        ];

        $response = $this->post('/api/transaction/pay', $payload, $headers);

        $response->assertStatus(401);
    }

    public function test_transaction_with_empty_wallet()
    {
        $customer = Customer::factory()->create()->first();

        $shopkeeper = Shopkeeper::factory()->create()->first();

        $payload = [
            'amount' => 2000,
            'payee' => $shopkeeper->uuid,
            'userType' => UserTypeEnum::shopkeeper->value
        ];

        $token = $customer->createToken('shopkeeper')->plainTextToken;

        $headers = [
            'accept' => 'application/json',
            'authorization' => "Bearer {$token}"
        ];

        $response = $this->post('/api/transaction/pay', $payload, $headers);

        $response->assertStatus(401);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('message', 'string');
            $json->where('message', 'Insufficient Balance');
        });
    }

    public function test_transaction_successfully()
    {
        $customer = Customer::factory()->create()->first();

        $amount = 30;

        $customer->wallet()->update(['balance' => $amount]);

        $shopkeeper = Shopkeeper::factory()->create()->first();

        $shopkeeper->wallet()->update(['balance' => $amount]);

        $shopkeeperWalletBefore = $shopkeeper->wallet()->first();

        $shopkeeperBalanceBefore = $shopkeeperWalletBefore->balance;

        $payload = [
            'amount' => $amount,
            'payee' => $shopkeeper->uuid,
            'userType' => UserTypeEnum::shopkeeper->value
        ];

        $token = $customer->createToken(UserTypeEnum::customer->value)->plainTextToken;

        $headers = [
            'accept' => 'application/json',
            'authorization' => "Bearer {$token}"
        ];

        $response = $this->post('/api/transaction/pay', $payload, $headers);

        $response->assertStatus(200);

        $shopkeeperWallet = $shopkeeper->wallet()->first();

        $expectedBalance = $shopkeeperBalanceBefore + $amount; //60

        $this->assertEquals($expectedBalance, $shopkeeperWallet->balance);

        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('message', 'string');
            $json->where('message', 'transaction completed successfully!');
        });
    }
}
