<?php

namespace Mfa\Application\Command;

class RemoveApplianceFromWishlistCommand
{
    /** @var string */
    private $userId;

    /** @var string */
    private $applianceId;

    /**
     * RemoveApplianceFromWishlistCommand constructor.
     * @param string $userId
     * @param string $applianceId
     */
    public function __construct($userId, $applianceId)
    {
        $this->userId = $userId;
        $this->applianceId = $applianceId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getApplianceId()
    {
        return $this->applianceId;
    }
}