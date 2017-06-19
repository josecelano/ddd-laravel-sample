<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use App\Models\Wishlist\WishlistReadModel;
use Mfa\Domain\ApplianceId;
use Mfa\Domain\UserId;
use Mfa\Domain\Wishlist;
use Mfa\Domain\WishlistId;
use Mfa\Domain\WishlistRepository;

class EloquentWishlistRepository implements WishlistRepository
{
    /**
     * @return WishlistId
     */
    public function nextId()
    {
        return WishlistId::generate();
    }

    /**
     * @param Wishlist $wishlist
     */
    public function save(Wishlist $wishlist)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $eloquentWishlistModel = EloquentWishlistModel::where('id', $wishlist->getId()->getValue())
            ->first();

        if (!$eloquentWishlistModel) {
            $eloquentWishlistModel = new EloquentWishlistModel();
        }

        $eloquentWishlistModel->id = $wishlist->getId()->getValue();
        $eloquentWishlistModel->data = serialize($wishlist);
        $eloquentWishlistModel->save();
    }

    /**
     * @param WishlistId $wishlistId
     * @return Wishlist
     */
    public function wishlistOfId(WishlistId $wishlistId)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $eloquentWishlistModel = EloquentWishlistModel::where('id', $wishlistId->getValue())
            ->first();

        if (!$eloquentWishlistModel) {
            throw new WishlistWithIdNotFoundException($wishlistId->getValue());
        }

        $wishlist = unserialize($eloquentWishlistModel->data);

        return $wishlist;
    }

    /**
     * @param UserId $userId
     * @return Wishlist
     */
    public function findByUserId(UserId $userId)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $eloquentWishlistReadModel = WishlistReadModel::where('user_id', $userId->getValue())->first();

        if (!$eloquentWishlistReadModel) {
            throw new UserWishlistNotFoundException($userId->getValue());
        }

        $wishlist = $this->wishlistOfId(WishlistId::fromString($eloquentWishlistReadModel->wishlist_id));

        return $wishlist;
    }

    /**
     * @param UserId $userId
     * @return Wishlist
     */
    private function createWishlistForUser(UserId $userId)
    {
        $wishlist = new Wishlist(
            $this->nextId(),
            $userId,
            ApplianceId::collection()
        );
        return $wishlist;
    }
}