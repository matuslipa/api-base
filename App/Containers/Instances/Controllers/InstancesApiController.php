<?php

declare(strict_types=1);

namespace App\Containers\Instances\Controllers;

use App\Containers\Instances\Actions\CreateInstanceAction;
use App\Containers\Instances\Actions\DeleteInstanceAction;
use App\Containers\Instances\Actions\GetAllInstancesAction;
use App\Containers\Instances\Actions\GetInstanceAction;
use App\Containers\Instances\Actions\UpdateInstanceAction;
use App\Containers\Instances\Requests\InstanceRequestFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\Instances
 */
final class InstancesApiController
{
    /**
     * GET: Get collection of Instances.
     *
     * @param GetAllInstancesAction $getAllAction
     *
     * @return JsonResponse
     */
    public function index(GetAllInstancesAction $getAllAction): JsonResponse
    {
        return new JsonResponse($getAllAction->query()->getAll()->toArray());
    }

    /**
     * GET: Get single Instance.
     *
     * @param GetInstanceAction $getAction
     * @param int|string $instanceId
     *
     * @return JsonResponse
     */
    public function show(GetInstanceAction $getAction, int | string $instanceId): JsonResponse
    {
        $instance = $getAction->run((int) $instanceId);

        return new JsonResponse($instance->toArray());
    }

    /**
     * POST: Store new Instance.
     *
     * @param InstanceRequestFilter $requestFilter
     * @param CreateInstanceAction $createAction
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(
        InstanceRequestFilter $requestFilter,
        CreateInstanceAction $createAction,
        Request $request
    ): JsonResponse {
        $data = $requestFilter->getValidatedData($request);
        $instance = $createAction->run($data);

        return new JsonResponse($instance->toArray(), 201);
    }

    /**
     * PUT/PATCH: Update Instance.
     *
     * @param InstanceRequestFilter $requestFilter
     * @param GetInstanceAction $getAction ,
     * @param UpdateInstanceAction $updateAction
     * @param Request $request
     * @param int|string $instanceId
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(
        InstanceRequestFilter $requestFilter,
        GetInstanceAction $getAction,
        UpdateInstanceAction $updateAction,
        Request $request,
        int | string $instanceId
    ): JsonResponse {
        $instance = $getAction->run((int) $instanceId);

        $data = $requestFilter->getValidatedData($request, $instance);
        $instance = $updateAction->run($instance, $data);

        return new JsonResponse($instance->toArray());
    }

    /**
     * DELETE: Delete Instance.
     *
     * @param GetInstanceAction $getAction
     * @param DeleteInstanceAction $deleteAction ,
     * @param int|string $instanceId
     *
     * @return JsonResponse
     *
     * @throws \Throwable
     */
    public function destroy(
        GetInstanceAction $getAction,
        DeleteInstanceAction $deleteAction,
        int | string $instanceId
    ): JsonResponse {
        $instance = $getAction->run((int) $instanceId);

        $deleteAction->run($instance);

        return new JsonResponse([], 204);
    }
}
