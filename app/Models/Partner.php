<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';
    protected $guarded = [];
    protected $hidden = [
        'lang'
    ];

    const IMAGE_FOLDER = '/images/partners'; // in "public" directory

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_partners', 'partner_id', 'user_id');
    }

    public function getAwardAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getImageUrlAttribute(): string
    {
        return url(self::IMAGE_FOLDER . "/{$this->attributes['image_url']}");
    }
}
