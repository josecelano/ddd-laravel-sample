<?php

namespace Mfa\Application\Command;

class CreateWishlistCommand
{
    /** @var string */
    private $wishlistId;

    /** @var string */
    private $userId;

    /**
     * CreateWishlistCommand constructor.
     * @param string $wishlistId
     * @param string $userId
     */
    public function __construct($wishlistId, $userId)
    {
        $this->wishlistId = $wishlistId;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getWishlistId()
    {
        return $this->wishlistId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}