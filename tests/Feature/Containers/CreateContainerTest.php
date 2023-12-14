<?php

namespace Tests\Feature\Containers;

use App\Models\Container;
use App\Models\User;
use Faker\Factory;
use Tests\TestCase;

class CreateContainerTest extends TestCase
{
    public function testICanCreateAContainer()
    {
        $user = User::factory()->create();

        $this->post('/api/containers', [
            'name' => Factory::create()->text('52'),
            'user_id' => $user->id
        ])->assertStatus(201);

        $fetchedContainer = $this->get('/api/containers?user_id=' . $user->id)->json('containers')[0];
        $container = Container::where(['user_id' => $user->id])->first();

        $this->assertEquals([
            'name' => $container->name,
            'uuid' => (string)$container->uuid,
            'user_id' => 2,
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
        ], $fetchedContainer);
    }
}
