<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use DomainException;
use Throwable;

class ApplianceWithIdNotFoundException extends DomainException
{
    /** @var  string */
    private $applianceId;

    /**
     * ApplianceWithIdNotFoundException constructor.
     * @param string $applianceId
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($applianceId, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->applianceId = $applianceId;
    }

    /**
     * @return string
     */
    public function getApplianceId()
    {
        return $this->applianceId;
    }
}