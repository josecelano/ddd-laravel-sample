<?php

namespace Mfa\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentBaseModel
 * @property string id
 * @property string data
 */
class EloquentBaseModel extends Model
{
    /** @var array */
    protected $fillable = [
        'id',
        'data,
    '];

    public $timestamps = false;
}