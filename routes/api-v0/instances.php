<?php

declare(strict_types=1);

// Resource: Instances
\Illuminate\Support\Facades\Route::apiResource(
    'instances',
    \App\Containers\Instances\Controllers\InstancesApiController::class
)
    ->only(['index', 'store', 'update', 'destroy', 'show'])
    ->parameters([
        'instances' => 'instanceId',
    ]);
