<?php

namespace Mfa\Domain;

use Mfa\Infrastructure\Persistence\Eloquent\ApplianceWithExternalIdNotFoundException;
use Mfa\Infrastructure\Persistence\Eloquent\ApplianceWithIdNotFoundException;

interface ApplianceRepository
{
    /**
     * @return ApplianceId
     */
    public function nextId();

    /**
     * @param Appliance $appliance
     */
    public function save(Appliance $appliance);

    /**
     * @param ApplianceId $applianceId
     * @return Appliance
     * @throws ApplianceWithIdNotFoundException
     */
    public function applianceOfId(ApplianceId $applianceId);

    /**
     * @param $externalId
     * @return Appliance
     * @throws ApplianceWithExternalIdNotFoundException
     */
    public function applianceOfExternalId($externalId);
}