<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use DomainException;
use Throwable;

class WishlistWithIdNotFoundException extends DomainException
{
    /** @var  string */
    private $wishlistId;

    /**
     * WishlistWithIdNotFoundException constructor.
     * @param string $wishlistId
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($wishlistId, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->wishlistId = $wishlistId;
    }

    /**
     * @return string
     */
    public function getWishlistId()
    {
        return $this->wishlistId;
    }
}