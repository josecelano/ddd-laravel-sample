<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use DomainException;
use Throwable;

class UserWishlistNotFoundException extends DomainException
{
    /** @var  string */
    private $userId;

    /**
     * UserWishlistNotFoundException constructor.
     * @param string $userId
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($userId, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}