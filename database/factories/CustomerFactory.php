<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $document = Document::factory()->create([
            'document' => $this->faker->cpf(false),
        ]);
        $uuid = $this->faker->uuid();

        Wallet::factory()->create([
           'user_id' => $uuid
        ]);

        return [
            'uuid' => $uuid,
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'document_id' => $document->id,
            'password' => static::$password ??= Hash::make('senha123'),
        ];
    }
}
