<?php

declare(strict_types=1);

namespace App\Containers\Locations\Controllers;

use App\Containers\Locations\Actions\CreateLocationAction;
use App\Containers\Locations\Actions\DeleteLocationAction;
use App\Containers\Locations\Actions\GetAllLocationsAction;
use App\Containers\Locations\Actions\GetLocationAction;
use App\Containers\Locations\Actions\UpdateLocationAction;
use App\Containers\Locations\Requests\LocationRequestFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\Locations
 */
final class LocationsApiController
{
    /**
     * GET: Get collection of Locations.
     *
     * @param GetAllLocationsAction $getAllAction
     *
     * @return JsonResponse
     */
    public function index(GetAllLocationsAction $getAllAction): JsonResponse
    {
        return new JsonResponse($getAllAction->query()->getAll()->toArray());
    }

    /**
     * GET: Get single Location.
     *
     * @param GetLocationAction $getAction
     * @param int|string $locationId
     *
     * @return JsonResponse
     */
    public function show(GetLocationAction $getAction, int | string $locationId): JsonResponse
    {
        $location = $getAction->run((int) $locationId);

        return new JsonResponse($location->toArray());
    }

    /**
     * POST: Store new Location.
     *
     * @param LocationRequestFilter $requestFilter
     * @param CreateLocationAction $createAction
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(
        LocationRequestFilter $requestFilter,
        CreateLocationAction $createAction,
        Request $request
    ): JsonResponse {
        $data = $requestFilter->getValidatedData($request);
        $location = $createAction->run($data);

        return new JsonResponse($location->toArray(), 201);
    }

    /**
     * PUT/PATCH: Update Location.
     *
     * @param LocationRequestFilter $requestFilter
     * @param GetLocationAction $getAction ,
     * @param UpdateLocationAction $updateAction
     * @param Request $request
     * @param int|string $locationId
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(
        LocationRequestFilter $requestFilter,
        GetLocationAction $getAction,
        UpdateLocationAction $updateAction,
        Request $request,
        int | string $locationId
    ): JsonResponse {
        $location = $getAction->run((int) $locationId);

        $data = $requestFilter->getValidatedData($request, $location);
        $location = $updateAction->run($location, $data);

        return new JsonResponse($location->toArray());
    }

    /**
     * DELETE: Delete Location.
     *
     * @param GetLocationAction $getAction
     * @param DeleteLocationAction $deleteAction ,
     * @param int|string $locationId
     *
     * @return JsonResponse
     *
     * @throws \Throwable
     */
    public function destroy(
        GetLocationAction $getAction,
        DeleteLocationAction $deleteAction,
        int | string $locationId
    ): JsonResponse {
        $location = $getAction->run((int) $locationId);

        $deleteAction->run($location);

        return new JsonResponse([], 204);
    }
}
