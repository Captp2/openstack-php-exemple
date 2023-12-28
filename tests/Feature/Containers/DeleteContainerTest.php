<?php

namespace Tests\Feature\Containers;

use App\Models\Container;
use App\Models\User;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\AbstractTester;

class DeleteContainerTest extends AbstractTester
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testICanDeleteAContainer(): void
    {
        $user = User::factory()->create();
        $container = Container::factory(['user_id' => $user->id])->create();

        $this->delete("/api/containers/{$container->uuid}")
            ->assertStatus(204);
    }

    /**
     * @return void
     */
    public function testICantDeleteAnUnknownContainer(): void
    {
        $this->delete("/api/containers/" . self::$faker->uuid())
            ->assertStatus(404);
    }
}
