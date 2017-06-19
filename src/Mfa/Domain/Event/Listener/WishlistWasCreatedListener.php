<?php

namespace Mfa\Domain\Event\Listener;

use App\Repositories\Frontend\Wishlist\WishlistRepository;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Mfa\Domain\Event\WishlistWasCreated;
use Mfa\Domain\Wishlist;

class WishlistWasCreatedListener extends AbstractListener
{
    /** @var  WishlistRepository */
    private $wishlistRepository;

    /**
     * WishlistWasCreatedListener constructor.
     * @param WishlistRepository $wishlistRepository
     */
    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * @param EventInterface|WishlistWasCreated $event
     */
    public function handle(EventInterface $event)
    {
        $wishlist = $event->getWishlist();
        $this->createReadModel($wishlist);
    }

    /**
     * @param Wishlist $wishlist
     */
    private function createReadModel(Wishlist $wishlist)
    {
        $this->wishlistRepository->create([
            'wishlist_id' => $wishlist->getId()->getValue(),
            'user_id' => $wishlist->getUserId()->getValue(),
        ]);
    }
}