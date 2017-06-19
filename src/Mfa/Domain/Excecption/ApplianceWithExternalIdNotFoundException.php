<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use DomainException;
use Throwable;

class ApplianceWithExternalIdNotFoundException extends DomainException
{
    /** @var  string */
    private $externalId;

    /**
     * ApplianceWithExternalIdNotFoundException constructor.
     * @param string $externalId
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($externalId, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->externalId = $externalId;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }
}