<?php

namespace App\Filament\Resources\FundDistributions\Pages;

use App\Filament\Resources\FundDistributions\FundDistributionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFundDistributions extends ListRecords
{
    protected static string $resource = FundDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
