<?php

namespace App\Policies\Admin\User;

use App\Models\User;

class UserAdminPolicy
{
    public function enableAccount(User $authUser, User $userAdmin): bool
    {
        return $authUser->getId() !== $userAdmin->getId() && !$userAdmin->isActive();
    }

    public function disableAccount(User $authUser, User $userAdmin): bool
    {
        return $authUser->getId() !== $userAdmin->getId() && $userAdmin->isActive();
    }
}
