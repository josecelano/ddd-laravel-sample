<?php

namespace Mfa\Infrastructure;

use Illuminate\Support\ServiceProvider;
use League\Event\Emitter;
use League\Event\EmitterInterface;
use Mfa\Domain\Event\ApplianceWasAddedToWishlist;
use Mfa\Domain\Event\ApplianceWasCreated;
use Mfa\Domain\Event\ApplianceWasRemovedFromWishlist;
use Mfa\Domain\Event\ApplianceWasUpdated;
use Mfa\Domain\Event\Listener\ApplianceWasAddedToWishlistListener;
use Mfa\Domain\Event\Listener\ApplianceWasCreatedListener;
use Mfa\Domain\Event\Listener\ApplianceWasRemovedFromWishlistListener;
use Mfa\Domain\Event\Listener\ApplianceWasUpdatedListener;
use Mfa\Domain\Event\Listener\WishlistWasCreatedListener;
use Mfa\Domain\Event\WishlistWasCreated;

class EventBusProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Emitter::class, function () {
            return new Emitter();
        });
        $this->app->bind('League\Event\EmitterInterface', Emitter::class);
    }

    /**
     * @param EmitterInterface $emitter
     */
    public function boot(EmitterInterface $emitter)
    {
        $this->registerEventListeners($emitter);

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Emitter::class,
        ];
    }

    /**
     * @param EmitterInterface $emitter
     */
    private function registerEventListeners(EmitterInterface $emitter)
    {
        $emitter->addListener(ApplianceWasCreated::class, $this->app->make(ApplianceWasCreatedListener::class));
        $emitter->addListener(ApplianceWasUpdated::class, $this->app->make(ApplianceWasUpdatedListener::class));
        $emitter->addListener(ApplianceWasAddedToWishlist::class, $this->app->make(ApplianceWasAddedToWishlistListener::class));
        $emitter->addListener(ApplianceWasRemovedFromWishlist::class, $this->app->make(ApplianceWasRemovedFromWishlistListener::class));
        $emitter->addListener(WishlistWasCreated::class, $this->app->make(WishlistWasCreatedListener::class));
    }
}