<?php

namespace App\Services\Wishlist;

use App\Repositories\Frontend\Wishlist\WishlistRepository as WishlistReadModelRepository;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use Mfa\Application\Command\CreateWishlistCommand;
use Mfa\Domain\WishlistRepository;

class WishlistService
{
    use DispatchesCommands;

    /**
     * @var WishlistRepository
     */
    private $wishlistRepository;

    /**
     * @var WishlistReadModelRepository
     */
    private $wishlistReadModelRepository;

    /**
     * WishlistService constructor.
     * @param WishlistRepository $wishListRepository
     * @param WishlistReadModelRepository $wishlistReadModelRepository
     */
    public function __construct(
        WishlistRepository $wishListRepository,
        WishlistReadModelRepository $wishlistReadModelRepository
    )
    {
        $this->wishlistRepository = $wishListRepository;
        $this->wishlistReadModelRepository = $wishlistReadModelRepository;
    }

    /**
     * @param $userId
     * @return \App\Models\Wishlist\WishlistReadModel
     */
    public function findUserWishlist($userId)
    {
        $wishlistReadModel = $this->wishlistReadModelRepository->findByUserId($userId);
        return $wishlistReadModel;
    }

    /**
     * @param $userId
     */
    public function makeSureTheUserHasAWishlist($userId)
    {
        if ($this->userAlreadyHasAWishlist($userId)) {
            return;
        }

        $this->dispatch(new CreateWishlistCommand(
            $this->wishlistRepository->nextId()->getValue(),
            $userId
        ));
    }

    /**
     * @param $userId
     * @return bool
     */
    private function userAlreadyHasAWishlist($userId)
    {
        $wishlistReadModel = $this->wishlistReadModelRepository->findByUserId($userId);

        if (!$wishlistReadModel) {
            return false;
        }

        return true;
    }
}