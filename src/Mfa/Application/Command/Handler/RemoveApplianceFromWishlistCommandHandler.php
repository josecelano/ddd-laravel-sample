<?php

namespace Mfa\Application\Command\Handler;

use League\Event\EmitterInterface;
use Mfa\Application\Command\RemoveApplianceFromWishlistCommand;
use Mfa\Domain\ApplianceId;
use Mfa\Domain\UserId;
use Mfa\Domain\WishlistRepository;

class RemoveApplianceFromWishlistCommandHandler
{
    /** @var  WishlistRepository */
    private $wishlistRepository;

    /** @var EmitterInterface */
    private $emitter;

    /**
     * RemoveApplianceFromWishlistCommandHandler constructor.
     * @param WishlistRepository $wishlistRepository
     * @param EmitterInterface $emitter
     */
    public function __construct(WishlistRepository $wishlistRepository, EmitterInterface $emitter)
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->emitter = $emitter;
    }

    /**
     * @param RemoveApplianceFromWishlistCommand $command
     */
    public function handle(RemoveApplianceFromWishlistCommand $command)
    {
        $wishlist = $this->wishlistRepository->findByUserId(UserId::fromString($command->getUserId()));
        $wishlist->removeAppliance(ApplianceId::fromString($command->getApplianceId()));
        $this->emitter->emitGeneratedEvents($wishlist);
        $this->wishlistRepository->save($wishlist);
    }
}