<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

class EloquentApplianceModel extends EloquentBaseModel
{
    /** @var string */
    protected $table = 'appliances';

    /** @var array */
    protected $fillable = [
        'id',
        'data',
    ];
}