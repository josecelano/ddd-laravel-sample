<?php

namespace Mfa\Domain;

interface WishlistRepository
{
    /**
     * @return WishlistId
     */
    public function nextId();

    /**
     * @param Wishlist $wishlist
     */
    public function save(Wishlist $wishlist);

    /**
     * @param WishlistId $wishlistId
     * @return Wishlist
     */
    public function wishlistOfId(WishlistId $wishlistId);

    /**
     * @param UserId $userId
     * @return Wishlist
     */
    public function findByUserId(UserId $userId);
}