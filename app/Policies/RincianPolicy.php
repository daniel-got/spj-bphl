<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Pegawai;
use App\Models\Rincian;
use App\Models\User;

class RincianPolicy
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
    public function view(User $user, Rincian $rincian): bool
    {
        if ($user->isAdmin() || $user->isMonitoring() || $user->isVerifikator()) {
            return true;
        }

        $pegawaiNip = Pegawai::where('user_id', $user->id)->value('nip');

        return $rincian->pembuat_id === $user->id || ($pegawaiNip && $rincian->spd?->nip_pegawai === $pegawaiNip);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rincian $rincian): bool
    {
        return $user->id === $rincian->pembuat_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rincian $rincian): bool
    {
        return $user->id === $rincian->pembuat_id || $user->isAdmin();
    }
}
