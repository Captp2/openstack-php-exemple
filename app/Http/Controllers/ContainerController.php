<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListContainerRequest;
use App\Models\Container;
use JetBrains\PhpStorm\ArrayShape;

class ContainerController extends Controller
{
    /**
     * @param ListContainerRequest $request
     * @return array
     */
    #[ArrayShape(['containers' => "mixed"])] public function index(ListContainerRequest $request): array
    {
        return [
            'containers' => Container::where(['user_id' => $request->get('user_id')])->get()
        ];
    }
}
