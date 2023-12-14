<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContainerRequest;
use App\Http\Requests\ListContainerRequest;
use App\Models\Container;
use App\Models\User;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;

class ContainerController extends Controller
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

        (new Container([
            'uuid' => Uuid::uuid4(),
            'name' => $request->get('name'),
            'user_id' => $request->get('user_id')
        ]))->save();

        return response()->noContent(Response::HTTP_CREATED);
    }
}
