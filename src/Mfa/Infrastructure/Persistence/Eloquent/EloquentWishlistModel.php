<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

class EloquentWishlistModel extends EloquentBaseModel
{
    /** @var string */
    protected $table = 'wishlists';

    /** @var array */
    protected $fillable = [
        'id',
        'data',
    ];
}