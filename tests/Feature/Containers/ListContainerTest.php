<?php

namespace Tests\Feature\Containers;

use App\Models\Container;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListContainerTest extends TestCase
{
    use RefreshDatabase;

    public function testICanListContainers(): void
    {
        User::factory()->count(2)->create();
        $user = User::query()->first();
        $containers = Container::factory(['user_id' => $user->id])->count(5)->create();
        $container = $containers->last();

        $fetchedContainers = $this->get('/api/containers?user_id=' . $user->id)->json('containers');

        $this->assertIsArray($fetchedContainers);
        $lastContainer = $fetchedContainers[count($fetchedContainers) - 1];
        $this->assertEquals([
            'name' => $container->name,
            'uuid' => (string) $container->uuid,
            'user_id' => $user->id,
            'created_at' => $container->created_at->format("Y-m-d\TH:i:s.u\Z"),
            'updated_at' => $container->updated_at->format("Y-m-d\TH:i:s.u\Z"),
            'owner' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at->format("Y-m-d\TH:i:s.u\Z"),
                'created_at' => $user->created_at->format("Y-m-d\TH:i:s.u\Z"),
                'updated_at' => $user->updated_at->format("Y-m-d\TH:i:s.u\Z"),
            ]
        ], $lastContainer);
    }
}
