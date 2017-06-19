<?php

namespace Mfa\Application\Command\Handler;

use App\Services\Wishlist\WishlistService;
use League\Event\EmitterInterface;
use Mfa\Application\Command\AddApplianceToWishlistCommand;
use Mfa\Domain\ApplianceId;
use Mfa\Domain\UserId;
use Mfa\Domain\WishlistRepository;

class AddApplianceToWishlistCommandHandler
{
    /** @var  WishlistService */
    private $wishlistService;

    /** @var  WishlistRepository */
    private $wishlistRepository;

    /** @var EmitterInterface */
    private $emitter;

    /**
     * AddApplianceToWishlistCommandHandler constructor.
     * @param WishlistService $wishlistService
     * @param WishlistRepository $wishlistRepository
     * @param EmitterInterface $emitter
     */
    public function __construct(
        WishlistService $wishlistService,
        WishlistRepository $wishlistRepository,
        EmitterInterface $emitter
    )
    {
        $this->wishlistService = $wishlistService;
        $this->wishlistRepository = $wishlistRepository;
        $this->emitter = $emitter;
    }

    /**
     * @param AddApplianceToWishlistCommand $command
     */
    public function handle(AddApplianceToWishlistCommand $command)
    {
        $this->wishlistService->makeSureTheUserHasAWishlist($command->getUserId());
        $wishlist = $this->wishlistRepository->findByUserId(UserId::fromString($command->getUserId()));
        $wishlist->addAppliance(ApplianceId::fromString($command->getApplianceId()));
        $this->emitter->emitGeneratedEvents($wishlist);
        $this->wishlistRepository->save($wishlist);
    }
}