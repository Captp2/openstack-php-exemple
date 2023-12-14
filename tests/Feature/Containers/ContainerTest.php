<?php

namespace Tests\Feature\Containers;

use Tests\TestCase;

class ContainerTest extends TestCase
{
    const CONTAINER_NAME = 'test-container';

    public function testICanListContainers()
    {
//        $containers =
//
        $fetchedContainers = $this->get('/api/containers');

        $this->assertIsArray($fetchedContainers->json('containers'));
        $lastContainer = $fetchedContainers[count($fetchedContainers->json('containers')) - 1];
        $this->assertEquals([
            'name' => self::CONTAINER_NAME,
            'owner' => [

            ]
        ], $lastContainer);
    }
}
