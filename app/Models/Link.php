<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_links', 'link_id', 'user_id');
    }

    public function getAwardAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }
}
