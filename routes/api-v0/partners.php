<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Resource: Partners
Route::apiResource(
    'partners',
    \App\Containers\Partners\Controllers\PartnersApiController::class
)
    ->only(['index', 'store', 'update', 'destroy', 'show'])
    ->parameters([
        'partners' => 'partnerId',
    ]);
Route::apiResource(
    'partners/{partnerId}/projects',
    \App\Containers\PartnerProjects\Controllers\PartnerProjectsApiController::class
)
    ->only(['index', 'store', 'update', 'destroy', 'show'])
    ->parameters([
        'projects' => 'projectId',
    ]);
