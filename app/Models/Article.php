<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $title
 * @property string $preview
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read bool $is_read
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $readUsers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $appends = [
        'is_read',
    ];

    /**
     * Users that open/read/watched this article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function readUsers()
    {
        return $this->belongsToMany(User::class, 'user_article_read_pivot', 'article_id', 'user_id');
    }

    public function getIsReadAttribute(): bool
    {
        if (Auth::check()) {
            if (Auth::user()->readArticles()->where('article_id', '=', $this->id)->exists()) {
                return true;
            }

            return false;
        }

        return true;
    }
}
