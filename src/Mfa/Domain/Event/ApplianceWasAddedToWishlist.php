<?php

namespace Mfa\Domain\Event;

use League\Event\AbstractEvent;
use League\Event\EventInterface;
use Mfa\Domain\ApplianceId;
use Mfa\Domain\Wishlist;

class ApplianceWasAddedToWishlist extends AbstractEvent implements EventInterface
{
    /** @var  Wishlist */
    private $wishlist;

    /** @var  ApplianceId */
    private $applianceId;

    /**
     * ApplianceWasAddedToWishlist constructor.
     * @param Wishlist $wishlist
     * @param ApplianceId $applianceId
     */
    public function __construct(Wishlist $wishlist, ApplianceId $applianceId)
    {
        $this->wishlist = $wishlist;
        $this->applianceId = $applianceId;
    }

    /**
     * @return Wishlist
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }

    /**
     * @return ApplianceId
     */
    public function getApplianceId()
    {
        return $this->applianceId;
    }
}