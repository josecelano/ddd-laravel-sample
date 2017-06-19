<?php

namespace App\Repositories\Frontend\Wishlist;

use App\Models\Wishlist\WishlistReadModel;
use App\Repositories\BaseRepository;
use Mfa\Domain\UserId;
use Mfa\Domain\WishlistId;

class WishlistRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = WishlistReadModel::class;

    /**
     * @param array $data
     * @param bool $provider
     *
     * @return WishlistReadModel
     */
    public function create(array $data, $provider = false)
    {
        $wishList = self::MODEL;
        $wishList = new $wishList();
        $wishList->wishlist_id = $data['wishlist_id'];
        $wishList->user_id = $data['user_id'];

        /** @noinspection PhpUndefinedMethodInspection */
        $wishList->save();

        return $wishList;
    }

    /**
     * @param WishlistId $wishlistId
     * @return WishlistReadModel
     */
    public function findById(WishlistId $wishlistId)
    {
        /** @var WishlistReadModel $wishlist */
        $wishlist = $this->query()->where('wishlist_id', $wishlistId->getValue())->first();

        if (!$wishlist) {
            return null;
        }

        return $wishlist;
    }

    /**
     * @param $userId
     * @param int $appliancesLimit
     * @return WishlistReadModel
     */
    public function findByUserId($userId, $appliancesLimit = 20)
    {
        /** @var WishlistReadModel $wishlist */
        $wishlist = $this->query()->where('user_id', $userId)->first();

        if (!$wishlist) {
            return null;
        }

        return $wishlist;
    }

    /**
     * @param int $userId
     * @return WishlistReadModel
     */
    public function findOrCreateByUserId($userId)
    {
        $wishlist = $this->findByUserId($userId);

        if (!$wishlist) {
            $wishlist = $this->create([
                'user_id' => $userId,
            ]);
        }

        return $wishlist;
    }

    /**
     * @param WishlistId $wishlistId
     * @param UserId $userId
     * @return WishlistReadModel
     */
    public function findOrCreateById(WishlistId $wishlistId, UserId $userId)
    {
        $wishlist = $this->findById($wishlistId);

        if (!$wishlist) {
            $wishlist = $this->create([
                'wishlist_id' => $wishlistId->getValue(),
                'user_id' => $userId->getValue(),
            ]);
        }

        return $wishlist;
    }
}