<?php

namespace Mfa\Domain\Event\Listener;

use App\Repositories\Frontend\Appliance\ApplianceRepository;
use App\Repositories\Frontend\Wishlist\WishlistRepository;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Mfa\Domain\ApplianceId;
use Mfa\Domain\Event\ApplianceWasAddedToWishlist;
use Mfa\Domain\Wishlist;

class ApplianceWasAddedToWishlistListener extends AbstractListener
{
    /** @var  WishlistRepository */
    private $wishlistRepository;

    /** @var  ApplianceRepository */
    private $applianceRepository;

    /**
     * ApplianceWasAddedToWishlistListener constructor.
     * @param WishlistRepository $wishlistRepository
     * @param ApplianceRepository $applianceRepository
     */
    public function __construct(WishlistRepository $wishlistRepository, ApplianceRepository $applianceRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->applianceRepository = $applianceRepository;
    }

    /**
     * @param EventInterface|ApplianceWasAddedToWishlist $event
     */
    public function handle(EventInterface $event)
    {
        $wishlist = $event->getWishlist();
        $applianceId = $event->getApplianceId();
        $this->updateReadModel($wishlist, $applianceId);
    }

    /**
     * @param Wishlist $wishlist
     * @param ApplianceId $applianceId
     */
    private function updateReadModel(Wishlist $wishlist, ApplianceId $applianceId)
    {
        $wishlistReadModel = $this->wishlistRepository->findOrCreateById($wishlist->getId(), $wishlist->getUserId());
        $applianceReadModel = $this->applianceRepository->findById($applianceId);

        /** @noinspection PhpUndefinedMethodInspection */
        if (!$wishlistReadModel->appliances->contains($applianceReadModel->id)) {
            $wishlistReadModel->appliances()->attach($applianceReadModel->id);
        }

        $wishlistReadModel->save();
    }
}