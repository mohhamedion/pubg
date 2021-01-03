<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServiceRequest
 *
 * @property int $id
 * @property int $type_id
 * @property int|null $user_id
 * @property string $email
 * @property string $url
 * @property string|null $skype_telegram
 * @property string|null $description
 * @property bool $is_read
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\ServiceRequestType $type
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereSkypeTelegram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceRequest whereUserId($value)
 * @mixin \Eloquent
 */
class ServiceRequest extends Model
{

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(ServiceRequestType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
