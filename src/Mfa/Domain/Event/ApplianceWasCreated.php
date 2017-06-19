<?php

namespace Mfa\Domain\Event;

use League\Event\AbstractEvent;
use League\Event\EventInterface;
use Mfa\Domain\Appliance;

class ApplianceWasCreated extends AbstractEvent implements EventInterface
{
    /** @var  Appliance */
    private $appliance;

    /**
     * ApplianceWasCreated constructor.
     * @param Appliance $appliance
     */
    public function __construct(Appliance $appliance)
    {
        $this->appliance = $appliance;
    }

    /**
     * @return Appliance
     */
    public function getAppliance()
    {
        return $this->appliance;
    }
}