<?php

namespace App\Filament\Resources\CauseCategories\Pages;

use App\Filament\Resources\CauseCategories\CauseCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCauseCategory extends EditRecord
{
    protected static string $resource = CauseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
