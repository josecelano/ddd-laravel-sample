<?php

namespace Mfa\Domain;

use Collections\Collection;

class ApplianceIdCollection extends Collection
{
    /**
     * ApplianceIdCollection constructor.
     * @param $type
     * @param ApplianceId[] $applianceIds
     */
    public function __construct($type, array $applianceIds = [])
    {
        parent::__construct(ApplianceId::class, $applianceIds);
    }

    /**
     * @param ApplianceId[] $applianceIds
     * @return ApplianceIdCollection
     */
    public static function build(array $applianceIds = [])
    {
        return new self(ApplianceId::class, $applianceIds);
    }
}