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
        return $user->role === 'admin';
    }

    public function update(User $user)
    {
        return in_array($user->role, ['admin', 'driver']);
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
