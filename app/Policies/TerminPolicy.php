<?php

namespace App\Policies;

use App\Models\Termin;
use App\Models\User;

class TerminPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['user', 'trainer', 'admin']);
    }

    public function view(User $user, Termin $termin): bool
    {
        return $user->hasRole('admin') || $user->id === $termin->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['trainer', 'admin']);
    }

    public function update(User $user, Termin $termin): bool
    {
        return $user->hasRole('admin') || $user->id === $termin->user_id;
    }

    public function delete(User $user, Termin $termin): bool
    {
        return $user->hasRole('admin') || $user->id === $termin->user_id;
    }

    public function restore(User $user, Termin $termin): bool
    {
        return false;
    }

    public function forceDelete(User $user, Termin $termin): bool
    {
        return false;
    }
}
