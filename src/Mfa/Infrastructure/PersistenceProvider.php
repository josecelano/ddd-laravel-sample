<?php

namespace Mfa\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Mfa\Domain\ApplianceRepository;
use Mfa\Domain\WishlistRepository;

class PersistenceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Mfa\Domain\WishlistRepository',
            'Mfa\Infrastructure\Persistence\Eloquent\EloquentWishlistRepository'
        );
        $this->app->bind(
            'Mfa\Domain\ApplianceRepository',
            'Mfa\Infrastructure\Persistence\Eloquent\EloquentApplianceRepository'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            WishlistRepository::class,
            ApplianceRepository::class,
        ];
    }
}