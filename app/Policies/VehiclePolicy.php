<?php

namespace App\Policies;

use App\Models\User;

class VehiclePolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'dispatcher', 'driver']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'dispatcher']);
    }

    public function update(User $user)
    {
        return in_array($user->role, ['admin', 'driver', 'dispatcher']);
    }

    public function deleteAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user)
    {
        return $user->role === 'admin';
    }
}
