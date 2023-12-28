<?php

namespace Database\Factories;

use App\Models\Container;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use OvhSwift\Domains\ContainerManager;
use OvhSwift\Interfaces\SPI\IUseContainers;
use Ramsey\Uuid\Uuid;

class ContainerFactory extends Factory implements IUseContainers
{
    public function configure(): static
    {
        return $this->afterMaking(function (Container $container) {
            (new ContainerManager($this))->createContainer($container->name);
        });
    }

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

    /**
     * @param string $containerName
     * @return bool
     */
    public function validateContainerName(string $containerName): bool
    {
        return true;
    }
}
