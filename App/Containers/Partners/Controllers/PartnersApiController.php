<?php

declare(strict_types=1);

namespace App\Containers\Partners\Controllers;

use App\Containers\Partners\Actions\CreatePartnerAction;
use App\Containers\Partners\Actions\DeletePartnerAction;
use App\Containers\Partners\Actions\GetAllPartnersAction;
use App\Containers\Partners\Actions\GetPartnerAction;
use App\Containers\Partners\Actions\UpdatePartnerAction;
use App\Containers\Partners\Requests\PartnerRequestFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\Partners
 */
final class PartnersApiController
{
    /**
     * GET: Get collection of Partners.
     *
     * @param GetAllPartnersAction $getAllAction
     *
     * @return JsonResponse
     */
    public function index(GetAllPartnersAction $getAllAction): JsonResponse
    {
        return new JsonResponse($getAllAction->query()->getAll()->toArray());
    }

    /**
     * GET: Get single Partner.
     *
     * @param GetPartnerAction $getAction
     * @param int|string $partnerId
     *
     * @return JsonResponse
     */
    public function show(GetPartnerAction $getAction, int|string $partnerId): JsonResponse
    {
        $partner = $getAction->run((int) $partnerId);

        return new JsonResponse($partner->toArray());
    }

    /**
     * POST: Store new Partner.
     *
     * @param PartnerRequestFilter $requestFilter
     * @param CreatePartnerAction $createAction
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(
        PartnerRequestFilter $requestFilter,
        CreatePartnerAction $createAction,
        Request $request
    ): JsonResponse {
        $data = $requestFilter->getValidatedData($request);
        $partner = $createAction->run($data);

        return new JsonResponse($partner->toArray(), 201);
    }

    /**
     * PUT/PATCH: Update Partner.
     *
     * @param PartnerRequestFilter $requestFilter
     * @param GetPartnerAction $getAction ,
     * @param UpdatePartnerAction $updateAction
     * @param Request $request
     * @param int|string $partnerId
     **
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(
        PartnerRequestFilter $requestFilter,
        GetPartnerAction $getAction,
        UpdatePartnerAction $updateAction,
        Request $request,
        int|string $partnerId
    ): JsonResponse {
        $partner = $getAction->run((int) $partnerId);

        $data = $requestFilter->getValidatedData($request, $partner);
        $partner = $updateAction->run($partner, $data);

        return new JsonResponse($partner->toArray());
    }

    /**
     * DELETE: Delete Partner.
     *
     * @param GetPartnerAction $getAction
     * @param DeletePartnerAction $deleteAction ,
     * @param int|string $partnerId
     *
     * @return JsonResponse
     *
     * @throws \Throwable
     */
    public function destroy(
        GetPartnerAction $getAction,
        DeletePartnerAction $deleteAction,
        int|string $partnerId
    ): JsonResponse {
        $partner = $getAction->run((int) $partnerId);

        $deleteAction->run($partner);

        return new JsonResponse([], 204);
    }
}
