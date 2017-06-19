<?php

namespace App\Models\Wishlist;

use App\Models\Access\User\User;
use App\Models\Appliance\ApplianceReadModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WishlistReadModel
 * @property User user
 * @property ApplianceReadModel[] appliances
 * @package App\Models\Wishlist
 */
class WishlistReadModel extends Model
{
    /** @var string */
    protected $table = 'read_wishlists';

    /** @var array */
    protected $fillable = [
        'wishlist_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User');
    }

    public function appliances()
    {
        return $this->belongsToMany('\App\Models\Appliance\ApplianceReadModel', 'appliance_wishlist_read_model', 'wishlist_id', 'appliance_id')
            ->withTimestamps();
    }
}