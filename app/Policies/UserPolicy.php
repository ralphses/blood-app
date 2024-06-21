<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class UserPolicy
{
    public function isAdmin(User $user) : bool {
        return $user->role === Role::ADMIN->name;
    }

    public function isDonor(User $user) : bool {
        return $user->role === Role::DONOR->name;
    }

    public function isRecipient(User $user) : bool {
        return $user->role === Role::RECIPIENT->name;
    }
}
