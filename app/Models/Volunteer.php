<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'volunteer_code',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'city',
        'address',
        'occupation',
        'skills',
        'area_of_interest',
        'about_volunteer',
        'availability',
        'profile_photo',
        'id_proof_path',
        'status',
        'joined_at',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'date_of_birth' => 'date',
            'joined_at' => 'date',
        ];
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
