<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Pegawai;
use App\Models\Spd;
use App\Models\User;

class SpdPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Filtered at query level in Service
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Spd $spd): bool
    {
        if ($user->isAdmin() || $user->isMonitoring()) {
            return true;
        }

        $pegawaiNip = Pegawai::where('user_id', $user->id)->value('nip');

        return $spd->pembuat_id === $user->id || ($pegawaiNip && $spd->nip_pegawai === $pegawaiNip);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any logged in user can create their own SPD from SPT
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Spd $spd): bool
    {
        return $user->id === $spd->pembuat_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Spd $spd): bool
    {
        return $user->id === $spd->pembuat_id || $user->isAdmin();
    }
}
