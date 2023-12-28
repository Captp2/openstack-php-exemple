<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContainerRequest;
use App\Http\Requests\ListContainerRequest;
use App\Models\Container;
use App\Models\User;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use OvhSwift\Domains\ContainerManager;
use OvhSwift\Interfaces\SPI\IUseContainers;
use Ramsey\Uuid\Uuid;

class ContainerController extends Controller implements IUseContainers
{
    /**
     * @param ListContainerRequest $request
     * @return array
     */
    #[ArrayShape(['containers' => "mixed"])] public function index(ListContainerRequest $request): array
    {
        return [
            'containers' => Container::where(['user_id' => $request->get('user_id')])
                ->with('owner')->get()
        ];
    }

    /**
     * @param CreateContainerRequest $request
     * @return Response
     */
    public function create(CreateContainerRequest $request): Response
    {
        User::findOrFail($request->get('user_id'));

        $containerManager = new ContainerManager($this);
        $containerManager->createContainer($request->get('name'));

        (new Container([
            'uuid' => Uuid::uuid4(),
            'name' => $request->get('name'),
            'user_id' => $request->get('user_id')
        ]))->save();

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * @param string $containerName
     * @return bool
     */
    public function validateContainerName(string $containerName): bool
    {
        return (($containerName) && !(strlen($containerName) < 3) && !(strlen($containerName) > 126));
    }
}
