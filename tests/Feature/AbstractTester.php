<?php

namespace Tests\Feature;

use OvhSwift\Domains\ContainerManager;
use OvhSwift\Interfaces\SPI\IUseContainers;
use Tests\TestCase;

class AbstractTester extends TestCase implements IUseContainers
{
    const CONTAINER_NAME_APPLE = 'Apple';
    const CONTAINER_NAME_STRAWBERRY = 'Strawberry';

    public array $containerNames = [
        self::CONTAINER_NAME_APPLE,
        self::CONTAINER_NAME_STRAWBERRY,
    ];

    /**
     * @return void
     */
    public function tearDown(): void
    {
        $swiftContainers = ($containerManager = new ContainerManager($this))->listContainers();

        foreach ($swiftContainers as $swiftContainer) {
            if (!in_array($swiftContainer->name, $this->containerNames)) {
                try {
                $containerManager->deleteContainer($swiftContainer->name, true);
                } catch (\Exception $e) {}
            }
        }
    }

    public function validateContainerName(string $containerName): bool
    {
        return true;
    }
}
