<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Resource: Locations
Route::apiResource(
    'locations',
    \App\Containers\Locations\Controllers\LocationsApiController::class
)
    ->only(['index', 'store', 'update', 'destroy', 'show'])
    ->parameters([
        'locations' => 'locationId',
    ]);
