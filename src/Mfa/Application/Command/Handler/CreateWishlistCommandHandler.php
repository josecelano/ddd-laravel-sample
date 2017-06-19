<?php

namespace Mfa\Application\Command\Handler;

use League\Event\EmitterInterface;
use Mfa\Application\Command\CreateWishlistCommand;
use Mfa\Domain\UserId;
use Mfa\Domain\Wishlist;
use Mfa\Domain\WishlistId;
use Mfa\Domain\WishlistRepository;

class CreateWishlistCommandHandler
{
    /** @var  WishlistRepository */
    private $wishlistRepository;

    /** @var EmitterInterface */
    private $emitter;

    /**
     * UpdateOrCreateApplianceCommandHandler constructor.
     * @param WishlistRepository $wishlistRepository
     * @param EmitterInterface $emitter
     */
    public function __construct(WishlistRepository $wishlistRepository, EmitterInterface $emitter)
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->emitter = $emitter;
    }

    /**
     * @param CreateWishlistCommand $command
     */
    public function handle(CreateWishlistCommand $command)
    {
        $wishlist = new Wishlist(
            WishlistId::fromString($command->getWishlistId()),
            UserId::fromString($command->getUserId())
        );

        $this->emitter->emitGeneratedEvents($wishlist);
        $this->wishlistRepository->save($wishlist);
    }
}