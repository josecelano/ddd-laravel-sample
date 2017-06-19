<?php

namespace Mfa\Domain;

use League\Event\GeneratorInterface;
use League\Event\GeneratorTrait;
use Mfa\Domain\Event\ApplianceWasAddedToWishlist;
use Mfa\Domain\Event\ApplianceWasRemovedFromWishlist;
use Mfa\Domain\Event\WishlistWasCreated;

class Wishlist implements GeneratorInterface
{
    use GeneratorTrait;

    /** @var  WishlistId */
    private $id;

    /** @var  UserId */
    private $userId;

    /** @var  ApplianceIdCollection */
    private $applianceIdCollection;

    /**
     * Wishlist constructor.
     * @param WishlistId $id
     * @param UserId $userId
     * @param ApplianceIdCollection $applianceIdCollection
     */
    public function __construct(WishlistId $id, UserId $userId, ApplianceIdCollection $applianceIdCollection = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->applianceIdCollection = is_null($applianceIdCollection) ? ApplianceId::collection() : $applianceIdCollection;

        $this->addEvent(new WishlistWasCreated($this));
    }

    /**
     * @return WishlistId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return ApplianceIdCollection
     */
    public function getApplianceIdCollection()
    {
        return $this->applianceIdCollection;
    }

    /**
     * @param ApplianceId $applianceId
     */
    public function addAppliance(ApplianceId $applianceId)
    {
        if ($this->containsAppliance($applianceId)) {
            return;
        }

        $this->applianceIdCollection = $this->applianceIdCollection->add($applianceId);
        $this->addEvent(new ApplianceWasAddedToWishlist($this, $applianceId));
    }

    /**
     * @param ApplianceId $applianceId
     */
    public function removeAppliance(ApplianceId $applianceId)
    {
        if ($this->containsAppliance($applianceId)) {
            $this->applianceIdCollection = $this->applianceIdCollection->removeAt($this->indexForApplianceId($applianceId));
            $this->addEvent(new ApplianceWasRemovedFromWishlist($this, $applianceId));
        }
    }

    /**
     * @param ApplianceId $applianceId
     * @return int
     */
    private function containsAppliance(ApplianceId $applianceId)
    {
        return $this->applianceIdCollection->contains(function (ApplianceId $currentApplianceId) use ($applianceId) {
            if ($currentApplianceId->equals($applianceId))
                return true;
            else
                return false;

        });
    }

    /**
     * @param ApplianceId $applianceId
     * @return int
     */
    private function indexForApplianceId(ApplianceId $applianceId)
    {
        $index = $this->applianceIdCollection->findIndex(function (ApplianceId $currentApplianceId) use ($applianceId) {
            if ($currentApplianceId->equals($applianceId))
                return true;
            else
                return false;

        });
        return $index;
    }
}