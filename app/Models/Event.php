<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'banner_image',
        'location_name',
        'address',
        'google_map_link',
        'event_date',
        'start_time',
        'end_time',
        'max_participants',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'max_participants' => 'integer',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', 'upcoming')
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('event_date', '<', now()->toDateString())
              ->orWhere('status', 'completed');
        })->orderByDesc('event_date');
    }
}
