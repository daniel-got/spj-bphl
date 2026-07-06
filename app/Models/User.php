<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
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
        return $query->where('role', UserRole::ADMIN->value);
    }

    public function scopeVerifikator(Builder $query): Builder
    {
        return $query->where('role', UserRole::VERIFIKATOR->value);
    }

    public function scopeRolePegawai(Builder $query): Builder
    {
        return $query->where('role', UserRole::USER->value);
    }

    public function scopeMonitoring(Builder $query): Builder
    {
        return $query->whereIn('role', UserRole::monitoringRoles());
    }

    // -------------------------------------------------------------------------
    // Helper Methods (boolean checks — gunakan di Blade/Controller)
    // -------------------------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN->value;
    }

    public function isVerifikator(): bool
    {
        return $this->role === UserRole::VERIFIKATOR->value;
    }

    public function isPembuatSpt(): bool
    {
        return $this->role === UserRole::PEMBUAT_SPT->value;
    }

    public function isPegawai(): bool
    {
        return $this->role === UserRole::USER->value;
    }

    /**
     * True jika role ini adalah role monitoring (Kepala Balai, TU, Seksi).
     */
    public function isMonitoring(): bool
    {
        return in_array($this->role, UserRole::monitoringRoles());
    }

    /**
     * Mengembalikan label role yang readable untuk ditampilkan di UI.
     * Contoh: $user->roleLabel() => 'Administrator'
     */
    public function roleLabel(): string
    {
        $enum = UserRole::tryFrom($this->role);
        return $enum ? $enum->label() : ucfirst($this->role);
    }
}
