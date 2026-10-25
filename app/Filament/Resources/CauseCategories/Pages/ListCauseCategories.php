<?php

namespace App\Filament\Resources\CauseCategories\Pages;

use App\Filament\Resources\CauseCategories\CauseCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCauseCategories extends ListRecords
{
    protected static string $resource = CauseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
