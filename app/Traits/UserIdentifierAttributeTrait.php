<?php

namespace App\Traits;

use Auth;

trait UserIdentifierAttributeTrait
{
    public function getUserIdentifierAttribute(): string
    {
        $auth_user = Auth::user();

        $link = '#';
        if ($auth_user->hasRole('manager')) {
            return trans('labels.user');
        }

        // Show link only for admin
        if ($auth_user && ($auth_user->hasRole('admin') || $auth_user->hasRole('editor'))) {
            $link = route('users::show::index', $this->user);
        }
        // $this - Task/Transaction instance
        $userIdentifier = $this->user->email;

        return "<a href='{$link}'>{$userIdentifier}</a>";
    }
}
