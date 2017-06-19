<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use App\Models\Appliance\ApplianceReadModel;
use Mfa\Domain\Appliance;
use Mfa\Domain\ApplianceId;
use Mfa\Domain\ApplianceRepository;

class EloquentApplianceRepository implements ApplianceRepository
{
    /**
     * @return ApplianceId
     */
    public function nextId()
    {
        return ApplianceId::generate();
    }

    /**
     * @param Appliance $appliance
     */
    public function save(Appliance $appliance)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $eloquentApplianceModel = EloquentApplianceModel::where('id', $appliance->getId()->getValue())
            ->first();

        if (!$eloquentApplianceModel) {
            $eloquentApplianceModel = new EloquentApplianceModel();
        }

        $eloquentApplianceModel->id = $appliance->getId()->getValue();
        $eloquentApplianceModel->data = serialize($appliance);
        $eloquentApplianceModel->save();
    }

    /**
     * @param ApplianceId $applianceId
     * @return Appliance
     * @throws ApplianceWithIdNotFoundException
     */
    public function applianceOfId(ApplianceId $applianceId)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $eloquentApplianceModel = EloquentApplianceModel::where('id', $applianceId->getValue())->first();

        if (!$eloquentApplianceModel) {
            throw new ApplianceWithIdNotFoundException($applianceId->getValue());
        }

        $appliance = unserialize($eloquentApplianceModel->data);

        return $appliance;
    }

    /**
     * @param $externalId
     * @return Appliance
     * @throws ApplianceWithExternalIdNotFoundException
     */
    public function applianceOfExternalId($externalId)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $applianceReadModel = ApplianceReadModel::where('external_id', $externalId)
            ->first();

        if (!$applianceReadModel) {
            throw new ApplianceWithExternalIdNotFoundException($externalId);
        }

        return $this->applianceOfId(ApplianceId::fromString($applianceReadModel->appliance_id));
    }
}