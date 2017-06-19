<?php

namespace App\Repositories\Frontend\Appliance;

use App\Models\Appliance\ApplianceReadModel;
use App\Repositories\BaseRepository;
use Mfa\Domain\ApplianceId;

class ApplianceRepository extends BaseRepository
{
    const MODEL = ApplianceReadModel::class;

    /**
     * @param array $data
     * @param bool $provider
     *
     * @return static
     */
    public function create(array $data, $provider = false)
    {
        $appliance = ApplianceReadModel::create($data);
        $appliance->save();
        return $appliance;
    }

    /**
     * @param ApplianceId $applianceId
     * @return ApplianceReadModel
     */
    public function findById(ApplianceId $applianceId)
    {
        /** @var ApplianceReadModel $appliance */
        $appliance = $this->query()->where('appliance_id', $applianceId->getValue())->first();

        if (!$appliance) {
            return null;
        }

        return $appliance;
    }

    /**
     * @param ApplianceId $applianceId
     * @return ApplianceReadModel
     */
    public function findOrCreate(ApplianceId $applianceId)
    {
        $appliance = $this->findById($applianceId);

        if (!$appliance) {
            $wishlist = $this->create([
                'wishlist_id' => $wishlistId->getValue(),
                'user_id' => $userId->getValue(),
            ]);
        }

        return $appliance;
    }

    /**
     * @param $category
     * @return mixed
     */
    public function findByCategory($category)
    {
        return $this->query()->where('category', $category)->get();
    }

    /**
     * @param $category
     * @param int $limit
     * @return mixed
     */
    public function findByCategoryPaginate($category, $limit = 10)
    {
        return $this->query()->where('category', $category)->paginate($limit);
    }

    /**
     * @param array $ids
     * @param int $limit
     * @return mixed
     */
    public function findWhereIdIn(array $ids, $limit = -1)
    {
        if (count($ids) == 0) {
            return [];
        }

        if ($limit == -1) {
            return $this->query()->whereIn('id', $ids)->get();
        } else {
            return $this->query()->whereIn('id', $ids)->paginate($limit);
        }
    }
}
