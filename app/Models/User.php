<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'roles'];

    protected $hidden = ['password', 'remember_token'];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles' => 'array',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Setiap User memiliki satu profil Pegawai (relasi 1:1).
     * Akses: Auth::user()->pegawai->nip
     * Setiap User memiliki banyak data Rincian (relasi 1:M)
     * Akses: Rincian::rincian()->user->peagawai->nip
     */
    public function pegawai(): HasOne
    {
        return $this->hasOne(Pegawai::class, 'user_id');
    }

    public function rincianDibuat(): HasMany
    {
        return $this->hasMany(Rincian::class, 'pembuat_id');
    }

    public function rincianDiverifikasi(): HasMany
    {
        return $this->hasMany(Rincian::class, 'verifikator_id');
    }

    // -------------------------------------------------------------------------
    // Query Scopes
    // -------------------------------------------------------------------------

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->whereJsonContains('roles', UserRole::ADMIN->value);
    }

    public function scopeVerifikator(Builder $query): Builder
    {
        return $query->whereJsonContains('roles', UserRole::VERIFIKATOR->value);
    }

    public function scopeRolePegawai(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereJsonContains('roles', UserRole::USER->value)
                ->orWhereJsonContains('roles', UserRole::PPK1->value)
                ->orWhereJsonContains('roles', UserRole::PPK2->value)
                ->orWhereJsonContains('roles', UserRole::PPK3->value)
                ->orWhereJsonContains('roles', UserRole::BENDAHARA->value);
        });
    }

    public function scopeMonitoring(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            foreach (UserRole::monitoringRoles() as $role) {
                $q->orWhereJsonContains('roles', $role);
            }
        });
    }

    // -------------------------------------------------------------------------
    // Helper Methods (boolean checks — gunakan di Blade/Controller)
    // -------------------------------------------------------------------------

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles ?? []);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::ADMIN->value);
    }

    public function isVerifikator(): bool
    {
        return $this->hasRole(UserRole::VERIFIKATOR->value);
    }

    public function isPembuatSpt(): bool
    {
        return $this->hasRole(UserRole::PEMBUAT_SPT->value);
    }

    public function isPegawai(): bool
    {
        $pegawaiRoles = [
            UserRole::USER->value,
            UserRole::PPK1->value,
            UserRole::PPK2->value,
            UserRole::PPK3->value,
            UserRole::BENDAHARA->value,
        ];

        return ! empty(array_intersect($this->roles ?? [], $pegawaiRoles));
    }

    /**
     * True jika user ini memiliki setidaknya satu role monitoring (Kepala Balai, TU, Seksi).
     */
    public function isMonitoring(): bool
    {
        return ! empty(array_intersect($this->roles ?? [], UserRole::monitoringRoles()));
    }

    /**
     * Mengembalikan array label role yang readable untuk ditampilkan di UI.
     * Contoh: $user->roleLabels() => ['Administrator', 'Verifikator']
     */
    public function roleLabels(): array
    {
        $labels = [];
        foreach ($this->roles ?? [] as $roleStr) {
            $enum = UserRole::tryFrom($roleStr);
            $labels[] = $enum ? $enum->label() : ucfirst($roleStr);
        }

        return $labels;
    }

    /**
     * Untuk backwards compatibility, ambil label pertama atau default.
     */
    public function roleLabel(): string
    {
        $labels = $this->roleLabels();

        return ! empty($labels) ? $labels[0] : 'Unknown';
    }
}
