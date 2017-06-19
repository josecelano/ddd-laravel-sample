<?php

namespace Mfa\Application\Command\Handler;

use League\Event\EmitterInterface;
use Mfa\Application\Command\UpdateOrCreateApplianceCommand;
use Mfa\Domain\Appliance;
use Mfa\Domain\ApplianceCategory;
use Mfa\Domain\ApplianceDescription;
use Mfa\Domain\ApplianceRepository;
use Mfa\Infrastructure\Persistence\Eloquent\ApplianceWithExternalIdNotFoundException;
use Money\Currency;
use Money\Money;

/**
 * Class UpdateOrCreateApplianceCommandHandler
 * @package Mfa\Application\Command\Handler
 */
class UpdateOrCreateApplianceCommandHandler
{
    /** @var  ApplianceRepository */
    private $applianceRepository;

    /** @var EmitterInterface */
    private $emitter;

    /**
     * UpdateOrCreateApplianceCommandHandler constructor.
     * @param ApplianceRepository $wishlistRepository
     * @param EmitterInterface $emitter
     */
    public function __construct(ApplianceRepository $wishlistRepository, EmitterInterface $emitter)
    {
        $this->applianceRepository = $wishlistRepository;
        $this->emitter = $emitter;
    }

    /**
     * @param UpdateOrCreateApplianceCommand $command
     */
    public function handle(UpdateOrCreateApplianceCommand $command)
    {
        try {
            $appliance = $this->applianceRepository->applianceOfExternalId($command->getExternalId());
            $this->updateApplianceFromCommand($command, $appliance);
        } catch (ApplianceWithExternalIdNotFoundException $e) {
            $appliance = $this->createApplianceFromCommand($command);
        }

        $this->emitter->emitGeneratedEvents($appliance);
        $this->applianceRepository->save($appliance);
    }

    /**
     * @param UpdateOrCreateApplianceCommand $command
     * @return Appliance
     */
    private function createApplianceFromCommand(UpdateOrCreateApplianceCommand $command)
    {
        $appliance = new Appliance(
            $this->applianceRepository->nextId(),
            $command->getExternalId(),
            new ApplianceDescription(
                $command->getTitle(),
                $command->getDescription()
            ),
            $command->getImage(),
            ApplianceCategory::fromName($command->getCategory()),
            new Money($command->getPriceAmount(), new Currency($command->getPriceCurrency()))
        );
        return $appliance;
    }

    /**
     * @param UpdateOrCreateApplianceCommand $command
     * @param Appliance $appliance
     */
    private function updateApplianceFromCommand(UpdateOrCreateApplianceCommand $command, Appliance $appliance)
    {
        $appliance->update(
            $command->getExternalId(),
            new ApplianceDescription(
                $command->getTitle(),
                $command->getDescription()
            ),
            $command->getImage(),
            ApplianceCategory::fromName($command->getCategory()),
            new Money($command->getPriceAmount(), new Currency($command->getPriceCurrency()))
        );
    }
}