<?php

namespace App\Filament\Resources\FundDistributions\Pages;

use App\Filament\Resources\FundDistributions\FundDistributionResource;
use App\Models\Campaign;
use App\Models\FundDistribution;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditFundDistribution extends EditRecord
{
    protected static string $resource = FundDistributionResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            $oldCampaignId = $record->campaign_id;
            $oldAmount = (float) $record->amount_spent;
            $newCampaignId = $data['campaign_id'] ?? null;
            $newAmount = (float) $data['amount_spent'];

            if ($oldCampaignId && $oldCampaignId === $newCampaignId) {
                $diff = $newAmount - $oldAmount;
                if ($diff != 0) {
                    Campaign::where('id', $oldCampaignId)->increment('distributed_amount', $diff);
                }
            } elseif ($oldCampaignId !== $newCampaignId) {
                if ($oldCampaignId) {
                    Campaign::where('id', $oldCampaignId)->decrement('distributed_amount', $oldAmount);
                }
                if ($newCampaignId) {
                    Campaign::where('id', $newCampaignId)->increment('distributed_amount', $newAmount);
                }
            }

            $record->update($data);

            return $record;
        });
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->before(function (FundDistribution $record) {
                if ($record->campaign_id) {
                    Campaign::where('id', $record->campaign_id)->decrement('distributed_amount', (float) $record->amount_spent);
                }
            }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
