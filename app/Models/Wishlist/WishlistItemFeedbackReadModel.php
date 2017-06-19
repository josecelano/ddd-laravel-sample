<?php

namespace App\Models\Wishlist;

use Illuminate\Database\Eloquent\Model;

class WishlistItemFeedbackReadModel extends Model
{
    /** @var string */
    protected $table = 'read_wishlist_item_feedbacks';

    /** @var array */
    protected $fillable = [
        'wishlist_item_feedback_id',
        'user_id',
        'wishlist_id',
        'appliance_id',
        'disliked',
    ];

    /**
     * Get the user that submitted the feedback.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User');
    }

    /**
     * Get the wishlist which has got the feedback.
     */
    public function wishlist()
    {
        return $this->belongsTo('App\Models\Wishlist\WishlistReadModel');
    }

    /**
     * Get the concrete appliance which has got the feedback.
     */
    public function appliance()
    {
        return $this->belongsTo('App\Models\Appliance\ApplianceReadModel');
    }
}
