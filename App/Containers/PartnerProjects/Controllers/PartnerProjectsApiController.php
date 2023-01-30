<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Controllers;

use App\Containers\PartnerProjects\Actions\CreatePartnerProjectAction;
use App\Containers\PartnerProjects\Actions\DeletePartnerProjectAction;
use App\Containers\PartnerProjects\Actions\GetAllPartnerProjectsAction;
use App\Containers\PartnerProjects\Actions\GetPartnerProjectAction;
use App\Containers\PartnerProjects\Actions\UpdatePartnerProjectAction;
use App\Containers\PartnerProjects\Requests\PartnerProjectRequestFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\PartnerProjects
 */
final class PartnerProjectsApiController
{
    /**
     * GET: Get collection of PartnerProjects.
     *
     * @param GetAllPartnerProjectsAction $getAllAction
     * @param int|string $partnerId
     * @return JsonResponse
     */
    public function index(GetAllPartnerProjectsAction $getAllAction, int|string $partnerId): JsonResponse
    {
        return new JsonResponse($getAllAction->query((int) $partnerId)->getAll()->toArray());
    }

    /**
     * GET: Get single PartnerProject.
     *
     * @param GetPartnerProjectAction $getAction
     * @param int|string $partnerId
     * @param int|string $partnerProjectId
     *
     * @return JsonResponse
     */
    public function show(
        GetPartnerProjectAction $getAction,
        int|string $partnerId,
        int | string $partnerProjectId
    ): JsonResponse {
        $partnerProject = $getAction->run((int) $partnerProjectId);

        return new JsonResponse($partnerProject->toArray());
    }

    /**
     * POST: Store new PartnerProject.
     *
     * @param PartnerProjectRequestFilter $requestFilter
     * @param CreatePartnerProjectAction $createAction
     * @param Request $request
     * @param int|string $partnerId
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(
        PartnerProjectRequestFilter $requestFilter,
        CreatePartnerProjectAction $createAction,
        Request $request,
        int|string $partnerId,
    ): JsonResponse {
        $data = $requestFilter->getValidatedData($request);
        $partnerProject = $createAction->run($data);

        return new JsonResponse($partnerProject->toArray(), 201);
    }

    /**
     * PUT/PATCH: Update PartnerProject.
     *
     * @param PartnerProjectRequestFilter $requestFilter
     * @param GetPartnerProjectAction $getAction ,
     * @param UpdatePartnerProjectAction $updateAction
     * @param Request $request
     * @param int|string $partnerId
     * @param int|string $partnerProjectId
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(
        PartnerProjectRequestFilter $requestFilter,
        GetPartnerProjectAction $getAction,
        UpdatePartnerProjectAction $updateAction,
        Request $request,
        int|string $partnerId,
        int | string $partnerProjectId
    ): JsonResponse {
        $partnerProject = $getAction->run((int) $partnerProjectId);

        $data = $requestFilter->getValidatedData($request, $partnerProject);
        $partnerProject = $updateAction->run($partnerProject, $data);

        return new JsonResponse($partnerProject->toArray());
    }

    /**
     * DELETE: Delete PartnerProject.
     *
     * @param GetPartnerProjectAction $getAction
     * @param DeletePartnerProjectAction $deleteAction ,
     * @param int|string $partnerId
     * @param int|string $partnerProjectId
     *
     * @return JsonResponse
     *
     * @throws \Throwable
     */
    public function destroy(
        GetPartnerProjectAction $getAction,
        DeletePartnerProjectAction $deleteAction,
        int|string $partnerId,
        int | string $partnerProjectId
    ): JsonResponse {
        $partnerProject = $getAction->run((int) $partnerProjectId);

        $deleteAction->run($partnerProject);

        return new JsonResponse([], 204);
    }
}
