<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServiceRequestType
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceRequest[] $requests
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequestType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequestType whereName($value)
 * @mixin \Eloquent
 */
class ServiceRequestType extends Model
{

    public $timestamps = false;

    const TYPES = [
        'top',
        'aso',
        'comments',
    ];

    protected $guarded = [
        'id',
    ];

    public function requests()
    {
        return $this->hasMany(ServiceRequest::class, 'type_id');
    }
}
