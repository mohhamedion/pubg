<?php

namespace App\Models;

use App\Events\ArticleImageDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\ArticleImage
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleImage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleImage extends Model
{
    const FOLDER = 'public/news';

    protected $guarded = [
        'id',
    ];

    protected $appends = [
        'url',
    ];

    protected $dispatchesEvents = [
        'deleted' => ArticleImageDelete::class,
    ];

    public function getUrlAttribute(): string
    {
        return url(Storage::url(self::FOLDER. "/{$this->name}"));
    }
}
