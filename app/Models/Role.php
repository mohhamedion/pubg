<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
 
class Role extends Model
{

    const ADMIN_ROLE_ID = 1;
    const MANAGER_ROLE_ID = 2;
    const USER_ROLE_ID = 3;
    const EDITOR_ROLE_ID = 4;

    const ROLES = [
        [
            'name' => 'admin',
			'display_name' => 'Администратор',
            'description' => 'User with admin permissions, can edit everything'
        ],
        [
            'name' => 'manager',
            'display_name' => 'Менеджер',
            'description' => 'User with manager permissions.'
        ],
        [
            'name' => 'user',
            'display_name' => 'Пользователь',
            'description' => 'User with no permissions.'
        ],
        [
            'name' => 'editor',
            'display_name' => 'Редактор',
            'description' => 'User that has access only to Users and Transactions.'
        ],
    ];

    protected $guarded = ['id'];

    /**
     * Roles belongs to Users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Builder|User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id');
    }
}
