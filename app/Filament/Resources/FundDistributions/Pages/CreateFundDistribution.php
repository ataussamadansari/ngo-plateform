<?php

namespace App\Filament\Resources\FundDistributions\Pages;

use App\Filament\Resources\FundDistributions\FundDistributionResource;
use App\Models\Campaign;
use App\Models\FundDistribution;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateFundDistribution extends CreateRecord
{
    protected static string $resource = FundDistributionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();

            if (! empty($data['campaign_id'])) {
                $campaign = Campaign::lockForUpdate()->findOrFail($data['campaign_id']);
                $newDistributed = (float) $campaign->distributed_amount + (float) $data['amount_spent'];
                $campaign->distributed_amount = round($newDistributed, 2);
                $campaign->save();
            }

            return FundDistribution::create($data);
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
