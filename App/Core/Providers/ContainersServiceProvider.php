<?php

declare(strict_types=1);

namespace App\Core\Providers;

use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Instances\Repositories\InstancesRepository;
use App\Containers\Locations\Contracts\LocationsRepositoryInterface;
use App\Containers\Locations\Repositories\LocationsRepository;
use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use App\Containers\PartnerProjects\Repositories\PartnerProjectsRepository;
use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Repositories\PartnersRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class ContainersServiceProvider
 *
 * @package App\Core\Providers
 */
final class ContainersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerInstancesContainer();

        $this->registerPartnersContainer();

        $this->registerLocationsContainer();
    }

    private function registerInstancesContainer(): void
    {
        $this->app->bind(
            InstancesRepositoryInterface::class,
            InstancesRepository::class
        );
    }

    private function registerPartnersContainer(): void
    {
        $this->app->bind(
            PartnersRepositoryInterface::class,
            PartnersRepository::class
        );

        $this->app->bind(
            PartnerProjectsRepositoryInterface::class,
            PartnerProjectsRepository::class
        );
    }

    private function registerLocationsContainer(): void
    {
        $this->app->bind(
            LocationsRepositoryInterface::class,
            LocationsRepository::class
        );
    }
}
