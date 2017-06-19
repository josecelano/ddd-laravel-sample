<?php

namespace Mfa\Domain\Event;

use League\Event\AbstractEvent;
use League\Event\EventInterface;
use Mfa\Domain\Wishlist;

class WishlistWasCreated extends AbstractEvent implements EventInterface
{
    /** @var  Wishlist */
    private $wishlist;

    /**
     * WishlistWasCreated constructor.
     * @param Wishlist $wishlist
     */
    public function __construct(Wishlist $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    /**
     * @return Wishlist
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }
}