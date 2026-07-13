<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Models\User;

class SptPolicy
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
    public function view(User $user, Spt $spt): bool
    {
        if ($user->isAdmin() || $user->isMonitoring()) {
            return true;
        }

        // Cek jika pembuat
        if ($spt->pembuat_id === $user->id) {
            return true;
        }

        // Cek jika masuk dalam daftar pegawai ditugaskan
        $pegawaiId = Pegawai::where('user_id', $user->id)->value('id');
        if ($pegawaiId) {
            $pegawaiList = $spt->pegawai_ditugaskan ?? [];
            foreach ($pegawaiList as $p) {
                if (($p['pegawai_id'] ?? null) == $pegawaiId) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isPembuatSpt();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Spt $spt): bool
    {
        // Hanya pembuat atau admin yang bisa update
        return $user->id === $spt->pembuat_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Spt $spt): bool
    {
        return $user->id === $spt->pembuat_id || $user->isAdmin();
    }
}
