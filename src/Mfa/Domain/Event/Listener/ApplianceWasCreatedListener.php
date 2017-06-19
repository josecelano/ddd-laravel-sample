<?php

namespace Mfa\Domain\Event\Listener;

use App\Repositories\Frontend\Appliance\ApplianceRepository;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Mfa\Domain\Appliance;
use Mfa\Domain\Event\ApplianceWasCreated;

class ApplianceWasCreatedListener extends AbstractListener
{
    /** @var  ApplianceRepository */
    private $applianceRepository;

    /**
     * ApplianceWasCreatedListener constructor.
     * @param ApplianceRepository $applianceRepository
     */
    public function __construct(ApplianceRepository $applianceRepository)
    {
        $this->applianceRepository = $applianceRepository;
    }

    /**
     * @param EventInterface|ApplianceWasCreated $event
     */
    public function handle(EventInterface $event)
    {
        $appliance = $event->getAppliance();
        $this->createReadModel($appliance);
    }

    /**
     * @param Appliance $appliance
     */
    private function createReadModel(Appliance $appliance)
    {
        $this->applianceRepository->create([
            'external_id' => $appliance->getExternalId(),
            'title' => $appliance->getDescription()->getTitle(),
            'description' => $appliance->getDescription()->getDescription(),
            'image' => $appliance->getImage(),
            'category' => $appliance->getCategory()->getName(),
            'price_amount' => $appliance->getPrice()->getAmount(),
            'price_currency' => $appliance->getPrice()->getCurrency(),
        ]);
    }
}