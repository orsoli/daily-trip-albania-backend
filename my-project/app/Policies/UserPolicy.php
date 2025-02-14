<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, User $model): bool
    {
        if ($user->role->slug === 'super-admin') {
        return true;
        };

        return $user->id === $model->id;
    }

}