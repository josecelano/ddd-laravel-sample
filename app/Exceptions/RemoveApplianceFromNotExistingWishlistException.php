<?php

namespace App\Exceptions;

use DomainException;
use Throwable;

class RemoveApplianceFromNotExistingWishlistException extends DomainException
{
    /** @var  int */
    private $userId;

    /**
     * RemoveApplianceFromNotExistingWishlistException constructor.
     * @param int $userId
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($userId, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->userId = $userId;
    }
}
