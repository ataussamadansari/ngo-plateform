<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'title',
        'beneficiary_name',
        'amount_spent',
        'distribution_date',
        'payment_reference',
        'proof_bill_image',
        'impact_photos',
        'description',
        'is_public',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amount_spent' => 'decimal:2',
            'distribution_date' => 'date',
            'impact_photos' => 'array',
            'is_public' => 'boolean',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true)->orderByDesc('distribution_date');
    }
}
