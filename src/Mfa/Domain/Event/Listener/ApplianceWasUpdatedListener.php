<?php

namespace Mfa\Domain\Event\Listener;

use App\Repositories\Frontend\Appliance\ApplianceRepository;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Mfa\Domain\Appliance;
use Mfa\Domain\Event\ApplianceWasCreated;

class ApplianceWasUpdatedListener extends AbstractListener
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
        $this->updateReadModel($appliance);
    }

    /**
     * @param Appliance $appliance
     */
    private function updateReadModel(Appliance $appliance)
    {
        $data = [
            'appliance_id' => $appliance->getId(),
            'external_id' => $appliance->getExternalId(),
            'title' => $appliance->getDescription()->getTitle(),
            'description' => $appliance->getDescription()->getDescription(),
            'image' => $appliance->getImage(),
            'category' => $appliance->getCategory()->getName(),
            'price_amount' => $appliance->getPrice()->getAmount(),
            'price_currency' => $appliance->getPrice()->getCurrency(),
        ];

        $applianceReadModel = $this->applianceRepository->findById($appliance->getId());

        if (!$applianceReadModel) {
            $this->applianceRepository->create($data);
        } else {
            $applianceReadModel->fill($data);
            $applianceReadModel->save();
        }
    }
}