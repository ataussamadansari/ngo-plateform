<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'full_story',
        'thumbnail_image',
        'gallery_images',
        'goal_amount',
        'raised_amount',
        'distributed_amount',
        'start_date',
        'end_date',
        'is_featured',
        'is_urgent',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'goal_amount' => 'decimal:2',
            'raised_amount' => 'decimal:2',
            'distributed_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_featured' => 'boolean',
            'is_urgent' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CauseCategory::class, 'category_id');
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function verifiedDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', 'verified');
    }

    public function fundDistributions(): HasMany
    {
        return $this->hasMany(FundDistribution::class);
    }

    public function progressPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $goal = (float) $this->goal_amount;
                if ($goal <= 0) {
                    return 0;
                }
                $raised = (float) $this->raised_amount;

                return min(100, round(($raised / $goal) * 100, 1));
            }
        );
    }

    public function remainingAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => max(0, (float) $this->goal_amount - (float) $this->raised_amount)
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeUrgent(Builder $query): Builder
    {
        return $query->where('is_urgent', true);
    }
}
