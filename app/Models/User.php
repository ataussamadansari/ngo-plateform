<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Donations verified by this admin/manager.
     */
    public function verifiedDonations(): HasMany
    {
        return $this->hasMany(Donation::class, 'verified_by');
    }

    /**
     * Fund distributions created by this admin/manager.
     */
    public function fundDistributions(): HasMany
    {
        return $this->hasMany(FundDistribution::class, 'created_by');
    }

    /**
     * Check if user is super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is manager.
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Determine whether the user can access the given Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_active && in_array($this->role, ['super_admin', 'manager'], true);
    }

    /**
     * Get the user's name for Filament displays.
     */
    public function getFilamentName(): string
    {
        return $this->name ?? 'Administrator';
    }
}
