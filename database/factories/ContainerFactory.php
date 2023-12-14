<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class ContainerFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'uuid' => Uuid::uuid4(),
            'user_id' => null,
        ];
    }
}
