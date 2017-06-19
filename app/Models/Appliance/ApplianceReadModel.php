<?php

namespace App\Models\Appliance;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string external_id
 * @property string title
 * @property string description
 * @property string image
 * @property string category
 * @property int price_amount
 * @property string price_currency
 */
class ApplianceReadModel extends Model
{
    /** @var string */
    protected $table = 'read_appliances';

    /** @var array */
    protected $fillable = [
        'appliance_id',
        'external_id',
        'title',
        'description',
        'image',
        'category',
        'price_amount',
        'price_currency'
    ];

    public function wishlists()
    {
        return $this->belongsToMany('\App\Models\Wishlist\WishlistReadModel', 'appliance_wishlist_read_model', 'wishlist_id', 'appliance_id')
            ->withTimestamps();
    }
}
